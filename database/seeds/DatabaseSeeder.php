<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'name'=> Str::random(10),
        ]);

        DB::table('areas')->insert([
            'name'=> Str::random(10),
        ]);

        DB::table('areas')->insert([
            'name'=> Str::random(10),
        ]);

        DB::table('areas')->insert([
            'name'=> Str::random(10),
        ]);

        DB::table('areas')->insert([
            'name'=> Str::random(10),
        ]);
    }
}
