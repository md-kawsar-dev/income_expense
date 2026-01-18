@extends('layout')

@section('title', 'Income By')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Users</h2>
        </div>
        <div class="col-md-4 add_column">
            <div class="card">
                <div class="card-header"><h3 class="card-title"><span class="add_update_text">Add</span> User</h3></div>
                <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="mb-3">
                                <label for="role_id" class="form-label"><span class="required">Role</span></label>
                                <select class="form-control select2" id="role_id" required>
                                    {{-- <option>Select Role</option> --}}
                                    <option value="2">Admin</option>
                                    <option value="3">Editor</option>
                                    <option value="4">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="name" class="form-label required">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Name" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="mb-3">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter Email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter Username">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" placeholder="Enter Phone">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="mb-3">
                                <input type="hidden" name="store_id" id="store_id" value="">
                                <button type="button" class="btn btn-primary"  id="submitButton"> <span class="add_update_text">Add</span> User </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 list_column">
            <div class="card">
                <div class="card-header"><h3 class="card-title"> Users List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped users_table w-100" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Action</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="assets/js/data/users.js"></script>
@endsection