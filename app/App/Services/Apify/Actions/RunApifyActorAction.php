<?php

namespace DDD\App\Services\Apify\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Log;
use DDD\App\Services\Apify\ApifyService;

class RunApifyActorAction
{
    use AsAction;

    public int $jobTimeout = 120; // Timeout after 120 seconds
    // public int $jobBackoff = 20; // Retry every 20 seconds
    // public int $jobTries = 10; // Retry 10 times

    protected ApifyService $service;

    public function __construct(ApifyService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the action.
     *
     * @param string $actorId
     * @param array $input
     * @param string $handlerClass
     * @param ApifyService $apifyService
     * @return void
     */
    public function handle(string $actorId, array $input, string $handlerClass)
    {
        // Start the actor run
        $runId = $this->service->runActor($actorId, $input);

        // Poll for the result
        $maxAttempts = 20;
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            sleep(5); // Wait 5 seconds before polling again

            $status = $this->service->getRunStatus($runId);

            if ($status === 'SUCCEEDED') {
                $result = $this->service->getActorResult($runId);

                if ($result) {
                    // Instantiate the handler class and process the result
                    $handler = app($handlerClass);
                    $handler->process($result);
                }

                return;
            } elseif (in_array($status, ['FAILED', 'ABORTED', 'TIMED-OUT'])) {
                // Handle failure
                Log::error("Apify actor run failed with status: {$status}");
                return;
            }

            $attempts++;
        }

        Log::warning('Apify actor run did not complete within the expected time.');
    }
}
