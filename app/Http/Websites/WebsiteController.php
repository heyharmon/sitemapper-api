<?php

namespace DDD\Http\Websites;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Http\Request;
use DDD\Domain\Websites\Website;
use DDD\Domain\Websites\Resources\WebsiteResource;
use DDD\Domain\Base\Organizations\Organization;
use DDD\Domain\Funnels\Requests\FunnelUpdateRequest;
use DDD\Domain\Funnels\Funnel;
use DDD\App\Controllers\Controller;
use DDD\App\Services\Url\UrlService;

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
            'domain' => UrlService::getDomain($request->url),
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
            'domain' => UrlService::getDomain($request->url),
        ]);

        return new WebsiteResource($website);
    }

    public function destroy(Website $website)
    {
        $website->delete();

        return new WebsiteResource($website);
    }
}
