@extends('layouts.app', ['activePage' => 'rekam', 'titlePage' => __('Rekam Medis')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title ">Data Rekam Medis</h4>
            <p class="card-category">Seluruh Data Rekam Medis Pasien</p>
          </div>
          <div class="card-body">
            <a class="btn btn-primary" href="{{ route('rekam_isi') }}" id="createNew"> Tambah Data</a>
            <div class="alert alert-danger print-error-msg" style="display:none">
              <ul></ul>
          </div>
          <div class="success alert alert-success" style="display:none">
              Data save successfully
          </div>
          
          <div class="card text-center p-3">
        <strong>Pencarian</strong> 
            <div class="card-body">
              <div class="row">	
           
                <div class="col-md-3">
                  <div class="form-group">
                     <label for="name">Name</label><input type="text" name="nama" id="nama" class="form-control searchNama" placeholder="Masukkan Nama..."></div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                     <label for="nojkn">NIK</label>     <input type="text" name="nik" id="nik" class="form-control searchNoJKN" placeholder="NIK"></div>
                  </div>
                <div class="col-md-3">
                  <div class="form-group"> 
                   <label for="nomkcare">No MK Care</label>    <input type="text" name="no_mkcare" id="no_mkcare" class="form-control searchNomkcare" placeholder="No Mk Care"></div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                   <label for="nojkn">No JKN</label>     <input type="text" name="no_jkn" id="no_jkn" class="form-control searchNoJKN" placeholder="No JKN"></div>
                </div>
              </div>
                <div class="row">
                 <div class="col-md-12">
                   <div class="form-group">
                   <button type="submit" class="btn btn-primary btn-sm pull-right" id="filter">Search</button>
                   </div>
                </div>
                </div> 
              
            </div>
          </div>
              <div class="table-responsive col-md-12">
                <table class="table table-striped" id="rekam-table">
                <thead class="text-info">
                 
                  <th>
                    No Rekam
                  </th>
                  <th>
                    No MK Care
                  </th>
                  
                  <th>
                   Nama Pasien
                  </th>
                  <th>
                    Nama Dokter
                  </th>
                  <th>
                   Diagnosa
                  </th>
                  <th >
                     Terakhir Periksa Tgl
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
 
   
 
</div>

 
@push('js')

<script>
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}
  $(document).ready(function () {
    let table= $('#rekam-table').DataTable({
        processing: true,
        serverSide: true,
        searching:false,
        ajax: {
          url:"{{ route('rekam.index') }}",
          type: 'GET',
          data: function (d) {
                        d.nik = $('#nik').val();
                        d.nama = $('#nama').val();
                        d.no_mkcare = $('#no_mkcare').val();
                        d.no_jkn = $('#no_jkn').val();
            }
        },
        columns: [
           
            {data: 'id_pasien', name: 'id_pasien',
              render:function ( data, type, row ) {
                
                    return pad(data,6);
                },},
                {data: 'no_mkcare', name: 'no_mkcare'},
            {data: 'nama', name: 'nama',   searchable: false},
            {data: 'petugas', name: 'petugas'},
            {data: 'diagnosa', name: 'diagnosa'},    
            {data: 'tgl_rekam', name: 'tgl_rekam',sType: "date-uk"},                
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        
    });
   
    $('#filter').click(function(){
        var filter_nama = $('#nama').val();
        var filter_nomkcare = $('#no_mkcare').val();
        var filter_nojkn =$('#no_jkn').val();
        var filter_nik=$('#nik').val();

        if(filter_nama != '' ||  filter_nomkcare != '' || filter_nojkn !='' || filter_nik !='')
        {
          table.draw(); 
            
         
        }
        else
        {
            alert('Harap isi dulu sebelum melakukan pencarian');
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
        
$('body').on('click', '.deleterekam', function () {
     
     var rekam_id = $(this).data("id");
     confirm("Are You sure want to delete !");
   
     $.ajax({
         type: "DELETE",
         url: "{{ route('rekam.store') }}"+'/'+rekam_id,
         success: function (data) {
             table.draw();
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
 });

 $('body').on('click', '.viewrekam', function () {
     
  var rekam_id = $(this).data("id");
   
     $.ajax({
      type: 'POST',
         url: '/rekam/detail'+'/'+rekam_id,
         success: function(data){
   window.location = url;
  },
      
     });
 });  

  $('#search-form').on('submit', function(e) {
    var filter_nama = $('#nama').val();
        var filter_nomkcare = $('#no_mkcare').val();
        var filter_nojkn =$('#no_jkn').val();
        var filter_nik=$('#nik').val();
    if(filter_nama != '' ||  filter_nomkcare != '' || filter_nojkn !='' || filter_nik !='')
        {
            $('#rekam_table').DataTable().destroy();
            fill_datatable(filter_nama, filter_nik,_filter_nomkcare,filter_nojkn);
           
        }
       // e.preventDefault();
    });
    $("#no_mkcare").keyup(function(){
        table.draw();
    });
</script>
@endpush
@endsection
 