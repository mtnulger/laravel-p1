<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Article;
use App\Models\Categories;
use App\Models\Page;
use App\Models\Contact;

class Homepage extends Controller
{
  public function __construct()
  {
    view()->share('pages',Page::orderBy('order','ASC')->get());
    view()->share('categories',Categories::inRandomOrder()->get());
  }



    public function index()
    {
      //print_r(Categories::all()); die;
      $data['articles']=Article::orderByDesc('created_at')->paginate(2);
      $data['articles']->withPath(url('sayfa'));
      return view('front.homepage',$data);
    }

    public function category($slug)
    {

      $category=Categories::whereSlug($slug)->first()??abort(403,'Böyle Bir Kategori Bulunamadı');
      $data['category']=$category;
      $data['articles']=Article::where('category_id',$category->id)->orderByDesc('created_at')->paginate(1);
      return view('Front.category',$data);
    }

    public function single($category,$slug)
    {
      $category=Categories::where('slug',$category)->first()??abort(403,'Böyle Bir Kategori Bulunamadı');
      $content=Article::where('slug',$slug)->where('category_id',$category->id)->first()??abort(403,'Böyle Bir Yazı Bulunamadı');
      $content->increment('hit');
      $data['content']=$content;
      return view('Front.single',$data);
    }


    public function page($slug)
    {
      $page=Page::where('slug',$slug)->first()??abort(403,'Böyle Bir sayfa Bulunamadı');
      $data['page']=$page;
      return view('Front.page',$data);
    }

    public function contact()
    {
      return view('Front.contact');

    }
    public function contactpost(Request $ruquest)
    {
      $rules=[
        'name'=>'required|min:3',
        'email'=>'required|email',
        'topic'=>'required',
        'mesaj'=>'required|min:10'
      ];

      $valid=Validator::make($ruquest->post(),$rules);
      if($valid->fails()){
      //  print_r($valid->errors());
        return redirect()->route('contact')->withErrors($valid)->withInput();

      }
      $contact=new Contact;
      $contact->name=$ruquest->name;
      $contact->email=$ruquest->email;
      $contact->topic=$ruquest->topic;
      $contact->message=$ruquest->mesaj;
      $contact->save();
      return redirect()->route('contact')->with('success','Sizinle en kısa zamanda iletişime geçeceğiz');
    }

}
