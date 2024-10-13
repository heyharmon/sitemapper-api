<?php

namespace DDD\Http\Companies;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Http\Request;
use DDD\Domain\Companies\Resources\CompanyResource;
use DDD\Domain\Companies\Company;
use DDD\App\Filters\FilterNullOrNot;
use DDD\App\Controllers\Controller;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        // return $request;
        $companies = QueryBuilder::for(Company::class)
            ->allowedFilters([
                AllowedFilter::exact('category'),
                AllowedFilter::custom('website_id', new FilterNullOrNot()),
            ])
            ->withCount('contacts')
            ->orderBy('id', 'asc')
            ->paginate(50)
            ->appends(request()->query());

        return CompanyResource::collection($companies);
    }

    public function store(Request $request)
    {
        $company = Company::create($request->all());

        return new CompanyResource($company);
    }

    public function show(Company $company)
    {
        $company->load('contacts');
        
        return new CompanyResource($company);
    }

    public function update(Company $company, Request $request)
    {
        $company->update($request->all());

        return new CompanyResource($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return new CompanyResource($company);
    }
}
