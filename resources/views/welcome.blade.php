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
            <div class="card">
                <div class="card-body bg-success text-dark">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="fw-normal mt-0 text-truncate" title="Total Income">Total Income</h4>
                            <h3 class="my-2 py-1 text-center total_income_balance"></h3>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> 
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body bg-danger text-white">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="fw-normal mt-0 text-truncate" title="Total Expense">Total Expense</h4>
                            <h3 class="my-2 py-1 text-center total_expense_balance"></h3>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="fw-normal mt-0 text-truncate" title="Total Balance">Total Balance</h4>
                            <h3 class="my-2 py-1 text-center total_balance"></h3>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body bg-secondary text-white">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="fw-normal mt-0 text-truncate" title="Total Savings">Total Savings</h4>
                            <h3 class="my-2 py-1 text-center total_savings_balance"></h3>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

    </div>
    <!-- end row -->
@endsection

@section('script')
    <script src="assets/js/data/dashboard.js"></script>
@endsection
