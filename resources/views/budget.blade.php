@extends('layout')

@section('title', 'Income By')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Budget Plan</h2>
        </div>

        <div class="col-md-12 list_column">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"> Budget Plan List</h3>
                    <button class="btn btn-primary is_see"><i class="uil-plus"></i> Add New</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="border p-2">
                                <h2 class="text-center">Need</h2>
                                <table class="table table-bordered table-striped w-100" id="needTable">
                                    <thead>
                                        <tr>
                                            <th>Expenditure</th>
                                            <th>Plan</th>
                                            <th>Actual</th>
                                            <th>Difference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-2">
                                <h2 class="text-center">Want</h2>
                                <table class="table table-bordered table-striped w-100" id="wantTable">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Expenditure</th>
                                            <th>Plan</th>
                                            <th>Actual</th>
                                            <th>Difference</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-2">
                                <h2 class="text-center">Savings</h2>
                                <table class="table table-bordered table-striped w-100" id="savingsTable">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Expenditure</th>
                                            <th>Plan</th>
                                            <th>Actual</th>
                                            <th>Difference</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script src="assets/js/data/budget_plan.js"></script>
    @endsection
