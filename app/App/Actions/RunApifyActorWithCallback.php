<?php

namespace DDD\App\Actions;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use DDD\App\Services\Apify\ApifyService;

class RunApifyActorWithCallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $actorId;
    protected $input;
    protected $model;
    protected $updateCallback;

    /**
     * Create a new job instance.
     *
     * @param string $actorId
     * @param array $input
     * @param Model $model
     * @param callable $updateCallback
     */
    public function __construct(string $actorId, array $input, Model $model, callable $updateCallback)
    {
        $this->actorId = $actorId;
        $this->input = $input;
        $this->model = $model;
        $this->updateCallback = $updateCallback;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apifyService = app(ApifyService::class);

        // Start the actor with the given input
        $run = $apifyService->runActor($this->actorId, $this->input);

        // Save the execution ID to the model, if the model has the 'apify_execution_id' attribute
        if (property_exists($this->model, 'apify_execution_id')) {
            $this->model->update(['apify_execution_id' => $run->id]);
        }

        // Monitor the actor run and update the model when complete
        $this->waitForResultsAndExecuteCallback($apifyService, $run->id);
    }

    /**
     * Poll the Apify API until the run is complete, then execute the update callback.
     *
     * @param ApifyService $apifyService
     * @param string $executionId
     * @return void
     */
    protected function waitForResultsAndExecuteCallback(ApifyService $apifyService, $executionId)
    {
        $pollingInterval = 10; // Polling interval in seconds

        // Keep checking the status until the run is finished
        do {
            sleep($pollingInterval);
            $status = $apifyService->getRunStatus($executionId);
            $isFinished = $status->status === 'SUCCEEDED' || $status->status === 'FAILED';
        } while (!$isFinished);

        // If the run succeeded, fetch the results and execute the callback
        if ($status->status === 'SUCCEEDED') {
            $results = $apifyService->getRunResults($executionId);

            // Execute the callback function, passing the model and results
            call_user_func($this->updateCallback, $this->model, $results);
        }
    }
}
