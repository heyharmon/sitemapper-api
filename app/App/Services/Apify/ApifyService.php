<?php

namespace DDD\App\Services\Apify;

use Illuminate\Support\Facades\Http;

class ApifyService
{
    protected string $baseUrl;
    protected string $apiToken;
    protected string $actorId;

    public function __construct()
    {
        $this->baseUrl = 'https://api.apify.com/v2';
        $this->apiToken = config('services.apify.token');
    }

    /**
     * Set the actor task ID.
     *
     * @param string $actorId
     * @return void
     */
    public function setActorId(string $actorId): void
    {
        $this->actorId = $actorId;
    }

    /**
     * Run an Apify actor.
     *
     * @param  array  $input  The input data for the actor.
     * @return string  The run ID of the actor.
     */
    public function runActor(array $input): string
    {
        $response = Http::withToken($this->apiToken)
            ->post("{$this->baseUrl}/acts/{$this->actorId}/runs", [
                'input' => $input
            ]);
        
        $data = $response->json();
        
        return $data['data']['id'];
    }

    /**
     * Get the status of an Apify actor run.
     *
     * @param string $runId
     * @return string  The status of the actor run.
     */
    public function getRunStatus(string $runId): string
    {
        $statusUrl = "{$this->baseUrl}/actor-runs/{$runId}?token={$this->apiToken}";

        $response = Http::get($statusUrl);

        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['status'];
        }

        throw new \Exception('Failed to get actor run status: ' . $response->body());
    }

    /**
     * Get the result of an Apify actor run.
     *
     * @param  string  $runId
     * @return array
     */
    public function getActorResult(string $runId): array
    {
        $resultUrl = "{$this->baseUrl}/actor-runs/{$runId}/dataset/items?token={$this->apiToken}";

        $maxAttempts = 20; // Maximum number of attempts
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            $response = Http::get($resultUrl);
            $data = $response->json();

            if (!empty($data)) {
                return $data[0];
            }

            sleep(5); // Wait before polling again
            $attempts++;
        }

        throw new \Exception('Failed to get actor result: maximum attempts reached.');
    }
}
