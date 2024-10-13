<?php

namespace DDD\Http\Companies;

use Illuminate\Http\Request;
use DDD\Domain\Websites\Handlers\PageCountHandler;
use DDD\Domain\Companies\Handlers\UtahPrincipalsHandler;
use DDD\Domain\Companies\Company;
use DDD\App\Services\Apify\Actions\RunApifyActorAction;
use DDD\App\Controllers\Controller;

class CompanyEnrichmentController extends Controller
{
    public function getWebsitesPageCount(Request $request)
    {   
        $companies = Company::whereIn('id', $request->ids)->get();

        foreach ($companies as $company) {
            if ($company->website) {
                RunApifyActorAction::dispatch(
                    'heyharmon~apify-page-counter', 
                    [
                        'urls' => [$company->website->url]
                    ], 
                    PageCountHandler::class
            );
            }
        }

        return response()->json([
            'message' => 'Action dispatched',
        ]);
    }

    public function getUtahPrincipals(Request $request)
    {
        $companies = Company::whereIn('id', $request->ids)->get();

        foreach ($companies as $company) {
            RunApifyActorAction::dispatch(
                'heyharmon~apify-utah-business-crawler', 
                [
                    'companyId' => $company->id,
                    'companyName' => $company->name,
                ], 
                UtahPrincipalsHandler::class
            );
        }

        return response()->json([
            'message' => 'Action dispatched',
        ]);
    }
}
