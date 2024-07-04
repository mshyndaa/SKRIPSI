@extends('Template')

@section('content')
<div class="container mt-5">
  <div class="row">
      <div class="col-lg-12 d-flex justify-content-end mb-3">
          <button class="btn btn-primary" onclick="add()">Create Admin</button>
      </div>
  </div>

  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  @endif

  <div class="card shadow">
      <div class="card-body">
          <table class="table table-hover table-bordered" id="ajax-crud-datatable">
              <thead class="thead-light">
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Created At</th>
                      <th>Action</th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>

<div class="modal fade" id="company-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header bg-primary text-white">
              <h4 class="modal-title" id="CompanyModal"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form id="CompanyForm" name="CompanyForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="id" id="id">
                  <div class="form-group row">
                      <label for="name" class="col-sm-3 col-form-label">Username</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="name" name="name" placeholder="Enter Username" maxlength="50" readonly required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="email" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-9">
                          <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" maxlength="50" required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="password" class="col-sm-3 col-form-label">Password</label>
                      <div class="col-sm-9">
                          <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                      </div>
                  </div>

                  <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-primary" id="btn-save">Save Changes</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
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
            { data: 'action', name: 'action', orderable: false }
        ],
        order: [[0, 'desc']],
        columnDefs: [
            { targets: 0, visible: false }
        ]
    });
});

function add() {
    $('#CompanyForm').trigger("reset");
    $('#CompanyModal').html("Add Admin");
    $('#company-modal').modal('show');
    $("#password").prop('required', true);
    $("#name").prop('readonly', false);
    $('#id').val('');
}

function editFunc(id) {
    $.ajax({
        type: "POST",
        url: "{{ url('edit-company') }}",
        data: { id: id },
        dataType: 'json',
        success: function (res) {
            $('#CompanyModal').html("Edit Admin");
            $('#company-modal').modal('show');
            $('#id').val(res.id_users);
            $('#name').val(res.username);
            $('#password').val('');
            $('#email').val(res.email);
            $("#password").prop('required', false);
            $("#name").prop('readonly', true);
        }
    });
}

function deleteFunc(id) {
    if (confirm("Delete Record?")) {
        $.ajax({
            type: "POST",
            url: "{{ url('delete-company') }}",
            data: { id: id },
            dataType: 'json',
            success: function (res) {
                var oTable = $('#ajax-crud-datatable').DataTable();
                oTable.draw(false);
            }
        });
    }
}

$('#CompanyForm').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: "{{ url('store-company') }}",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function () {
            $("#company-modal").modal('hide');
            var oTable = $('#ajax-crud-datatable').DataTable();
            oTable.draw(false);
            $("#btn-save").html('Submit');
            $("#btn-save").attr("disabled", false);
        },
        error: function (data) {
            console.log(data);
        }
    });
});
</script>
@endsection
