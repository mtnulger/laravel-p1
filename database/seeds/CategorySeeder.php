<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
//$slug = Str::slug('Laravel 5 Framework', '-');
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $categorys=['Bilgisayar Mühendisliği','Ağ Sistemleri','Bilişim','Bilgisayar Ağları'];

      foreach ($categorys as $categori ) {
          DB::table('categories')->insert([
            'name'=>$categori,
            'slug'=>Str::slug($categori),
            'created_at'=>now(),
            'updated_at'=>now()

          ]);
      }

    }
}
