@extends('template')

@section('content')
<div class="container mt-5">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow" style="margin-top: 5rem">
        <div class="card-body">
            <table class="table table-hover table-bordered" id="ajax-crud-datatable">
                <thead class="thead-light">
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
</div>

<!-- Bootstrap company model -->
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
                <form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">Active</div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="isactive" id="isactive" value="1">
                                <label class="form-check-label" for="isactive">Active User</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mall Access</label>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="mall[]" id="mall_1" value="1">
                                <label class="form-check-label" for="mall_1">Gandaria City</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="mall[]" id="mall_2" value="2">
                                <label class="form-check-label" for="mall_2">Kota Kasablanka</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="mall[]" id="mall_3" value="3">
                                <label class="form-check-label" for="mall_3">Blok M</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#admin").removeClass("active");
    $("#user").addClass("active");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#ajax-crud-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('ajax-crud-user-datatable') }}",
        columns: [
            { data: 'id_users', name: 'id_users' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false },
        ],
        order: [[0, 'desc']],
        columnDefs: [
            { targets: 0, visible: false }
        ]
    });
});

function add() {
    $('#CompanyForm').trigger("reset");
    $('#CompanyModal').html("Add User");
    $('#company-modal').modal('show');
    $("#password").prop('required', true);
    $("#name").prop('readonly', false);
    $('#id').val('');
}

function editFunc(id) {
    $.ajax({
        type: "POST",
        url: "{{ url('edit-user') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res) {
            $('#CompanyModal').html("Edit User");
            $('#company-modal').modal('show');
            $('#id').val(res[0].id_users);
            $('#name').val(res[0].username);
            $('#password').val('');
            $('#email').val(res[0].email);

            if (res[0].active == '1')
                $('#isactive').prop('checked', true);
            else
                $('#isactive').prop('checked', false);

            $("#password").prop('required', false);
            $("#name").prop('readonly', true);

            $.ajax({
                type: "POST",
                url: "{{ url('edit-mall') }}",
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.length != 0) {
                        for (var i = 0; i < response.length; i++) {
                            $(":checkbox[value='" + response[i]['company_id'] + "']").attr('checked', true);
                        }
                    }
                }
            });
        }
    });
}

function deleteFunc(id) {
    if (confirm("Delete Record?")) {
        $.ajax({
            type: "POST",
            url: "{{ url('delete-user') }}",
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var oTable = $('#ajax-crud-datatable').DataTable();
                    oTable.draw(false);
                } else {
                    alert("Deletion failed: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error deleting user:", error);
                alert("An error occurred while deleting.");
            }
        });
    }
}


$('#CompanyForm').submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: "{{ url('store-user')}}",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            $("#company-modal").modal('hide');
            var oTable = $('#ajax-crud-datatable').DataTable();
            oTable.draw(false);
            $("#btn-save").html('Submit');
            $("#btn-save").attr("disabled", false);
        },
        error: function(data) {
            console.log(data);
        }
    });
});
</script>
@endsection
