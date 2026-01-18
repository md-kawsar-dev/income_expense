@extends('layout')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>Welcome to the Dashboard</h1>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-md-6 col-xl-3">
            <div class="card widget-flat text-bg-success">
                <div class="card-body">

                    <h6 class="text-uppercase text-reset mt-0" title="Total Income">Total Income</h6>
                    <h3 class="mt-3 mb-3 text-reset total_income_balance"></h3>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card widget-flat text-bg-danger">
                <div class="card-body">

                    <h6 class="text-uppercase text-reset mt-0" title="Total Expense">Total Expense</h6>
                    <h3 class="mt-3 mb-3 text-reset total_expense_balance"></h3>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card widget-flat text-bg-primary">
                <div class="card-body">

                    <h6 class="text-uppercase text-reset mt-0" title="Total Balance">Total Balance</h6>
                    <h3 class="mt-3 mb-3 text-reset total_balance"></h3>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card widget-flat text-bg-secondary">
                <div class="card-body">

                    <h6 class="text-uppercase text-reset mt-0" title="Total Savings">Total Savings</h6>
                    <h3 class="mt-3 mb-3 text-reset total_savings_balance"></h3>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection

@section('script')
    <script src="assets/js/data/dashboard.js"></script>
@endsection
