<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banques = [
            [
                'code' => 'BOA',
                'name' => 'BANK OF AFRICA',
            ],
            [
                'code' => 'ATLANTIQUE',
                'name' => 'BANQUE ATLANTIQUE',
            ],
            [
                'code' => 'BSIC',
                'name' => 'BANQUE SAHELO-SAHARIENNE POUR L’INVESTISSEMENT ET LE COMMERCE',
            ],
            [
                'code' => 'NSIA',
                'name' => 'NSIA BANQUE',
            ],
            [
                'code' => 'ECOBANK',
                'name' => 'ECOBANK',
            ],
            [
                'code' => 'ORABANK',
                'name' => 'ORABANK',
            ],
            [
                'code' => 'SGB',
                'name' => 'SOCIETE GENERALE BENIN',
            ],
            [
                'code' => 'UBA',
                'name' => 'UNITED BANK FOR AFRICA',
            ],
            [
                'code' => 'CCEI',
                'name' => 'BANGE BANK ex CCEI BANK',
            ],
            [
                'code' => 'BGFI',
                'name' => 'BGFI BANK',
            ],
            [
                'code' => 'BIIC',
                'name' => 'BANQUE INTERNATIONALE POUR L’INDUSTRIE ET LE COMMERCE ',
            ],
            [
                'code' => 'CORIS',
                'name' => 'CORIS BANK INTERNATIONAL',
            ],
            [
                'code' => 'CBAO',
                'name' => 'CBAO, GROUPE ATTIJARIWAFA BANK',
            ],
            [
                'code' => 'SONIBANK',
                'name' => 'SOCIETE NIGERIENNE DE BANK',
            ],
        ];
        foreach ($banques as $banque) {

            Bank::create([
                'code' => $banque['code'],
                'name' => $banque['name'],
            ]);
        }
    }
}
