@extends('master')

@section('konten')
<div class="container mt-2">

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Admin</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Admin</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card-body">

        <table class="table table-bordered" id="ajax-crud-datatable">
           <thead>
              <tr>
                 <th>Id</th>
                 <th>Name</th>
                 <th>Email</th>
                
                 <th>Created at</th>
                 <th>Action</th>
              </tr>
           </thead>
        </table>

    </div>
   
</div>

  <!-- boostrap company model -->
    <div class="modal fade" id="company-modal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="CompanyModal"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Username" maxlength="50" readonly required>
                </div>
              </div>  

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"> Email</label>
                <div class="col-sm-12">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter  Email" maxlength="50" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" >
                </div>
              </div>

              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->

</body>
<script type="text/javascript">
     
 $(document).ready( function () {
$("#admin").addClass("active");
$("#user").removeClass("active");
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    $('#ajax-crud-datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('ajax-crud-datatable') }}",
           columns: [
                    { data: 'id_users', name: 'id_users' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false},
                 ],
                 order: [[0, 'desc']],
            columnDefs : [
  { targets: 0, visible: false }
]     
       });

  });
  
  function add(){

       $('#CompanyForm').trigger("reset");
       $('#CompanyModal').html("Add Admin");
       $('#company-modal').modal('show');
       $("#password").prop('required',true);
       $("#name").prop('readonly', false);
       $('#id').val('');

  }   
  function editFunc(id){
    
    $.ajax({
        type:"POST",
        url: "{{ url('edit-company') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
          $('#CompanyModal').html("Edit Admin");
          $('#company-modal').modal('show');
          $('#id').val(res.id_users);
          $('#name').val(res.username);
          $('#password').val('');
          $('#email').val(res.email);
          $("#password").prop('required',false);
       $("#name").prop('readonly', true);
       }
    });
  }  

  function deleteFunc(id){
        if (confirm("Delete Record?") == true) {
        var id = id;
         
          // ajax
          $.ajax({
              type:"POST",
              url: "{{ url('delete-company') }}",
              data: { id: id },
              dataType: 'json',
              success: function(res){

                var oTable = $('#ajax-crud-datatable').dataTable();
                oTable.fnDraw(false);
             }
          });
       }
  }

  $('#CompanyForm').submit(function(e) {

     e.preventDefault();
  
     var formData = new FormData(this);
  
     $.ajax({
        type:'POST',
        url: "{{ url('store-company')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
          $("#company-modal").modal('hide');
          var oTable = $('#ajax-crud-datatable').dataTable();
          oTable.fnDraw(false);
          $("#btn-save").html('Submit');
          $("#btn-save"). attr("disabled", false);
        },
        error: function(data){
           console.log(data);
         }
       });
   });

</script>
@endsection