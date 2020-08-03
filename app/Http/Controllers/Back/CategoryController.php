<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Categories;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
      $categories=Categories::all();
      return view('back.categories.index',compact('categories'));
    }
    public function switch(Request $request)
    {
      $categori=Categories::findOrFail($request->id);
      $categori->status=$request->statu=="true" ? 1:0;
      $categori->save();
    }
    public function getData(Request $request)
    {
      $categori=Categories::findOrFail($request->id);
      return response()->json($categori);
    }
    public function create(Request $request)
    {
        $catCount=Categories::where('slug',Str::slug($request->category))->count();
        if($catCount==0){
          $categori=new Categories;
          $categori->name=ucfirst($request->category);
          $categori->slug=Str::slug($request->category);
          $categori->save();
          toastr()->success($request->category.' kategorisini eklediniz', 'Başarılı');
          return redirect()->back();
        }else{
          return redirect()->route('admin.category.index')->with('hata', $request->category.' isminde bir kategoriniz bulunmaktadır.');
        }
    }
    public function update(Request $request)
    {
        $catCount=Categories::where('slug',Str::slug($request->category))->whereNotIn('id',[$request->id])->count();
        if($catCount==0){
          $categori=Categories::find($request->id);
          $categori->name=ucfirst($request->category);
          $categori->slug=Str::slug($request->category);
          $categori->save();
          toastr()->success($request->category.' kategorisiniz güncellendi', 'Başarılı');
          return redirect()->back();
        }else{
          toastr()->error($request->category.' kategorisine sahipsiniz', 'Başarısız');
          return redirect()->route('admin.category.index');
        }
    }

    public function remove(Request $request)
    {
      $req=Categories::find($request->id)->delete();
      if($req){
        return "yes";
      }else{
        return "no";
      }
    }


}
