<?php

namespace DDD\Http\Websites;

use Illuminate\Http\Request;
use DDD\Domain\Websites\Website;
use DDD\Domain\Websites\Resources\WebsiteResource;
use DDD\App\Controllers\Controller;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();

        return WebsiteResource::collection($websites);
    }

    public function store(Request $request)
    {
        $website = Website::create([
            'domain' => $request->url,
        ]);

        return new WebsiteResource($website);
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
