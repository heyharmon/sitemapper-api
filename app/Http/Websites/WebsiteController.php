<?php

namespace DDD\Http\Websites;

use Throwable;
use Illuminate\Http\Request;
use DDD\Domain\Websites\Website;
use DDD\Domain\Websites\Resources\WebsiteResource;
use DDD\Domain\Companies\Company;
use DDD\App\Controllers\Controller;

class WebsiteController extends Controller
{
    public function index(Company $company)
    {
        $websites = $company->websites;

        return WebsiteResource::collection($websites);
    }

    public function store(Company $company, Request $request)
    {
        $website = $company->websites()->create($request->all());

        return new WebsiteResource($website);
    }

    public function show(Company $company, Website $website)
    {
        return new WebsiteResource($website);
    }

    public function update(Company $company, Website $website, Request $request)
    {
        $website->update($request->all());

        return new WebsiteResource($website);
    }

    public function destroy(Company $company, Website $website)
    {
        $website->delete();

        return new WebsiteResource($website);
    }
}
