<?php

namespace DDD\Http\Websites;

use Throwable;
use Illuminate\Http\Request;
use DDD\Domain\Websites\Website;
use DDD\Domain\Websites\Resources\WebsiteResource;
use DDD\App\Controllers\Controller;
use DDD\App\Actions\GetScreenshotAction;
use DDD\App\Actions\GetFaviconAction;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();

        return WebsiteResource::collection($websites);
    }

    public function store(Request $request)
    {
        $website = new Website([
            'domain' => $request->url,
        ]);

        try {
            $screenshot = GetScreenshotAction::run('https://' . $website->domain);
            $favicon = GetFaviconAction::run($website->domain);

            // Store website
            $website->screenshot_file_id = $screenshot->id;
            $website->favicon_file_id = $favicon->id;
            $website->save();
    
            return new WebsiteResource($website);
        } catch (Throwable $t) {
            return response()->json(['error' => 'Failed to create website: ' . $t], 500);
        }
    }

    public function show(Website $website)
    {
        return new WebsiteResource($website);
    }

    public function update(Website $website, Request $request)
    {
        $website->update([
            'domain' => $request->url,
        ]);

        return new WebsiteResource($website);
    }

    public function destroy(Website $website)
    {
        $website->delete();

        return new WebsiteResource($website);
    }
}
