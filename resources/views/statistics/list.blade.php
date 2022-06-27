@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>{{ Auth::user()->title }} reports</h1>
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Report date</th>
                        <th scope="col">Animal</th>
                        @foreach($types as $type)
                            <th scope="col">{{$type->title}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{$report['report_date']}}</td>
                            <td>{{$report['animal']}}</td>
                            @foreach($types as $type)
                                <td>
                                    {{$report[$type->title]}}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>All time statistics</h2>
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th>Total</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($statistics as $statistic)
                        <tr>
                            <td>Total {{ $statistic->animal->title }}s {{$statistic->type->title}}</td>
                            <td>{{$statistic->sum}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <a class="btn btn-primary float-end" href="{{route('message')}}">
                Read more
            </a>
        </div>
    </div>
@endsection
