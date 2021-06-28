<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'product 1',
                'image' => '/image/product.jpg',
                'price' => '1.00'  ,
                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ],
            [
                'name' => 'product 2',
                'image' => '/image/product.jpg',
                'price' => '2.00'  ,
                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ],
            [
                'name' => 'product 3',
                'image' => '/image/product.jpg',
                'price' => '3.00'  ,
                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ],
            [
                'name' => 'product 4',
                'image' => '/image/product.jpg',
                'price' => '4.00'  ,
                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ],
        ]);
    }
}
