<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;
use File;
class PageController extends Controller
{


  public function orders(Request $request)
  {
    //print_r($request->get('orders'));
    foreach ($request->get('page') as $key => $order) {
      Page::where('id',$order)->update(['order'=>$key]);
    }
  }


    public function index()
    {
      $pages=Page::all();
      return view('back.pages.index',compact('pages'));
    }
    public function create()
    {
      return view('back.pages.create');
    }

    public function update($id)
    {
      $pages = Page::findOrFail($id);
      return view('back.pages.update',compact('pages'));
    }
    public function updatePost(Request $request, $id)
    {
      $request->validate([
        'title'=>'min:3',
        'image'=>'image|mimes:jpeg,png,jpg|max:2048'
      ]);
      $page=page::findOrFail($id);
      $page->title=$request->title;
      $page->slug=Str::slug($request->title);
    //  $page->image=$request
      $page->content=$request->content;
      if($request->hasFile('image')){
        //$imageName=Str::slug($request->title).rand(10000,99999).'.'.$request->image->getClientOriginalExtension();
         $imageName=Str::slug($request->title).'-'.rand(10000,99999).'.'.$request->image->getClientOriginalExtension();
         $request->image->move(public_path('uploads'),$imageName);
         $page->image="uploads/".$imageName;
      }
      $page->save();
      toastr()->success('Başarılı!', 'Miracle Max Says');
      return redirect()->route('admin.page.index');

    }
    public function switch(Request $request)
    {
      $Page=Page::findOrFail($request->id);
      $Page->status=$request->statu=="true" ? 1:0;
      $Page->save();
    }
    public function post(Request $request)
    {
      $request->validate([
        'title'=>'min:3',
        'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
      ]);
      $orderCount=Page::orderBy('order','DESC')->first();
      $page=new Page;
      $page->title=$request->title;
      $page->slug=Str::slug($request->title);
    //  $page->image=$request
      $page->content=$request->content;
      $page->order=$orderCount->order+1;
      if($request->hasFile('image')){
        //$imageName=Str::slug($request->title).rand(10000,99999).'.'.$request->image->getClientOriginalExtension();
         $imageName=Str::slug($request->title).'-'.rand(10000,99999).'.'.$request->image->getClientOriginalExtension();
         $request->image->move(public_path('uploads'),$imageName);
         $page->image="uploads/".$imageName;
      }
      $page->save();
      toastr()->success( 'Sayfa oluşturuldu');
      return redirect()->route('admin.page.index');
    }

    public function remove(Request $request)
    {

      $page=Page::find($request->id);
      if(File::exists($page->image)){
        File::delete(public_path($page->image));
      }

      $deg=Page::find($request->id)->delete();;
      if($deg){
        return "yes";
      }else{
        return "no";
      }
    }

}
