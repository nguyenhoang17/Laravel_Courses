<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::checkIssetBeforeCreate([
            'name' => 'admin',
            'email' => 'admin@zent.vn',
            'phone' => '0961130648',
            'password' => Hash::make('Zent@123456'),
            'role' => 'admin',
            'address'=> 'Ha Noi',
            'gender'=> Staff::GENDER_FEMALE,
            'status' => Staff::STATUS['ACTIVE']
        ]);
    }

    public function checkIssetBeforeCreate($data) {
        $admin = Staff::where('email', $data['email'])->first();
        if (empty($admin)) {;
            Staff::create($data);
        } else {
            $admin->update($data);
        }
    }
}
