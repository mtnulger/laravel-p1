@extends('front.layouts.master')
@section('title',$content ->title)
@section('img',$content ->image)
@section('content')

      <div class="col-md-9 mx-auto">
        <p>{!!$content ->content!!}</p>
        <span class="caption text-muted">Okunma Sayısı : {{$content ->hit}}</span>
      </div>
@include('front.widgets.categoryWidget')
@endsection
