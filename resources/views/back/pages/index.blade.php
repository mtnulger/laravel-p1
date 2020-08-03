@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-right"><strong>{{$pages->count()}}</strong> makale bulundu.
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Sıralama</th>
            <th>Fotoğraf</th>
            <th>Başlık</th>
            <th>Hit</th>
            <th>Tarih</th>
            <th>Durum</th>
            <th>İşlemler</th>
          </tr>
        </thead>

        <tbody id="orders">
          @foreach($pages as $page)
          <tr id="page_{{$page->id}}">
            <td style="width:10px !important; text-align:center;"><i class="fa fa-arrows-alt-v fa-3x handle" style="cursor:move"></i></td>
            <td> <img src="{{asset($page->image)}}" width="200"> </td>
            <td>{{$page->title}}</td>
            <td>{{$page->order}}</td>
            <td>{{$page->created_at->diffForHumans()}}</td>
            <td><input class="switch" page-id="{{$page->id}}" type="checkbox" data-offstyle="danger" @if($page->status==1) checked @endif data-on="Aktif" data-off="Pasif" data-toggle="toggle"></td>
            <td>
              <a  title="Düzenle" href="{{route('page',$page->slug)}}"  categori-id="{{$page->id}}" class=" btn btn-sm btn-success "> <i class="fa fa-eye text-white"></i></a>
              <a  title="Düzenle" href="{{route('admin.page.edit',$page->id)}}"  categori-id="{{$page->id}}" class=" btn btn-sm btn-primary edit"> <i class="fa fa-edit text-white"></i></a>
              <a  title="Sil"  page-id="{{$page->id}}" class=" btn btn-sm btn-danger remove"> <i class="fa fa-trash text-white"></i></a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script type="text/javascript">
$('#orders').sortable({
  handle:'.handle',
  update:function () {
    var sirala=$('#orders').sortable('serialize');
    $.get("{{route('admin.page.orders')}}?"+sirala,function (data,status) {
          $.notify("Sayfa Sıralaması Değişti!", "success");
    });
  }
});
</script>
<script>
  $(function() {
    $('.switch').change(function() {
      id= $(this)[0].getAttribute('page-id');
      statu= $(this).prop('checked');
     $.get("{{route('admin.page.switch')}}",{id:id,statu:statu}, function(data){
      //  toastr()->success('Başarılı!', 'Silinen makalelere taşndı');
    //  toastr.success('Have fun storming the castle!', 'Miracle Max Says');
    toastr.success('Success messages');
      });
    })
    $('.remove').click(function () {
      id= $(this)[0].getAttribute('page-id');
      catName=$(this).parent().parent().children().eq(1).html();
        Swal.fire({
              title: catName+' Sayfasını',
              text: "Silmek için emin misiniz?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Evet, Sil',
              cancelButtonText: 'İptal'
            }).then((result) => {
              if (result.value==true) {
                $.ajax({
                  type:'GET',
                  url:'{{route('admin.page.remove')}}',
                  data:{id:id},
                  success:function (data) {
                    if(data=="yes"){
                      Swal.fire(
                        'Silindi',
                        catName+' Sayfası Silindi',
                        'success'
                      );
                      $('#'+id).remove();
                    }else{
                      Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'errors'
                      )
                    }
                  }
                });
              }
            })

    });
  })
</script>
@endsection
