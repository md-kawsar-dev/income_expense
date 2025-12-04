@extends('layout')

@section('title', 'Income By')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Income By </h2>
        </div>
        <div class="col-md-6 add_column">
            <div class="card">
                <div class="card-header"><h3 class="card-title"><span class="add_update_text">Add</span> Income By</h3></div>
                <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="mb-3">
                                <label for="income_by_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="income_by_name" placeholder="Enter Income By Name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <input type="hidden" name="income_by_id" id="income_by_id" value="">
                                <button type="button" class="btn btn-primary"  id="incomeBySubmitButton"> <span class="add_update_text">Add</span> Income By </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 list_column">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Income By List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped income_by_table w-100" id="incomeByTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
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
    <script src="assets/js/data/income_by.js"></script>
@endsection