<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*User::factory()->create()->each(function ($user) {
            $user->image()->save(Image::factory()->make([
                'url' => 'public/without-image.jpg'
            ]));
        });*/

        $user = new User();
        $user->role_id = 1;
        $user->name =  'juan jose';
        $user->last_name = 'pauccara huancara';
        $user->dni = '48000000';
        $user->phone = '935000000';
        $user->date_of_birth = '1995-09-06 01:29:04';
        $user->status = "enabled";
        $user->email = 'admin@gmail.com';
        $user->email_verified_at = now();
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // passwor
        $user->remember_token = Str::random(10);
        $user->save();

        $user->image()->create(["url" => "public/without-image.jpg"]);
    }
}
