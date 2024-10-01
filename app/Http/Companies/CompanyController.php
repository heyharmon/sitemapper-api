<?php

namespace DDD\Http\Companies;

use Illuminate\Http\Request;
use DDD\Domain\Companies\Resources\CompanyResource;
use DDD\Domain\Companies\Company;
use DDD\App\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(20);

        return CompanyResource::collection($companies);
    }

    public function store(Request $request)
    {
        $company = Company::create($request->all());

        return new CompanyResource($company);
    }

    public function show(Company $company)
    {
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
