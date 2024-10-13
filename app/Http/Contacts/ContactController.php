<?php

namespace DDD\Http\Contacts;

use Illuminate\Http\Request;
use DDD\Domain\Contacts\Resources\ContactResource;
use DDD\Domain\Contacts\Contact;
use DDD\Domain\Companies\Company;
use DDD\App\Controllers\Controller;

class ContactController extends Controller
{
    public function index(Company $company, Request $request)
    {
        $contacts = $company->contacts;

        return ContactResource::collection($contacts);
    }

    public function store(Company $company, Request $request)
    {
        $contact = $company->contacts()->create($request->all());

        return new ContactResource($contact);
    }

    public function show(Company $company, Contact $contact)
    {
        return new ContactResource($contact);
    }

    public function update(Company $company, Contact $contact, Request $request)
    {
        $contact->update($request->all());

        return new ContactResource($contact);
    }

    public function destroy(Company $company, Contact $contact)
    {
        $contact->delete();

        return new ContactResource($contact);
    }
}
