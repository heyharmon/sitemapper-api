<?php

namespace DDD\Domain\Companies\Handlers;

use DDD\Domain\Companies\Company;

class UtahPrincipalsHandler
{
    /**
     * Handle the Apify actor result.
     *
     * @param array $result
     * @return void
     */
    public function process(array $results): void
    {
        foreach ($results as $result) {
            $company = Company::where('id', $result['companyId'])->first();

            if ($company) {

                foreach ($result['principals'] as $principal) {
                    $company->contacts()->create([
                        'role' => $principal['title'],
                        'name' => $principal['name'],
                        'metadata' => [
                            'businessRegistrationEntityName' => $result['entityName'],
                            'businessRegistrationAddress' => $principal['address'],
                            'businessRegistrationLastUpdated' => $principal['lastUpdated'],
                        ]
                    ]);
                }

            }

        }

    }
}
