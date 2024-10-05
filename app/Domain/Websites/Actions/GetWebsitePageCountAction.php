<?php

namespace DDD\Domain\Websites\Actions;

use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Log;
use DDD\Domain\Websites\Website;
use DDD\App\Services\Apify\ApifyService;

class GetWebsitePageCountAction extends Action
{
    protected ApifyService $apifyService;

    public function __construct(ApifyService $apifyService)
    {
        $this->apifyService = $apifyService;
        $this->apifyService->setActorId('heyharmon~apify-sitemap-crawler');
    }

    /**
     * Run the action.
     *
     * @param  Website  $website
     * @return void
     */
    public function handle(Website $website): void
    {
        try {
            $runId = $this->apifyService->runActor(['url' => $website->url]);

            $result = $this->apifyService->getActorResult($runId);

            $website->update(['page_count' => $result['totalPages']]);
        } catch (\Exception $e) {
            Log::error('Failed to get page count for website: ' . $e->getMessage());
        }
    }
}
