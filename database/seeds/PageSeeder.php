<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $pages=['Hakkımızda','Iletişim','Haberler','Vizyon','Misyon'];
      $count=0;
      foreach ($pages as $page ) {
        $count++;
          DB::table('pages')->insert([
            'title'=>$page,
            'slug'=>Str::slug($page),
            'image'=>'https://edumag.net/wp-content/uploads/2017/11/diy-it-department-managed-it.jpg',
            'content'=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            'created_at'=>now(),
            'updated_at'=>now(),
            'order'=>$count
          ]);
      }
    }
}
