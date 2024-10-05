<?php

namespace DDD\App\Services\SEO;

use Illuminate\Support\Facades\Http;

class DataForSeoService
{
    protected $apiUrl;
    protected $login;
    protected $password;

    public function __construct()
    {
        $this->apiUrl = 'https://api.dataforseo.com/v3/serp/google/organic';
        $this->login = config('services.dataforseo.login');
        $this->password = config('services.dataforseo.password');
    }

    /**
     * Create a ranking task for the given keyword and website.
     *
     * @param string $domain
     * @param string $keyword
     * @param string $location
     * @return array|null
     */
    public function createTask(string $domain, string $keyword, string $location): ?array
    {
        $taskData = [
            'location_name' => $location,
            'keyword' => $keyword,
            'target' => $domain,
            'language_name' => 'English',
        ];

        $response = Http::withBasicAuth($this->login, $this->password)
            ->post("{$this->apiUrl}/task_post", [$taskData]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Retrieve the results of the created ranking task.
     *
     * @param string $taskId
     * @return array|null
     */
    public function getTaskResults(string $taskId): ?array
    {
        $response = Http::withBasicAuth($this->login, $this->password)
            ->get("{$this->apiUrl}/task_get/{$taskId}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}