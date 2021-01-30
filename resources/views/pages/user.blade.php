@extends('layouts.app', ['activePage' => 'user', 'titlePage' => __('User')])
 
  
@section('content')
 
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title ">Data User</h4>
            <p class="card-category"></p>
          </div>
          <div class="card-body">
            
        
            <div class="alert alert-danger print-error-msg" style="display:none">
              <ul></ul>
          </div>
          @if ($sukses = Session::get('sukses'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $sukses }}</strong>
          </div>
          @endif
          <div class="row">
            <div class="col-12 text-right">
              <a href="javascript:void(0)" id="createNew" class="btn btn-sm btn-primary">Add user</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table" id="user-table">
              <thead class=" text-primary">
                <tr>
                  
                  <th>
                    Nama
                </th>
                <th>
                  Email
                </th>
                <th>
                  Hak Akses
                </th>
                <th class="text-right">
                  Actions
                </th>
              </tr></thead>
              <tbody>
                @foreach ($users as $user)
          
 
                  <tr>
                   
                    <td>
                      {{ $user->name }}
                    </td>
                    <td>
                      {{ $user->email }}
                    </td>
                    <td>
                      @if ($user->hak_akses==0)  
                          Administrator
                      @elseif ($user->hak_akses==1)  
                      Rekam Medis
                      @else
                      Perawat
                      @endif
                     
                      
                    </td>
                    <td class="td-actions text-right">
               <a rel="tooltip" class="btn btn-success btn-link editUser" href="#" data-id="{{$user->id}}" data-original-title="Edit" title="Edit">
                          <i class="material-icons">edit</i>
                          <div class="ripple-container"></div>
                        </a>
                        <a rel="tooltip" class="btn btn-danger btn-link deleteUser" href="#"  data-id="{{$user->id}}" data-original-title="Hapus" title="Hapus">
                          <i class="material-icons">delete</i>
                          <div class="ripple-container"></div>
                        </a>
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
  </div>
  <!--Modal Dialog-->
   
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
                <form id="userForm" name="userForm" class="form-horizontal">
                   <div class="form-row">
                   <input type="hidden" name="user_id" id="user_id">
                   <div class="form-group col-md-12">
                    <label for="nama" class="control-label">Nama</label>
                     <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="" required>
                    </div>
                   </div>
                    <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="name" class="control-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" value="" >
                      </div>
                    </div>
                    <div class="form-row">
                  <div class="form-group col-md-12" >
                    <label for="name" class="control-label">Password</label>
                     <input type="password" class="form-control" id="password" name="password"  >
                  </div>
                    </div>
                    <div class="form-row">
                    
                  
                  <div class="form-group col-md-12">
                    <label for="jenis_kelamin" class="control-label">Hak Akses</label>
                    
                        <select class="form-control" id="hak_akses" name="hak_akses">
                          <option value="0">Administrator</option>
                          <option value="1">Rekam Medis</option>
                          <option value="2">Perawat</option>
                        </select>
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
    
 </div>
 


@push('js')
<script>
   
  $(function () {

     
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    var table = $('#user-table').DataTable({
      
    });
    

$('#createNew').click(function () {
  $('#saveBtn').val("create-user");
  $('#user_id').val('');
  $('#userForm').trigger("reset");
  $('#modelHeading').html("Tambahkan User");
  $('#ajaxModel').modal('show');

});
 
$('body').on('click', '.editUser', function () {
      var user_id = $(this).data('id');
      $.get("{{ route('user.index') }}" +'/' + user_id +'/edit', function (data) {
          $('#modelHeading').html("Edit User");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#user_id').val(data.id);
          $('#nama').val(data.name);
          $('#email').val(data.email);
          $('#password').val(data.password);
          $('#hak_akses').val(data.hak_akses);
         
      })
   });
$('#saveBtn').click(function (e) {
  @if (count($errors) > 0)
    $('#ajaxModel').modal('show');
@endif
        $(this).html('Simpan');
    
        $.ajax({
          data: $('#userForm').serialize(),
          url: "{{ route('user.store') }}",
          type: "POST",
          dataType: 'json',
          complete: function(response) {
     
              $('#userForm').trigger("reset");
              
              location.reload();
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

$('body').on('click', '.deleteUser', function () {
     
     var pasien_id = $(this).data("id");
    if(confirm("Are You sure want to delete ?")){
   
     $.ajax({
         type: "DELETE",
         url: "{{route('user.store')}}"+'/'+pasien_id,
         success: function (data) {
          location.reload();

         },
         error: function (data) {
             console.log('Error:', data);
         }
     }
     );}
 });
  
  });

   
</script>
 
@endpush
@endsection
 