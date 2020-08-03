@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Yeni kategori</h6>
      </div>
      <div class="card-body">
        @if(session('hata'))
        <div class="alert alert-danger">
          <p>{{session('hata')}}</p>
        </div>
        @endif

        <form   action="{{route('admin.category.create')}}" method="post">
          @csrf
          <div class="form-group">
            <label>Kategori Adı</label>
            <input type="text" name="category" class="form-control" required>
          </div>
          <div class="form-group">
            <button type="submit" name="gonder" class="btn btn-primary">Kaydet</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Yeni kategori</h6>
      </div>
      <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Ad </th>
              <th>Sayısı</th>
              <th>Durum</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $categori)
            <tr id="{{$categori->id}}">
              <td>{{$categori->name}}</td>
              <td>{{$categori->articleCount()}}</td>
              <td><input class="switch" categori-id="{{$categori->id}}" type="checkbox" data-offstyle="danger" @if($categori->status==1) checked @endif data-on="Aktif" data-off="Pasif" data-toggle="toggle"></td>
              <td>
                <a  title="Düzenle"  categori-id="{{$categori->id}}" class=" btn btn-sm btn-primary edit"> <i class="fa fa-edit text-white"></i></a>
                <a  title="Sil"  categori-id="{{$categori->id}}" class=" btn btn-sm btn-danger remove"> <i class="fa fa-trash text-white"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    </div>
  </div>
</div>

  <!-- Modal -->
  <div id="EditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Kategoriyi Düzenle</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form   action="{{route('admin.category.update')}}" method="post">
            @csrf
            <div class="form-group">
              <label>Kategori Adı</label>
              <input type="text" id="category" name="category" class="form-control" required>
              <input type="hidden"  id="categoryId" name="id" class="form-control" >
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
          <button type="submit" class="btn btn-success" >Kaydet</button>
        </div>
      </form>
      </div>
    </div>
  </div>
@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  $(function() {
    $('.edit').click(function () {
        id= $(this)[0].getAttribute('categori-id');
        $.ajax({
          type:'GET',
          url:'{{route('admin.category.getData')}}',
          data:{id:id},
          success:function (data) {
            $('#category').val(data.name);
            $('#categoryId').val(data.id);
            $('#EditModal').modal();
          }
        });
      });

    $('.switch').change(function() {
      id= $(this)[0].getAttribute('categori-id');
      statu= $(this).prop('checked');
     $.get("{{route('admin.category.switch')}}",{id:id,statu:statu}, function(data){
        //alert(data);
      });
    })
    $('.remove').click(function () {
      id= $(this)[0].getAttribute('categori-id');
      catName=$(this).parent().parent().children().eq(0).html();
      catCount=$(this).parent().parent().children().eq(1).html();
      if(catCount=="0"){
        Swal.fire({
              title: catName+' Kategorisini',
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
                  url:'{{route('admin.category.remove')}}',
                  data:{id:id},
                  success:function (data) {
                    if(data=="yes"){
                      Swal.fire(
                        'Silindi',
                        catName+' Kategorisi Silindi',
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
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Bu kategoriye ait makaleler bulunmaktadır',
          footer: '<a href="{{route('admin.makaleler.index')}}">Makaleler sayfasına gitmek ister misiniz?</a>'
        })

      }
    });
  })

</script>
@endsection
