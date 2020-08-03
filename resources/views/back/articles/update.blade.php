@extends('back.layouts.master')
@section('title',ucwords($articles->title).' Makalesini Düzenle')
@section('content')
<div class="card shadow mb-4">
  <div class="card-body">
    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
          <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
      @endif
    <form  action="{{route('admin.makaleler.update',$articles->id)}}" method="post" enctype="multipart/form-data">
      @method('PUT')
      @csrf
      <div class="form-group">
        <label>Başlık</label>
        <input type="text" name="title" class="form-control" value="{{$articles->title}}" required>
      </div>
      <div class="form-group">
        <label>Başlık</label>
        <select  name="category" class="form-control" required>
          <option value="">Bir Seçim Yapınız</option>
          @foreach($categories as $categori)
            <option value="{{$categori->id}}" @if("{{$categori->id}}"=="{{$articles->category_id}}") selected @endif>{{$categori->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Fotoğraf</label>
        <br>
        <img src="{{asset($articles->image)}}"  class="img-thumbnail" width="200" alt="">
        <input type="file" name="image" class="form-control" >
      </div>
      <div class="form-group">
        <label>İçerik</label>
        <textarea  id="editor" name="content"  class="form-control" rows="5" required>{!!$articles->content!!}</textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block" name="button">Kaydet</button>
      </div>
    </form>
  </div>
</div>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('#editor').summernote({
        'height':300

      }
      );
  });
</script>
@endsection
