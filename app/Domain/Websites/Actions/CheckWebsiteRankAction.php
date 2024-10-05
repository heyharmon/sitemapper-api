<?php

namespace DDD\Domain\Websites\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Log;
use DDD\Domain\Websites\Website;
use DDD\App\Services\SEO\DataForSeoService;

class CheckWebsiteRankAction
{
    use AsAction;

    protected DataForSeoService $service;

    public function __construct(DataForSeoService $dataForSeoService)
    {
        $this->service = $dataForSeoService;
    }

    /**
     * Handle the ranking check.
     *
     * @param string $keyword
     * @param string $website
     * @return void
     */
    public function handle(Website $website, string $keyword, string $location): void
    {
        try {
            // Step 1: Create a new ranking task
            $taskResponse = $this->service->createTask($website->domain, $keyword, $location);

            if ($taskResponse && isset($taskResponse['tasks'][0]['id'])) {
                $taskId = $taskResponse['tasks'][0]['id'];

                // Optional: Wait for a few seconds (adjust based on typical response time)
                sleep(10);

                // Step 2: Get the task results
                $result = $this->service->getTaskResults($taskId);

                // Log the result or store it in the database
                Log::info("Rank check result for '{$keyword}' on '{$website}':", $result);
            } else {
                Log::error("Failed to create task for '{$keyword}' on '{$website}'.", $taskResponse);
            }
        } catch (\Exception $e) {
            Log::error("Exception while checking rank: " . $e->getMessage());
        }
    }
}
