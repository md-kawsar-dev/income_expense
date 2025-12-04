@extends('layout')

@section('title', 'Income By')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Category</h2>
        </div>
        <div class="col-md-4 add_column">
            <div class="card">
                <div class="card-header"><h3 class="card-title"><span class="add_update_text">Add</span> Category</h3></div>
                <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="mb-3">
                                <label for="category_type" class="form-label required">Type</label>
                                <select class="form-select" id="category_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Need">Need</option>
                                    <option value="Want">Want</option>
                                    <option value="Savings">Savings</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="category_name" class="form-label required">Name</label>
                                <input type="text" class="form-control" id="category_name" placeholder="Enter Category Name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amount" placeholder="Enter Amount">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <input type="hidden" name="store_id" id="store_id" value="">
                                <button type="button" class="btn btn-primary"  id="submitButton"> <span class="add_update_text">Add</span> Category </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 list_column">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Category List</h3></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped category_table w-100" id="categoryTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Amount</th>
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
    <script src="assets/js/data/category.js"></script>
@endsection