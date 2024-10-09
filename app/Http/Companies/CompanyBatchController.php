<?php

namespace DDD\Http\Companies;

use Illuminate\Http\Request;
use DDD\Domain\Websites\Handlers\ProcessApifyResultHandler;
use DDD\Domain\Companies\Company;
use DDD\App\Services\Apify\Actions\RunApifyActorAction;
use DDD\App\Controllers\Controller;

class CompanyBatchController extends Controller
{
    public function getWebsitesPageCount(Request $request)
    {   
        $companies = Company::whereIn('id', $request->ids)->get();

        foreach ($companies as $company) {
            if ($company->website) {
                RunApifyActorAction::dispatch('heyharmon~apify-sitemap-crawler', ['urls' => [$company->website->url]], ProcessApifyResultHandler::class);
            }
        }

        return response()->json([
            'message' => 'Action dispatched',
        ]);
    }

}
