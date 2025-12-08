@extends('layout')

@section('title', 'Budget Plan')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Budget Plan</h2>
        </div>
        <div class="col-md-4 add_column">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span class="add_update_text">Add</span> Budget Plan</h3>
                </div>
                <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="mb-3">
                                <button class="btn btn-primary" id="addPreviousMonthPlan">Add Previous Month Plan</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="year_month" class="form-label required">Date</label>
                                <input type="text" class="form-control datepicker_year_month datepicker_year_month_mask"
                                    id="year_month" placeholder="yyyy-mm" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="expense_item_id" class="form-label"><span class="required">Expense Item</span>
                                    <a href="/expense-item" class="btn btn-sm btn-primary">Add Expense Item</a></label>
                                <select class="form-control select2" id="expense_item_id" required>
                                    <option value="">Select</option>

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <label for="amount" class="form-label required">Amount</label>
                                <input type="number" class="form-control" id="amount" placeholder="Enter Amount"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <input type="hidden" name="store_id" id="store_id" value="">
                                <button type="button" class="btn btn-primary" id="submitButton"> <span
                                        class="add_update_text">Add</span> Expense Item </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 list_column">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Budget Plan List</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="year_month_search" class="form-label">Date</label>
                                <input type="text" class="form-control datepicker_year_month datepicker_year_month_mask"
                                    id="year_month_search" placeholder="yyyy-mm" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="expense_item_id_search" class="form-label"><span class="">Expense
                                        Item</span></label>
                                <select class="form-control select2" id="expense_item_id_search" required>
                                    <option value="">Select</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary mt-3" id="searchButton"> Search </button>
                            </div>
                        </div>

                    </div>
                    <table class="table table-bordered  expense_item_table w-100" id="budgetPlanTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Expense Item</th>
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
    <script>
        // Initialize Select2
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script src="assets/js/data/budget_plan.js"></script>
@endsection
