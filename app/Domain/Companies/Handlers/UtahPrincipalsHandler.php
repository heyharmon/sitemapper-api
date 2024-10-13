<?php

namespace DDD\Domain\Companies\Handlers;

use DDD\Domain\Companies\Company;

class UtahPrincipalsHandler
{
    /**
     * Handle the Apify actor result.
     *
     * @param array $results
     * @return void
     */
    public function process(array $results): void
    {
        foreach ($results as $result) {
            $company = Company::where('id', $result['companyId'])->first();

            if (!$company) {
                continue;
            }

            foreach ($result['principals'] as $principal) {
                // Split the name by spaces
                $nameParts = explode(' ', $principal['name']);
                $firstName = ucfirst(strtolower($nameParts[0])); // Take first part of name
                $lastName = ucfirst(strtolower(end($nameParts))); // Take last part of name
            
                $contactData = [
                    'source' => 'utah-principals',
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'role' => $principal['title'],
                    'metadata' => [
                        'businessRegistrationEntityName' => ucwords(strtolower($result['entityName'])), // Format entityName to title case
                        'businessRegistrationAddress' => ucwords(strtolower($principal['address'])), // Format address to title case
                        'businessRegistrationLastUpdated' => $principal['lastUpdated'],
                    ],
                ];
            
                // Attempt to find an existing contact with the same first and last name
                $contact = $company->contacts()
                    ->where('first_name', $firstName)
                    ->where('last_name', $lastName)
                    ->first();
            
                if ($contact) {
                    // Update the existing contact
                    $contact->update($contactData);
                } else {
                    // Create a new contact
                    $company->contacts()->create($contactData);
                }
            }
        }
    }
}
