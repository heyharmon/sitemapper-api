<?php

namespace DDD\App\Services\Apify;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApifyService
{
    protected string $baseUrl;
    protected string $apiToken;

    public function __construct()
    {
        $this->baseUrl = 'https://api.apify.com/v2';
        $this->apiToken = config('services.apify.token');
    }

    /**
     * Run an Apify actor.
     *
     * @param string $actorId
     * @param array $input
     * @return string The run ID of the actor.
     */
    public function runActor(string $actorId, array $input): string
    {
        Log::info($input);
        $response = Http::withToken($this->apiToken)
            ->post("{$this->baseUrl}/acts/{$actorId}/runs", $input);

        $data = $response->json();

        // Log $data to see what the response looks like
        Log::info($data);

        return $data['data']['id'];
    }

    /**
     * Get the status of an Apify actor run.
     *
     * @param string $runId
     * @return string|null The status of the actor run.
     */
    public function getRunStatus(string $runId): ?string
    {
        $statusUrl = "{$this->baseUrl}/actor-runs/{$runId}?token={$this->apiToken}";

        $response = Http::get($statusUrl);

        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['status'];
        }

        return null;
    }

    /**
     * Get the result of an Apify actor run.
     *
     * @param string $runId
     * @return array|null
     */
    public function getActorResult(string $runId): ?array
    {
        $resultUrl = "{$this->baseUrl}/actor-runs/{$runId}/dataset/items?token={$this->apiToken}";

        $response = Http::get($resultUrl);

        if ($response->successful()) {
            $data = $response->json();
            return $data ?? null;
        }

        return null;
    }
}
