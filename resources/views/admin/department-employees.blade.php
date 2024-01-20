@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color:#DAE3D1 ; border-color: #2C3128;">
                    <div class="card-header" style="background-color: #2C3128; color: #FFFFFF;">{{ __('Department Employees') }}</div>

                    <div class="card-body">
                        <table id="employees-datatable" class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Is Administrator</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="ajaxModel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="model-header">
                                    <h4 class="modal-title" id="modalHeading"></h4>
                                </div>
                                <div class="modal-body">
                                    <form id="employeeForm" name="employeeForm" class="form-horizontal">
                                        <div class="form-group">
                                            Name: <br>
                                            <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Name" value="" required>
                                        </div>
                                        <div class="form-group">
                                            Email: <br>
                                            <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Enter Email" value="" required>
                                        </div>
                                        <div class="form-group">
                                            Department: <br>
                                            <input type="text" class="form-control" id="deptName" name="deptName"
                                            placeholder="Enter Department" value="">
                                        </div>
                                        <div class="form-group">
                                            Is Administrator: <br>
                                            <input type="boolean" class="form-control" id="is_admin" name="is_admin"
                                            placeholder="Is the employee administrator?" value="">
                                        </div>
                                        <input type="hidden" id="employee_id" name="employee_id" value="">
                                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create"
                                            style="background-color: #7EA951; border-color: #7EA951; color: #FFFFFF;">
                                            Save
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $("#employees-datatable").DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('department.employees', ['department' => $department ?? '']) }}",
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'deptName', name: 'deptName'},
                {data: 'is_admin', name: 'is_admin'},
                {data: 'action', name: 'action'},
            ]
            });
            $('body').on('click', '.deleteEmployee', function(){
                var employee_id = $(this).data('id');
                if (confirm("Are you sure?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('employees.destroy', ['employee' => ':employee_id']) }}".replace(':employee_id', employee_id),
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error: ', data);
                        }
                    });
                }
            })
            $('body').on('click', '.editEmployee', function(){
                var employee_id = $(this).data('id');
                $.get("{{ route('employees.edit', ':employee_id') }}".replace(':employee_id', employee_id), function(data)
                {
                    $('#ajaxModel').modal('show');
                    $("#modalHeading").html("Edit Employee");
                    $("#employee_id").val(data.id);
                    $("#name").val(data.name);
                    $("#email").val(data.email);
                    $("#deptName").val(data.deptName);
                    $("#is_admin").val(data.is_admin);
                });
            })
            $('#saveBtn').click(function(e){
                e.preventDefault();
                $(this).html('Save');
                
                var employee_id = $("#employee_id").val();

                $.ajax({
                    data: $("#employeeForm").serialize(),
                    url: "{{ route('employees.update', ':employee_id') }}".replace(':employee_id', employee_id),
                    type: "PUT",
                    dataType: 'json',
                    success: function(data) {
                        $("#employeeForm").trigger("reset");
                        $("#ajaxModel").modal('hide');
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error: ', data);
                        $('#saveBtn').html('Save');
                    }
                });
            })

        })
    </script>
@endsection
