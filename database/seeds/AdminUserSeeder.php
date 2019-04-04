<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table("admin_user")->insert([
            "username" => "tobias290",
            "password" => bcrypt("admin")
        ]);
    }
}
