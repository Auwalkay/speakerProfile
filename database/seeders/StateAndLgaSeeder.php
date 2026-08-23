<?php

namespace Database\Seeders;

use App\Models\Lga;
use App\Models\State;
use Illuminate\Database\Seeder;

class StateAndLgaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Federal Capital Territory' => ['Abaji', 'Bwari', 'Gwagwalada', 'Kuje', 'Kwali', 'Municipal'],
            'Lagos' => ['Agege', 'Alimosho', 'Ikeja', 'Ikorodu', 'Lagos Island', 'Lagos Mainland', 'Surulere'],
            'Kano' => ['Fagge', 'Gwale', 'Kano Municipal', 'Nassarawa', 'Tarauni'],
            'Rivers' => ['Obio-Akpor', 'Port Harcourt', 'Eleme', 'Oyigbo', 'Bonny'],
            'Kaduna' => ['Kaduna North', 'Kaduna South', 'Zaria', 'Sabon Gari'],
            'Enugu' => ['Enugu North', 'Enugu South', 'Enugu East', 'Nsukka'],
            'Anambra' => ['Awka South', 'Onitsha North', 'Onitsha South', 'Nnewi North'],
            'Oyo' => ['Ibadan North', 'Ibadan North-East', 'Ibadan North-West', 'Ibadan South-East', 'Ibadan South-West'],
        ];

        foreach ($data as $stateName => $lgas) {
            $state = State::create(['name' => $stateName]);
            foreach ($lgas as $lgaName) {
                Lga::create([
                    'state_id' => $state->id,
                    'name' => $lgaName,
                ]);
            }
        }
    }
}
