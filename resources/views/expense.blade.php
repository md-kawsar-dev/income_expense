@extends('layout')

@section('title', 'Expense')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Expense</h2>
        </div>
        <div class="col-md-4 add_column">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span class="add_update_text">Add</span> Expense</h3>
                </div>
                <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="mb-3">
                                <label for="date" class="form-label required">Date</label>
                                <input type="text" class="form-control datepicker"
                                    id="date" placeholder="yyyy-mm-dd" required autocomplete="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="expense_item_id" class="form-label"><span class="required">Expense Item</span></label>
                                <select class="form-control select2" id="expense_item_id" required>
                                    <option>Select</option>

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
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description(optional)"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <input type="hidden" name="store_id" id="store_id" value="">
                                <button type="button" class="btn btn-primary" id="submitButton"> <span
                                        class="add_update_text">Add</span> Expense </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 list_column">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Expense List</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="year_search" class="form-label">Year</label>
                                <input type="text" class="form-control yearpicker"
                                    id="year_search" placeholder="yyyy" value="{{ date('Y') }}" autocomplete="" required >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                @php
                                    $months = [
                                        1=>"January",
                                        2=>"February",
                                        3=>"March",
                                        4=>"April",
                                        5=>"May",
                                        6=>"June",
                                        7=>"July",
                                        8=>"August",
                                        9=>"September",
                                        10=>"October",
                                        11=>"November",
                                        12=>"December",
                                    ]
                                @endphp
                                <label for="month_search" class="form-label">Month</label>
                                <select name="month_search" id="month_search" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>
                                            {{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="date_search" class="form-label">Date</label>
                                <input type="text" class="form-control datepicker_single"
                                    id="date_search" placeholder="yyyy-mm-dd"  autocomplete="" required >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="expense_item_id_search" class="form-label"><span class="">Expense
                                        Item</span></label>
                                <select class="form-control select2" id="expense_item_id_search" required>
                                    <option>Select</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary mt-3" id="searchButton"> Search </button>
                                <button type="button" class="btn btn-info mt-3" id="refreshButton"> Refresh </button>
                            </div>
                        </div>

                    </div>
                    <table class="table table-bordered w-100" id="expenseTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
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
    <script src="assets/js/data/expense.js"></script>
@endsection
