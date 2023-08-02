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
        $user = new User();
        $user->role_id = 1;
        $user->name =  'Juan Jose';
        $user->last_name = 'Pau';
        $user->dni = '48000000';
        $user->phone = '935000000';
        $user->date_of_birth = '1995-09-06 01:29:04';
        $user->status = "enabled";
        $user->email = 'admin@app.com';
        $user->email_verified_at = now();
        $user->password = '$2y$10$54tkJo77kYrCFGIFxyoxBOCP0eYjT5YKNWnYt03H9GGnq2sFlL1Me'; // supernova08
        $user->remember_token = Str::random(10);
        $user->save();

        $user->image()->create(["url" => "public/without-image.jpg"]);

        $user = new User();
        $user->role_id = 2;
        $user->name =  'Eloisa';
        $user->last_name = 'De Pau';
        $user->dni = '47000000';
        $user->phone = '934000000';
        $user->date_of_birth = '1997-12-09 01:29:04';
        $user->status = "enabled";
        $user->email = 'recep@app.com';
        $user->email_verified_at = now();
        $user->password = '$2y$10$54tkJo77kYrCFGIFxyoxBOCP0eYjT5YKNWnYt03H9GGnq2sFlL1Me'; // supernova08
        $user->remember_token = Str::random(10);
        $user->save();

        $user->image()->create(["url" => "public/without-image.jpg"]);
    }
}
