@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('MK Care')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-8 col-md-8">
          <h1 class="text-white text-center">{{ __('Welcome to MK Care') }}</h1><p></p>
          <p></p>
          <p></p>
          <p></p>
      </div>
      
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-8">
     &nbsp;
   
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-8">
      &nbsp;
   
    </div>
  </div> 
  <form id ="frmCari" class="form-horizontal" method="GET" action="{{ route('cari') }}">
    
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-8">
      <div class="form-group">
        <label for="cari" class="text-white text-center">Pencarian </label>
        <input name="search" id="search" class="form-control" placeholder="Cari nama peserta / No MK Care" required/>
      </div>
      <div class="form-group"><button id="btnCari" class="btn btn-warning" type="submit"> Cari</button></div>
    </div>
  
  </div>
</form>
<div class="row justify-content-center">
    @if($pasien->isNotEmpty())
    @foreach ($pasien as $pasiens)
    <div class="col-lg-10 col-md-8">
      <div class="alert alert-succes alert-with-icon alert-dismiss" data-notify="container">
        <i class="material-icons" data-notify="icon">warning</i>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
        <span data-notify="message">Selamat <strong>{{ $pasiens->nama }}</strong>, usia {{ usia($pasiens->tanggal_lahir) }} tahun, NIK : {{ secretKTP($pasiens->nik) }}, sudah terdaftar pada layanan kami<br>
        no mk care : {{ secretName($pasiens->no_mkcare) }} </span>
      </div>
      </div>
      @endforeach
      
@else 
<div class="col-lg-10 col-md-8">
  <div class="alert alert-danger alert-with-icon alert-dismiss" data-notify="container">
    <i class="material-icons" data-notify="icon">warning</i>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <i class="material-icons">close</i>
    </button>
    <span data-notify="message">Data pasien tersebut tidak ditemukan dalam database kami</span>
  </div>
  </div>
@endif
  
</div>  
</div>
 
@endsection
