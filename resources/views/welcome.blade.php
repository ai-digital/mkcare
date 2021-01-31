@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('MK Care')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <h1 class="text-white text-center">{{ __('Welcome to MK Care') }}</h1><p></p>
          <p></p>
          <p></p>
          <p></p>
      </div>
      
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-8">
     &nbsp;
   
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-8">
      &nbsp;
   
    </div>
  </div> 
  <form id ="frmCari" class="form-horizontal" method="GET" action="{{ route('cari') }}">
    
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-8">
      <div class="form-group">
        <label for="cari" class="text-white text-center">Pencarian </label>
        <input name="search" id="search" class="form-control" placeholder="Masukkan NIK peserta / No MK Care" required/>
      </div>
      <div class="form-group"><button id="btnCari" class="btn btn-warning" type="submit"> Cari</button></div>
    </div>
  
  </div>
</form>
  
</div>
 
@endsection
