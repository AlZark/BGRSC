@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="filters">
                    <h3>Filters</h3>
                    <form class="form" method="get" action="{{ route('statistics.all') }}">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>From</label><br>
                                <input type="month" class="form-control" name="from_date"
                                       value="{{ request('from_date') }}"><br>
                            </div>
                            <div class="col-sm-3">
                                <label>To</label><br>
                                <input type="month" class="form-control" name="to_date"
                                       value="{{ request('to_date') }}"><br>
                            </div>
                            <div class="col-sm-3">
                                <label>Animal</label><br>
                                <select class="form-control" name="animal">
                                    <option value="">All</option>
                                    @foreach($animals as $animal)
                                        <option {{$animal->id == request()->get('animal') ? 'selected' : ''}}
                                                value="{{$animal->id}}">{{$animal->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <br>
                                <input type="submit" value="Filter" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
                <h1>Reports</h1>
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
            <div class="col-md-9">
                <h2>Statistics</h2>
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
                <canvas id="statisticChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('statisticChart').getContext('2d');
        @if(request()->get('animal') != '')

        const label = [@foreach($types as $type) '{{$type->title}}', @endforeach()];
        const data = [];
        @foreach($types as $typeKey => $type)
            data[{{$typeKey}}] = [@foreach($reports as $report) @foreach($report as $key => $element) @if($type->title == $key) '{{$report[$key]}}', @endif @endforeach() @endforeach()]
        @endforeach()
        console.log(data);
        const labelLen = label.length;
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [@foreach($reports as $report) '{{ $report['report_date'] }}', @endforeach],
                datasets: [
                        @foreach($types as $key => $type)
                    {
                        label: label[{{$key}}],
                        data: data[{{$key}}],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(150, 200, 16, 1)',
                            'rgba(110, 100, 250, 1)',
                            'rgba(10, 180, 100, 1)',
                        ],
                        borderWidth: 1
                    },
                    @endforeach()
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        @else
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [@foreach($statistics as $statistic) '{{ $statistic->animal->title }}s {{$statistic->type->title}}', @endforeach],
                datasets: [{
                    label: '# of Cases',
                    data: [@foreach($statistics as $statistic) '{{ $statistic->sum }}', @endforeach],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        @endif
    </script>
@endsection
