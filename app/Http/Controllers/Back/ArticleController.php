<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles=Article::orderBy('created_at','ASC')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Categories::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->post());
        $request->validate([
          'title'=>'min:3',
          'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
       $article=new Article;
        $article->title=$request->title;
        $article->slug=Str::slug($request->title);
      //  $article->image=$request
        $article->category_id=$request->category;
        $article->content=$request->content;
        if($request->hasFile('image')){
          //$imageName=Str::slug($request->title).rand(10000,99999).'.'.$request->image->getClientOriginalExtension();
           $imageName=Str::slug($request->title).'-'.rand(10000,99999).'.'.$request->image->getClientOriginalExtension();
           $request->image->move(public_path('uploads'),$imageName);
           $article->image="uploads/".$imageName;
        }
        $article->save();
        toastr()->success('Başarılı!', 'Miracle Max Says');
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id." maka";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $categories=Categories::all();
      $articles = Article::findOrFail($id);

      return view('back.articles.update',compact('categories','articles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'title'=>'min:3',
        'image'=>'image|mimes:jpeg,png,jpg|max:2048'
      ]);
      $article=Article::findOrFail($id);
      $article->title=$request->title;
      $article->slug=Str::slug($request->title);
    //  $article->image=$request
      $article->category_id=$request->category;
      $article->content=$request->content;
      if($request->hasFile('image')){
        //$imageName=Str::slug($request->title).rand(10000,99999).'.'.$request->image->getClientOriginalExtension();
         $imageName=Str::slug($request->title).'-'.rand(10000,99999).'.'.$request->image->getClientOriginalExtension();
         $request->image->move(public_path('uploads'),$imageName);
         $article->image="uploads/".$imageName;
      }
      $article->save();
      toastr()->success('Başarılı!', 'Miracle Max Says');
      return redirect()->route('admin.makaleler.index');

    }
    public function switch(Request $request)
    {
      $article=Article::findOrFail($request->id);
      $article->status=$request->statu=="true" ? 1:0;
      $article->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Article::find($id)->delete();
        toastr()->success('Başarılı!', 'Silindi');
        return redirect()->route('admin.makaleler.index');

    }
    public function hardDelete($id)
    {
        $article=Article::onlyTrashed()->find($id);
        if(File::exists($article->image)){
          File::delete(public_path($article->image));
        }
        $article->forceDelete();
        toastr()->success('Başarılı!', 'Silinen makalelere taşndı');
        return redirect()->route('admin.makaleler.index');

    }
    public function trashed()
    {
      // silinmiş olan makaleleri getirmek için
      $articles=Article::onlyTrashed()->orderBy('deleted_at','ASC')->get();
      return view('back.articles.trashed',compact('articles'));
    }
    public function recolver($id)
    {
      // silinen veriyi geri getirmek için kullanılan
      Article::onlyTrashed()->find($id)->restore();
      toastr()->success('Makale Başarıyla Geri Getirildi');
      return redirect()->back();

    }
}
