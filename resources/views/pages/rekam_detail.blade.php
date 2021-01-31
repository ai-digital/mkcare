@extends('layouts.app', ['activePage' => 'rekam', 'titlePage' => __('Rekam Medis Pasien')])

    
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
         
          <div class="card-header card-header-warning">
            <h4 class="card-title ">Rekam Medis Pasien</h4>
            <p class="card-category">No RM : {{ str_pad($rekam->id,6,'0',STR_PAD_LEFT)  }}</p>
          </div>
          <div class="card-body">
            
            <div class="row">
           
              <div class="col-md-2">No MK Care</div><div class="col-md-1">:</div><div class="col-md-3">{{ $rekam->no_mkcare}}</div>
             
                <div class="col-md-2">No JKN</div><div class="col-md-1">:</div><div class="col-md-3">{{ $rekam->no_jkn}}</div>
               
            </div>
            <div class="row">
              <div class="col-md-2">Nama </div><div class="col-md-1">: </div><div class="col-md-3">{{ $rekam->nama}}</div>
              <div class="col-md-2">NIK </div><div class="col-md-1">:</div><div class="col-md-3 pull-left">{{ $rekam->nik}}</div>
            </div>
            <div class="row">
              <div class="col-md-2">Tanggal Lahir</div><div class="col-md-1">: </div><div class="col-md-3">{{$rekam->tempat_lahir}}, {{  tglIndoFull($rekam->tanggal_lahir) }}</div>
              <div class="col-md-2">Jenis Kelamin </div><div class="col-md-1">:</div><div class="col-md-3 pull-left">{{ $rekam->jenis_kelamin}}</div>
            </div>
            <div class="row">
              <div class="col-md-2">Alamat</div><div class="col-md-1">: </div><div class="col-md-9 pull-left">{{ $rekam->alamat}}</div>
            </div>
            <div class="row">
              <div class="col-md-2">Nomor HP</div><div class="col-md-1">: </div><div class="col-md-3">{{ $rekam->nomor_hp}}</div>
              <div class="col-md-2">Nomor WA</div><div class="col-md-1">:</div><div class="col-md-3 pull-left">{{ $rekam->nomor_wa}}</div>
            </div>
            <a class="btn btn-primary pull-right" href="#" id="createNew"> Tambah Data</a>
            <div class="alert alert-danger print-error-msg" style="display:none">
              <ul></ul>
          </div>
            <div class="table-responsive">
              <div class="alert alert-success success alert-dismissible fade show" role="alert" style="display: none;">
                <strong>Berhasil!</strong>&nbsp;&nbsp;&nbsp;&nbsp;Data rekam medis sudah disimpan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
                <table class="table table-bordered" id="rekams-table">
                <thead class="text-primary">
                  <th width="5%">
                    No
                  </th>
                  <th width="10%">
                    Tanggal Rekam
                  </th>
                  <th width="25%">
                  Anamnesa
                  </th>
                  <th width="15%">
                   Diagnosa
                  </th>
                  <th width="20%">
                  Terapi
                  </th>
                  <th width="12%">
                    Petugas
                    </th>
                 <th width="13%">Action</th>
                </thead>
                 @foreach($rekam->rekam as $rekams)
                 <tr><td></td>
                  <td>{{ tglIndoPendek($rekams->tgl_rekam) }}</td>
                  <td>{{ $rekams->keluhan}}</td>
                  <td>{{ $rekams->diagnosa}}</td>
                  <td>{{ $rekams->tindakan}}</td>
                  <td>{{ $rekams->petugas}}</td>
                  <td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $rekams->id}}" data-original-title="Edit" title="Edit" alt="Edit Rekam Medis" class="btn btn-success btn-sm editRekam"><i class="material-icons">edit</i></a>
                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $rekams->id}}" data-original-title="Hapus" title="Hapus" alt="Hapus Rekam Medis" class="btn btn-danger btn-sm deleteRekam"><i class="material-icons">delete</i></a>
                  </td>
                  
                 </tr>
                 @endforeach
               
                
                  
              </table>
            </div>
          </div>
        </div>
       
      
    </div>
  </div>
  <!--Modal Dialog-->
  <div class="modal fade" id="ModalDetail" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"><span class="fa fa-user"></span>&nbsp;Rekam Medis Pasien</h4>
          <button type="button" class="close" data-dismiss="modal"> <i class="material-icons">close</i></button>
        </div>
        <div class="modal-body" id="IsiModal">
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="material-icons">close</i> Tutup</button>
          </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ajaxModel" aria-hidden="true">

    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body">       
              <div class="alert alert-danger modal-error" style="display:none"><ul></ul></div>
                
                <form id="pasienForm" name="pasienForm" class="form-horizontal">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="name" class="control-label">Tanggal</label><input type="hidden" id="id" name="id" value="">
                        <input type="date" class="form-control" id="tgl_rekam" name="tgl_rekam" value="<?php echo date('Y-m-d'); ?>">
                      </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="name" class="control-label">Nomor MKCare</label>
                        <input type="text" class="form-control" id="no_mkcare" name="no_mkcare"  value="{{ $rekam->no_mkcare}}" readonly>
                      </div>
                   <div class="form-row">
                   <input type="hidden" name="pasien_id" id="pasien_id" value="{{ $rekam->id }}">  
                   <div class="form-group col-md-12">
                    <label for="nik" class="control-label">NIK</label>
                     <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" value="{{ $rekam->nik }}" maxlength="16" readonly>
                    </div>
                   </div>
                   
                  
                  <div class="form-group col-md-6" >
                    <label for="name" class="control-label">Nomor JKN</label>
                     <input type="text" class="form-control" id="no_jkn" name="no_jkn"   value="{{ $rekam->no_jkn }}" readonly >
                  </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="name" class="control-label">Nama</label>
                        
                            <input type="text" class="form-control" id="nama" name="nama"   value="{{ $rekam->nama }}"  readonly>
                         
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="anamnesa" class=" control-label">Anamnesa</label>
                      <input type="text" class="form-control" id="keluhan" name="keluhan" placeholder="Anamnesa"   autofocus required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="diagnosa" class="cntrol-label">diagnosa</label>
                      <input type="text" class="form-control" id="diagnosa" name="diagnosa" placeholder="diagnosa"   required>
                    </div>
                  </div>
                  <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="tindakan" class="control-label">Tindakan</label>
                    <input type="text" class="form-control" id="tindakan" name="tindakan" placeholder="Tindakan"    required>
                  
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="tindakan" class="control-label">Petugas</label>
                      <input type="text" class="form-control" id="petugas" name="petugas" placeholder="petugas"   required>
                    
                      </div>
                    </div>
               </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan

                     </button>
                  

                    
              </div>
                </form>
              
            </div>

        </div>

    </div>
    <!-- akhir kode modal dialog -->
  </div>
</div>


@push('js')
<script>
   
  $(function () {


    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var t = $('#rekams-table').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        
        "order": [[ 1, 'asc' ]]
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

$('#createNew').click(function () {
  $('#saveBtn').val("create-pasien");
  
  $('#pasienForm').trigger("reset");
  $('#modelHeading').html("Tambahkan Rekam Medis Pasien");
  $('#ajaxModel').modal('show');

});
$('body').on('click','.detailPasien', function(){
       
       var DataPasien= this.id;
       
       var datanya = DataPasien.split("|");
      
       $("#IsiModal").html('<table width="100%" style="font-size:14px"><tr><td width="150">NIK</td><td width="10">:</td><td>'+datanya[0]+'</td></tr><tr><tr><td>No MKCare</td><td>:</td><td>'+datanya[1]+'</td></tr><tr><td>No JKN</td><td>:</td><td>'+datanya[2]+'</td></tr><tr><td>Nama Lengkap</td><td>:</td><td>'+datanya[3]+'</td></tr><tr><td>Tempat, Tanggal  Lahir</td><td>:</td><td>'+datanya[4]+', '+datanya[5]+'</td></tr><tr><td>Jenis Kelamin</td><td>:</td><td>'+datanya[6]+'</td></tr><tr><td>Alamat</td><td>:</td><td>'+datanya[7]+'</td></tr><tr><td>Nomor HP</td><td>:</td><td>'+datanya[8]+'</td></tr><tr><td>Nomor WA</td><td>:</td><td>'+datanya[9]+'</td></tr></table>');
       $('#ModalDetail').modal('show');
       });

$('body').on('click', '.editRekam', function () {
      var rekam_id = $(this).data('id');
      $.get("{{ route('rekam.index') }}" +'/' + rekam_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Rekam Medis Pasien");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#id').val(data.id);
          $('#nik').val(data.rekam.nik);
          $('#no_mkcare').val(data.rekam.no_mkcare);
          $('#no_jkn').val(data.rekam.no_jkn);
          $('#nama').val(data.rekam.nama);
          $('#diagnosa').val(data.diagnosa);
          $('#keluhan').val(data.keluhan);
          $('#tindakan').val(data.tindakan);
          $('#petugas').val(data.petugas);
       
        
      })
   });
$('#saveBtn').click(function (e) {
  @if (count($errors) > 0)
    $('#ajaxModel').modal('show');
@endif
        $(this).html('Simpan');
       
     
    var datastring = $("#pasienForm").serialize();
        $.ajax({
         
          url: "{{ route('rekam.store') }}",
          type: "POST",
          data:  datastring,
    
          dataType: 'json',
          
          complete: function(response) {
            $('#pasienForm').trigger("reset");
              
            t.draw();
            if($.isEmptyObject(response.responseJSON.error)){
           
              $('.success').show();
                           setTimeout(function(){
                           $('.success').hide();
                        }, 5000);
                        $('#ajaxModel').modal('hide'); 
                        location.reload(); 
                    } else {
                      printErrorMsg(response.responseJSON.error);
                       
                    }
         
          },
          error: function (data) {
            
              $('#saveBtn').html('Save Changes');
             console.log('Eror',data)
          }
          
      });
      
    });
    function printErrorMsg(msg){
      $('#ajaxModel').modal('show');
               $(".modal-error").find("ul").html('');
            $(".modal-error").css('display','block');
            $.each( msg, function( key, value ) {
                $(".modal-error").find("ul").append('<li>'+value+'</li>');
            });
            setTimeout(function(){
                           $('.modal-error').hide();
                        }, 5000);
          }

$('body').on('click', '.deleteRekam', function () {
  var token = $("meta[name='csrf-token']").attr("content");
  
     var pasien_id = $(this).data("id");
     if(confirm("Are You sure want to delete !")){
   
     $.ajax({
         
         type: 'POST',
         url: "{{ route('rekam.store') }}"+'/'+pasien_id,
         data:{
          '_token': $('meta[name=csrf-token]').attr("content"),
'_method': 'DELETE',
         },
         success: function (data) {
          location.reload(true);
          alert('data sudah dihapus');
            },
            error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
         }
     });
     }
 });

  });

   
</script>
@endpush
@endsection
 