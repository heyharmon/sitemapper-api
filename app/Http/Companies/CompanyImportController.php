<?php

namespace DDD\Http\Companies;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DDD\Domain\Websites\Website;
use DDD\Domain\Companies\Company;
use DDD\App\Services\Url\UrlService;
use DDD\App\Controllers\Controller;

class CompanyImportController extends Controller
{
    public function outscraper(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('csv_file');

        // Open and read the CSV file
        if (($fileHandle = fopen($file->getRealPath(), 'r')) === false) {
            return response()->json(['message' => 'Unable to open the CSV file.',], 207);
        }

        // Get the header row from CSV
        $header = fgetcsv($fileHandle);

        if ($header === false) {
            fclose($fileHandle);

            return response()->json(['message' => 'The CSV is empty.',], 207);
        }

        // Process each row in the CSV file
        while (($row = fgetcsv($fileHandle)) !== false) {
            // Create an associative array of column => value
            $rowData = array_combine($header, $row);

            if ($rowData === false) {
                // Handle the error if the number of columns doesn't match
                continue;
            }

            if ($rowData['business_status'] !== 'OPERATIONAL') {
                continue;
            }

            // Manually map CSV columns to database columns during updateOrCreate
            $company = Company::updateOrCreate(
                ['name' => $rowData['owner_title']], // Identifier column
                [
                    'name'  => $rowData['name'],
                    'type'  => 'mover',
                    'phone'  => $rowData['phone'],
                    'address' => $rowData['full_address'],
                    'state'  => $rowData['state'],
                    'city'  => $rowData['city'],
                    'zip'  => $rowData['postal_code'],
                    'latitude' => (float)$rowData['latitude'],
                    'longitude' => (float)$rowData['longitude'],
                    'google_place_id' => $rowData['place_id'],
                    'google_rating' => (int)$rowData['rating'],
                    'google_reviews' => (int)$rowData['reviews'],
                ]
            );

            if ($rowData['site'] !== '') {
                $website = Website::firstOrCreate(
                    ['domain' => UrlService::getHost($rowData['site'])],
                );

                $company->website()->associate($website);
                $company->save();
            }
        }

        fclose($fileHandle);

        return response()->json([
            'message' => 'CSV imported successfully.',
        ], 201); // Created
    }
}
