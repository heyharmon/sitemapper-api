<?php

namespace DDD\Http\Websites;

use Throwable;
use Illuminate\Http\Request;
use DDD\Domain\Websites\Website;
use DDD\Domain\Websites\Resources\WebsiteResource;
use DDD\Domain\Websites\Actions\CheckWebsiteRankAction;
use DDD\App\Controllers\Controller;

class WebsiteRankController extends Controller
{
    /**
     * Dispatch the rank check action for the given website and keyword.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkRank(Website $website, Request $request)
    {
        $keyword = $request->input('keyword');
        $location = $request->input('location', 'United States'); // Default to 'United States'

        // Dispatch the action as a queued job
        CheckWebsiteRankAction::dispatch($website, $keyword, $location);

        return response()->json([
            'message' => 'Rank check has been dispatched.',
            'website' => $website->domain,
            'keyword' => $keyword,
            'location' => $location,
        ]);
    }
}
