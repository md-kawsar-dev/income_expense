@extends('layout')

@section('title', 'Income By')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Budget Plan</h2>
        </div>

        <div class="col-md-12 list_column">
            <div class="card">
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
                                <select name="month_search" id="month_search" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>
                                            {{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary mt-3" id="searchButton"> Search </button>
                                {{-- <button type="button" class="btn btn-info mt-3" id="refreshButton"> Refresh </button> --}}
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <hr>
                            <h2 class="text-center">Need</h2>
                            <table class="table table-bordered  w-100" id="needTable">
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
                        <div class="col-md-4">
                            <hr>
                            <h2 class="text-center">Want</h2>
                            <table class="table table-bordered  w-100" id="wantTable">
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
                        <div class="col-md-4">
                            <hr>
                            <h2 class="text-center">Savings</h2>
                            <table class="table table-bordered  w-100" id="savingsTable">
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
    @endsection
    @section('script')
        <script src="assets/js/data/budget.js"></script>
    @endsection
