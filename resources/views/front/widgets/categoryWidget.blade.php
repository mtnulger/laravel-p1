@isset($categories)
<div class="col-md-3">
  <div class="card">
      <div class="card-header">
        Kategoriler
      </div>
      <div class="list-group">

        @foreach($categories as $categori)
        <li class="list-group-item @if(Request::segment(2)==$categori->slug) active @endif ">
          <a @if(Request::segment(2)!=$categori->slug) href="{{route('category',$categori->slug)}}" @endif >{{$categori->name}} </a><span class="badge bg-success float-right text-white" >{{$categori->articleCount()}}</span>
        </li>
        @endforeach
      </div>
  </div>
</div>
@endisset
