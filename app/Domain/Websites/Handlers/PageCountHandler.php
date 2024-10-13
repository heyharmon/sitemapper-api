<?php

namespace DDD\Domain\Websites\Handlers;

use DDD\Domain\Websites\Website;

class PageCountHandler
{
    /**
     * Handle the Apify actor result.
     *
     * @param array $result
     * @return void
     */
    public function process(array $results): void
    {
        // Loop through result
        foreach ($results as $result) {
            // Find the website by URL
            $website = Website::where('url', $result['url'])->first();

            // Update the page count
            if ($website) {
                $website->update(['page_count' => $result['pages']]);
            }
        }
    }
}
