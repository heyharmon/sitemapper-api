<?php

namespace DDD\Http\Websites;

use DDD\Domain\Websites\Website;
use DDD\Domain\Websites\Actions\GetWebsitePageCountAction;
use DDD\App\Controllers\Controller;

class WebsitePagecountController extends Controller
{
    public function store(Website $website)
    {
        GetWebsitePageCountAction::dispatch($website);

        return response()->json([
            'message' => 'Action dispatched',
        ]);
    }

}
