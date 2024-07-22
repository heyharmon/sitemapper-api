<?php

namespace DDD\Http\Pages;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Http\Request;
use DDD\Domain\Websites\Website;
use DDD\Domain\Pages\Resources\PageResource;
use DDD\Domain\Pages\Page;
use DDD\App\Controllers\Controller;

class PageController extends Controller
{
    public function index(Website $website)
    {
        $pages = QueryBuilder::for(Page::class)
            ->where('website_id', $website->id)
            // ->allowedFilters([
            //     AllowedFilter::exact('category.id')
            // ])
            ->get();

        return PageResource::collection($pages);
    }

    public function store(Website $website, Request $request)
    {
        $page = $website->pages()->create([
            'title' => $request->title,
            'url' => $request->url,
            'path' => $request->url,
        ]);

        return new PageResource($page);
    }

    public function show(Website $website, Page $page)
    {
        return new PageResource($page);
    }

    public function update(Website $website, Page $page, Request $request)
    {
        $page->update([
            'title' => $request->title,
            'url' => $request->url,
            'path' => $request->url,
        ]);

        return new PageResource($page);
    }

    public function destroy(Website $website, Page $page)
    {
        $page->delete();

        return new PageResource($page);
    }
}
