@extends('layouts.app', ['activePage' => 'rekam', 'titlePage' => __('Isi Rekam Medis')])
 @section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('rekam.store') }}" autocomplete="on">
            @csrf
           

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Rekam Medis') }}</h4>
                <p class="card-category">{{ __('Pasien') }}</p>
              </div>
              <div class="card-body ">
               
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-4">
                      <div class="form-group{{ $errors->has('tanggal') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('tanggal') ? ' is-invalid' : '' }}" name="tgl_rekam" id="tgl_rekam" type="date" required="true" aria-required="true"/>
                        @if ($errors->has('tanggal'))
                          <span id="tanggal-error" class="error text-danger" for="tanggal">{{ $errors->first('tanggal') }}</span>
                        @endif
                      </div>
                      
                    </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">NIK</label>
                  <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('nik') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }} nik" name="nik" id="nik"  required="true" aria-required="true"/> 
                     <input type="hidden" name="pasien_id" id="pasien_id"/> 
                      @if ($errors->has('nik'))
                        <span id="nik-error" class="error text-danger" for="nik">{{ $errors->first('nik') }}</span>
                      @endif
                    </div>
                    
                  </div>
                  <div class="sm-4 col-form-label">
                  <span class="tim-note"><small> <label class="col-form-label">SIlahkan Masukkan NIK pasien saja, Detail Pasien akan otomatis tersedia</label></small> </span></div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">No MK Care</label>
                  <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('no_mkcare') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="no_mkcare" id="no_mkcare"  placeholder="{{ __('No MKCare') }}" value="{{ old('email') }}" required />
                      @if ($errors->has('no_jkn'))
                        <span id="no_mkcare-error" class="error text-danger" for="no_mkcare">{{ $errors->first('no_mkcare') }}</span>
                      @endif
                    </div>
                  </div>
                
                    <label class="col-sm-2 col-form-label">No JKN</label>
                    <div class="col-sm-4">
                      <div class="form-group{{ $errors->has('no_jkn') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="no_jkn" id="no_jkn"  placeholder="{{ __('No JKN') }}" value="{{ old('email') }}" required />
                        @if ($errors->has('no_jkn'))
                          <span id="no_jkn-error" class="error text-danger" for="no_jkn">{{ $errors->first('no_jkn') }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
              <div class="row">
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('nama') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" id="nama"  placeholder="{{ __('Nama') }}" value="{{ old('email') }}" required />
                    @if ($errors->has('nama'))
                      <span id="nama-error" class="error text-danger" for="nama">{{ $errors->first('nama') }}</span>
                    @endif
                  </div>
                </div>
              </div>
            
            <div class="row">
                <label class="col-sm-2 col-form-label">Anamnesa</label>
                <div class="col-sm-10">
                  <div class="form-group{{ $errors->has('keluhan') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('keluhan') ? ' is-invalid' : '' }}" name="keluhan" id="keluhan"  placeholder="{{ __('Keluhan') }}" value="" required />
                    @if ($errors->has('keluhan'))
                      <span id="keluhan-error" class="error text-danger" for="keluhan">{{ $errors->first('keluhan') }}</span>
                    @endif
                  </div>
                </div>
              </div>
            
            <div class="row">
                <label class="col-sm-2 col-form-label">Diagnosa</label>
                <div class="col-sm-10">
                  <div class="form-group{{ $errors->has('diagnosa') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('diagnosa') ? ' is-invalid' : '' }}" name="diagnosa" id="diagnosa"  placeholder="{{ __('diagnosa') }}" value="" />
                    @if ($errors->has('diagnosa'))
                      <span id="diagnosa-error" class="error text-danger" for="diagnosa">{{ $errors->first('diagnosa') }}</span>
                    @endif
                  </div>
                </div>
              </div>
            
            <div class="row">
                <label class="col-sm-2 col-form-label">Tindakan</label>
                <div class="col-sm-10">
                  <div class="form-group{{ $errors->has('tindakan') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('tindakan') ? ' is-invalid' : '' }}" name="tindakan" id="tindakan"  placeholder="{{ __('Tindakan') }}" value="" />
                    @if ($errors->has('tindakan'))
                      <span id="tindakan-error" class="error text-danger" for="tindakan">{{ $errors->first('tindakan') }}</span>
                    @endif
                  </div>
                </div>
              </div>
             
            <div class="row">
                <label class="col-sm-2 col-form-label">Petugas</label>
                <div class="col-sm-6">
                  <div class="form-group{{ $errors->has('petugas') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('petugas') ? ' is-invalid' : '' }}" name="petugas" id="petugas"  placeholder="{{ __('Petugas') }}" value=""  />
                    @if ($errors->has('petugas'))
                      <span id="petugas-error" class="error text-danger" for="petugas">{{ $errors->first('petugas') }}</span>
                    @endif
                  </div>
                </div>
              </div>
            
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
  
    </div>
  </div>
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <script type="text/javascript">
      $('#nik').autocomplete({
          placeholder: 'Masukkan NIK',
         
              source: "{{ route('nik_cari') }}",
              minlength:3,
             
              autoFocus:true,
              
              select:function(event,ui)
  
             {    
               $('#nik').val(ui.item.nik);
               $('#pasien_id').val(ui.item.id);
                $('#nama').val(ui.item.nama);
                $('#no_jkn').val(ui.item.no_jkn);
                $('#no_mkcare').val(ui.item.no_mkcare);
                
            }
           
      });
  </script>
 
@endsection