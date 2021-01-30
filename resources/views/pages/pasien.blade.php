@extends('layouts.app', ['activePage' => 'pasien', 'titlePage' => __('Pasien')])
 
  
@section('content')
 
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title ">Data Pasien</h4>
            <p class="card-category"></p>
          </div>
          <div class="card-body">
            <a class="btn btn-primary" href="javascript:void(0)" id="createNew"> Tambah Data</a>
            <a class="btn btn-info mr-5" href="javascript:void(0)" id="importPasien">
              IMPORT EXCEL
            </a>
            <a class="btn btn-warning" href="{{ URL::to('pasien_pdf') }}">Export to PDF</a>
            <div class="alert alert-danger print-error-msg" style="display:none">
              <ul></ul>
          </div>
          @if ($sukses = Session::get('sukses'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $sukses }}</strong>
          </div>
          @endif
            <div class="table-responsive col-md-12">
                <table class="table table-striped" id="pasiens-table">
                <thead class="text-info">
                  <th>
                    #
                  </th>
                  <th>
                    NIK
                  </th>
                  <th>
                    No MKCare
                  </th>
                  <th>
                    No JKN
                  </th>
                  <th>
                    Nama
                  </th>
                  <th>
                    Jenis Kelamin
                  </th>
                  <th>
                   Tanggal Lahir
                  </th>
                <th>Action</th>
                
                </thead>
                
                  
              </table>
            </div>
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
          <h4 class="modal-title" id="myModalLabel"><span class="fa fa-user"></span>&nbsp;Detail Pasien</h4>
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

    <div class="modal-dialog">
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
                   <input type="hidden" name="pasien_id" id="pasien_id">
                   <div class="form-group col-md-12">
                    <label for="nik" class="control-label">NIK</label>
                     <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" value="" maxlength="16" required>
                    </div>
                   </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="name" class="control-label">Nomor MKCare</label>
                        <input type="text" class="form-control" id="no_mkcare" name="no_mkcare" placeholder="Masukkan No Anggota" value="" maxlength="50">
                      </div>
                  
                  <div class="form-group col-md-6" >
                    <label for="name" class="control-label">Nomor JKN</label>
                     <input type="text" class="form-control" id="no_jkn" name="no_jkn" placeholder="Masukkan No JKN" value="" maxlength="50" >
                  </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="name" class="control-label">Nama</label>
                        
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="" maxlength="50" required>
                         
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="tempat_lahir" class=" control-label">Tempat Lahir</label>
                      <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="" maxlength="50" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="tempat_lahir" class="control-label">Tanggal Lahir</label>
                      <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir" value="" maxlength="50" required>
                    </div>
                  </div>
                  <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="jenis_kelamin" class="control-label">Jenis Kelamin</label>
                    
                        <select class="form-control"  id="jenis_kelamin" name="jenis_kelamin">
                          <option value="pria">Pria</option>
                          <option value="wanita">Wanita</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Alamat</label>
                             <textarea id="alamat" name="alamat" required="" placeholder="Alamat" class="form-control" row="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="nomor_wa" class="control-label">Nomor WA</label>
                          <input type="number" class="form-control" id="nomor_wa" name="nomor_wa" placeholder="081xxxxxxx" value="" maxlength="16"/>
                          <span id="spnPhoneStatus"></span>
                        </div>

                  </div>
                  <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="nomor_hp" class="control-label">Nomor Handphone</label>
                  
                        <input type="number" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="081xxxxxxx" value="" maxlength="16"/>
                        <span id="spnPhoneStatus"></span>
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
    </div>
    <!-- akhir kode modal dialog -->
    <!--modal import-->
    <div class="modal fade" id="importExcel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modalHeading"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                  </button>
              </div>
              <div class="modal-body">       
                <div class="alert alert-danger modal-error" style="display:none"><ul></ul></div>     
                  <form id="pasienImport" name="pasienImport"  method="post" action="{{ route('file_import') }}" enctype="multipart/form-data" class="form-horizontal" >
                    @csrf
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="name" class="control-label">Browse File</label>
                        <input type="file" name="file" required="required"  size="30" />
                       
                        </div>
                        <span class="help-block">*) catatan.</span><br>
    <span class="help-block">Aplikasi hanya suport file excel dengan extensi berupa xls maupun xlxs adapun template nya bisa di download <a href="{{ URL::asset('file_pasien/pasiens.xlsx') }}">disini </a></span><br>
                    </div>
                     
                  </div>
                 
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <input type="submit"  value="Submit" class="btn btn-primary">
                  
                </div>
                  </form>
                
              </div>
  
          </div>
  
      </div>
    <!---akhir modal import-->
 </div>
 


@push('js')
<script>
   
  $(function () {

     
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('#pasiens-table').DataTable({
        processing: true,
        serverSide: true,
       
        ajax: "{{ route('pasien.index') }}",
     
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' ,orderable: false, searchable: false},
            {data: 'nik', name: 'nik'},
            {data: 'no_mkcare', name: 'no_mkcare'},
            {data: 'no_jkn', name: 'no_jkn'},
            {data: 'nama', name: 'nama'},
            {data: 'jenis_kelamin', name: 'jenis_kelamin'},            
            {data: 'tanggal_lahir', name: 'tanggal_kahir'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

$('#createNew').click(function () {
  $('#saveBtn').val("create-pasien");
  $('#pasien_id').val('');
  $('#pasienForm').trigger("reset");
  $('#modelHeading').html("Tambahkan Pasien");
  $('#ajaxModel').modal('show');

});
$('#importPasien').click(function () {
  $('#importBtn').val("create-pasien");
  $('#pasienImport').trigger("reset");
  $('#modalHeading').html("Import Pasien");
  $('#importExcel').modal('show');

});
$('body').on('click','.detailPasien', function(){
       
       var DataPasien= this.id;
       
       var datanya = DataPasien.split("|");
      
       $("#IsiModal").html('<table width="100%" style="font-size:14px"><tr><td width="150">NIK</td><td width="10">:</td><td>'+datanya[0]+'</td></tr><tr><tr><td>No MKCare</td><td>:</td><td>'+datanya[1]+'</td></tr><tr><td>No JKN</td><td>:</td><td>'+datanya[2]+'</td></tr><tr><td>Nama Lengkap</td><td>:</td><td>'+datanya[3]+'</td></tr><tr><td>Tempat, Tanggal  Lahir</td><td>:</td><td>'+datanya[4]+', '+datanya[5]+'</td></tr><tr><td>Jenis Kelamin</td><td>:</td><td>'+datanya[6]+'</td></tr><tr><td>Alamat</td><td>:</td><td>'+datanya[7]+'</td></tr><tr><td>Nomor HP</td><td>:</td><td>'+datanya[8]+'</td></tr><tr><td>Nomor WA</td><td>:</td><td>'+datanya[9]+'</td></tr></table>');
       $('#ModalDetail').modal('show');
       });

$('body').on('click', '.editPasien', function () {
      var pasien_id = $(this).data('id');
      $.get("{{ route('pasien.index') }}" +'/' + pasien_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Pasien");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#pasien_id').val(data.id);
          $('#nik').val(data.nik);
          $('#no_mkcare').val(data.no_mkcare);
          $('#no_jkn').val(data.no_jkn);
          $('#nama').val(data.nama);
          $('#alamat').val(data.alamat);
          $('#tempat_lahir').val(data.tempat_lahir);
          $('#tanggal_lahir').val(data.tanggal_lahir);
          $('#jenis_kelamin').val(data.jenis_kelamin);
          $('#nomor_wa').val(data.nomor_wa);
          $('#nomor_hp').val(data.nomor_hp);
      })
   });
$('#saveBtn').click(function (e) {
  @if (count($errors) > 0)
    $('#ajaxModel').modal('show');
@endif
        $(this).html('Simpan');
    
        $.ajax({
          data: $('#pasienForm').serialize(),
          url: "{{ route('pasien.store') }}",
          type: "POST",
          dataType: 'json',
          complete: function(response) {
     
              $('#pasienForm').trigger("reset");
              
              table.draw();
              if($.isEmptyObject(response.responseJSON.error)){
              $('.success').show();
                           setTimeout(function(){
                           $('.success').hide();
                        }, 5000);
                        $('#ajaxModel').modal('hide');       
              } else{
                printErrorMsg(response.responseJSON.error);
                
              }
         
          },
          error: function (data) {
              console.log('Error:', data);
             
           
              $('#saveBtn').html('Save Changes');
             
          }
          
      });
      e.preventDefault();
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

$('body').on('click', '.deletePasien', function () {
     
     var pasien_id = $(this).data("id");
    if(confirm("Are You sure want to delete ?")){
   
     $.ajax({
         type: "DELETE",
         url: "{{route('pasien.store')}}"+'/'+pasien_id,
         success: function (data) {
             table.draw();
         },
         error: function (data) {
             console.log('Error:', data);
         }
     }
     );}
 });
 function validatePhone(txtPhone) {
    var a = document.getElementById(txtPhone).value;
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (filter.test(a)) {
        return true;
    }
    else {
        return false;
    }
}
$('#nomor_wa').blur(function(e) {
        if (validatePhone('txtPhone')) {
            $('#spnPhoneStatus').html('Valid');
            $('#spnPhoneStatus').css('color', 'green');
        }
        else {
            $('#spnPhoneStatus').html('Invalid');
            $('#spnPhoneStatus').css('color', 'red');
        }
    });
  });

   
</script>
 
@endpush
@endsection
 