<?php

namespace Database\Seeders;

use App\Models\Pengaturan\User;
use App\Models\Pengaturan\UserLevel;
use Illuminate\Database\Seeder;
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
        $user_level = UserLevel::create([
            'nama' => 'Superadmin',
            'keterangan' => 'Top level user'
        ]);
        $user = User::create([
            'user_level_id' => $user_level->id,
            'nama' => 'Superadmin',
            'email' => 'super@admin.com',
        ]);
        $user->password = Hash::make('4rt1s4n');
        $user->save();
    }
}
