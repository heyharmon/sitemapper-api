<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DDD\Domain\Base\Organizations\Organization;

class LocalOrganizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            ['title' => 'Acme'],
        ];

        foreach ($organizations as $organization) {
            Organization::create($organization);
        }
    }
}
