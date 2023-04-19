<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [ 'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('1234'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
        ]);  
        DB::table('debit_credit_accounts')->insert([
            [ 'name' => 'Sale'],
            [ 'name' => 'Cash'],
        ]);  
        DB::table('banks')->insert([
            [ 'name' => 'Al Baraka Bank (Pakistan) Limited'],
            [ 'name' => 'Allied Bank Limited (ABL)'],
            [ 'name' => 'Askari Bank'],
            [ 'name' => 'Bank Alfalah Limited (BAFL)'],
            [ 'name' => 'Bank Al-Habib Limited (BAHL)'],
            [ 'name' => 'BankIslami Pakistan Limited'],
            [ 'name' => 'Bank of Punjab (BOP)'],
            [ 'name' => 'Bank of Khyber'],
            [ 'name' => 'Deutsche Bank A.G'],
            [ 'name' => 'Dubai Islamic Bank Pakistan Limited (DIB Pakistan)'],
            [ 'name' => 'Faysal Bank Limited (FBL)'],
            [ 'name' => 'First Women Bank Limited'],
            [ 'name' => 'Habib Bank Limited (HBL)'],
            [ 'name' => 'Habib Metropolitan Bank Limited'],
            [ 'name' => 'Industrial and Commercial Bank of China'],
            [ 'name' => 'Industrial Development Bank of Pakistan'],
            [ 'name' => 'JS Bank Limited'],
            [ 'name' => 'MCB Bank Limited'],
            [ 'name' => 'MCB Islamic Bank Limited'],
            [ 'name' => 'Meezan Bank Limited'],
            [ 'name' => 'National Bank of Pakistan (NBP)'],
            [ 'name' => 'Summit Bank Pakistan'],
            [ 'name' => 'Standard Chartered Bank (Pakistan) Limited (SC Pakistan)'],
            [ 'name' => 'Sindh Bank'],
            [ 'name' => 'The Bank of Tokyo-Mitsubishi UFJ (MUFG Bank Pakistan)'],
            [ 'name' => 'United Bank Limited (UBL)'],
            [ 'name' => 'Zarai Taraqiati Bank Limited'],
        ]);  
        DB::table('users')->insert([
            [ 'username' => 'abrar',
            'type' => 'Site',
            'password' => Hash::make('1234'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
            [ 'username' => 'loomba',
            'type' => 'Site',
            'password' => Hash::make('1234'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
        ]);  
        DB::table('products')->insert([
            [ 
                'name' => 'Petrol',
                'purchasing_price' => '252',
                'selling_price' => '270',
            ],
            [ 
                'name' => 'Diesel',
                'purchasing_price' => '252',
                'selling_price' => '270',
            ],
        ]);  
        for($i = 5;$i<9;$i++)
        {
            DB::table('machines')->insert([
                [ 
                    'meter_reading' => '7500',
                    'boot_number' => $i,
                    'product_id' => 2,
                    'user_id' => 1,
                ]
            ]);  
        }
        for($i = 1;$i<5;$i++)
        {
            DB::table('machines')->insert([
                [ 
                    'meter_reading' => '7500',
                    'boot_number' => $i,
                    'product_id' => 1,
                    'user_id' => 1,
                ]
            ]);  
        }
        DB::table('information')->insert([
            [ 
             'name' => 'Petroleum Software',
             'phone' => '923030672683',
             'email' => 'dummy@gmail.com',
             'address' => 'Sargodha',
             'home_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            ], 
        ]);
    }
}
