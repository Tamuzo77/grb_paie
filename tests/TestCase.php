<?php

namespace Tests;

use App\Models\Annee;
use App\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $user = \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $annee = Annee::create([
            'nom' => '2024',
            'debut' => '2024-01-01',
            'fin' => '2024-12-31',
        ]);

        $roles = [
            ['name' => 'responsable_commercial'],
            ['name' => 'directrice_operationnelle'],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }

    }
}
