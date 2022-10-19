<?php

namespace Database\Seeders;

use App\Models\Master\Team;
use Illuminate\Database\Seeder;

class MasterTeamSeeder extends Seeder
{
    public function run()
    {
        $team = [
            [
                'name'          => 'Team 1',
            ],
            [
                'name'          => 'Team 2',
            ],
            [
                'name'          => 'Team 3',
            ],
        ];

        $this->generate($team);
    }

    public function generate($team)
    {
        ini_set("memory_limit", -1);

        foreach ($team as $val) {
            // $this->command->getOutput()->progressAdvance();
            $team = Team::firstOrNew(['name' => $val['name']]);
           // $team->level   = $val['level'];
            $team->name    = $val['name'];
            $team->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
