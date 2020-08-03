<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------

*/

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
  //Route::get('admin/cikis','Back\authController@logout')->name('admin.logout');
  // tekrar tekrar admin yazmayı önlemek için
  // name ise name önündeki admin. yı da grup haline getirdik
  // makale route
  Route::get('makaleler/silinenler','Back\ArticleController@trashed')->name('trashed.article');
  Route::get('/recolverarticle/{id}','Back\ArticleController@recolver')->name('recolver.article');
  Route::get('/harddeletearticle/{id}','Back\ArticleController@hardDelete')->name('hard.delete.article');
  Route::get('panel','Back\Dashboard@index')->name('dashboard');
  Route::resource('makaleler','Back\ArticleController');

  Route::get('admin/cikis','Back\AuthController@logout')->name('logout');
  Route::get('/switch','Back\ArticleController@switch')->name('switch');
  // kategori Route
  Route::get('/kategoriler','Back\CategoryController@index')->name('category.index');
  Route::post('/kategoriler/create','Back\CategoryController@create')->name('category.create');
  Route::post('/kategoriler/update','Back\CategoryController@update')->name('category.update');
  Route::get('/kategori/remove','Back\CategoryController@remove')->name('category.remove');
  Route::get('/kategori/status','Back\CategoryController@switch')->name('category.switch');
  Route::get('/kategori/getData','Back\CategoryController@getData')->name('category.getData');
  Route::get('/sayfalar','Back\PageController@index')->name('page.index');
  Route::get('/sayfa/status','Back\PageController@switch')->name('page.switch');
  Route::get('/sayfalar/olustur','Back\PageController@create')->name('page.create');
  Route::post('/sayfalar/olustur','Back\PageController@post')->name('page.create.post');
  Route::get('/sayfalar/duzenle/{id}','Back\PageController@update')->name('page.edit');
  Route::post('/sayfalar/duzenle/{id}','Back\PageController@updatePost')->name('page.edit.post');
  Route::get('/sayfa/remove','Back\PageController@remove')->name('page.remove');
  Route::get('/sayfa/siralama','Back\PageController@orders')->name('page.orders');


});
Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function(){
  Route::get('giris','Back\AuthController@login')->name('login');
  Route::post('giris','Back\AuthController@loginpost')->name('login.post');
});





/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------

*/

Route::get('/', 'Front\Homepage@index')->name('homepage');
Route::get('sayfa','Front\Homepage@index');
Route::get('/iletisim','Front\Homepage@contact')->name('contact');
Route::post('/iletisim','Front\Homepage@contactPost')->name('contact.post');
Route::get('/kategori/{category}','Front\Homepage@category')->name('category');
Route::get('/{category}/{slug}','Front\Homepage@single')->name('single');
Route::get('/{sayfa}','Front\Homepage@page')->name('page');
