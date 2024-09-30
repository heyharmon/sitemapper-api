<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DDD\Domain\Base\Organizations\Organization;

class LocalCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            [
                'name' => 'A Real Company', 
                'type' => 'company'
            ],
        ];

        foreach ($organizations as $organization) {
            Organization::create($organization);
        }
    }
}
