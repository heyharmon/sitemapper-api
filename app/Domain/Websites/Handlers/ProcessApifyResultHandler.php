<?php

namespace DDD\Domain\Websites\Handlers;

use DDD\Domain\Websites\Website;

class ProcessApifyResultHandler
{
    /**
     * Handle the Apify actor result.
     *
     * @param array $result
     * @return void
     */
    public function process(array $result): void
    {
        // Loop through result
        foreach ($result as $site) {
            // Find the website by URL
            $website = Website::where('url', $site['url'])->first();

            // Update the page count
            if ($website) {
                $website->update(['page_count' => $site['pages']]);
            }
        }
    }
}
