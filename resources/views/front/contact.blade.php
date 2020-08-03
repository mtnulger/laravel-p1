@extends('front.layouts.master')
@section('title',"İletişim")
@section('img',"https://www.aselsan.com.tr/ed3964e8-c55d-4528-bf78-ed353de11e95.jpg")
@section('content')
@if(session('success'))
<div class="alert alert-success">
  {{session('success')}}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>

</div>
@endif
<div class="col-md-8 ">
  <p>Soru ve görüşleriniz için bizimle iletişime geçebilirsiniz. </p>
  <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
  <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
  <!-- To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
  <form method="post" action="{{route('contact.post')}}">
    @csrf
    <div class="control-group">
      <div class="form-group  controls">
        <label>Ad Soyad</label>
        <input type="text" class="form-control" value="{{old('name')}}" placeholder="İsim Soyisminiz" name="name" required >
        <p class="help-block text-danger"></p>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group  controls">
        <label>Email Adresi</label>
        <input type="email" class="form-control" placeholder="Email Adresiniz" value="{{old('email')}} " name="email" required >
        <p class="help-block text-danger"></p>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group  controls">
        <label>Konu</label>
        <select class="form-control" name="topic">
          <option @if(old('topic')=="Destek") selected @endif>Destek</option>
          <option @if(old('topic')=="Hata") selected @endif>Hata</option>
          <option @if(old('topic')=="Genel") selected @endif>Genel</option>
          <option @if(old('topic')=="Bilgi") selected @endif>Bilgi</option>
        </select>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group  controls">
        <label>Mesajınız</label>
        <textarea rows="5" class="form-control" placeholder="Mesajınız"  name="mesaj" required >{{old('mesaj')}}</textarea>
        <p class="help-block text-danger"></p>
      </div>
    </div>
    <br>
    <div id="success"></div>
    <button type="submit" class="btn btn-primary" id="sendMessageButton">Gönder</button>
  </form>
</div>
<div class="col-md-4 ">
  <div class="form-group  controls">

      <h2>   İletişim Bilgilerimiz   </h2>
      <table class="mtop">
        <tbody><tr>
          <td><strong>    Adres:      </strong></td>
          <td>İnönü Üniversitesi Tıp Fakültesi, Turgut Özal Tıp Merkezi, Kulak Burun Boğaz Anabilim Dalı, Elazığ Yolu 11. km, 44280 Malatya, TÜRKİYE
</td>
        </tr>
        <tr>
          <td><strong>   Telefon:    </strong></td>
          <td>+90 422 341 06 60- 4602<br>+90 422 444 19 96 - 4602</td>
        </tr>
        <tr>
          <td><strong>Fax: </strong></td>
          <td>+90 422 341 39 28</td>
        </tr>
        <tr>
          <td><strong>E-Mail: </strong></td>
          <td>erkan.karatas@inonu.edu.tr<br>drerkankaratas@gmail.com</td>
        </tr>
      </tbody></table>
    </div>
    </div>
@endsection
