@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-right"><strong>{{$articles->count()}}</strong> makale bulundu.
      <a href="{{route('admin.makaleler.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-book"> Aktif Makaleler</i></a></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Fotoğraf</th>
            <th>Başlık</th>
            <th>kategori</th>
            <th>Hit</th>
            <th>Tarih</th>
            <th>İşlemler</th>
          </tr>
        </thead>

        <tbody>
          @foreach($articles as $article)
          <tr>
            <td> <img src="{{asset($article->image)}}" width="200"> </td>
            <td>{{$article->title}}</td>
            <td>{{$article->getCategory->name}}</td>
            <td>{{$article->hit}}</td>
            <td>{{$article->created_at->diffForHumans()}}</td>
            <td>
              <a href="{{route('admin.recolver.article',$article->id)}}" title="Geri Getir" class="btn btn-sm btn-primary"> <i class="fa fa-undo"></i></a>
              <a href="{{route('admin.hard.delete.article',$article->id)}}" title="Sil" class="btn btn-sm btn-danger"> <i class="fa fa-times"></i></a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
