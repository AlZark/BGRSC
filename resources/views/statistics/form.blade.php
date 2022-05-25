@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Report') }}</div>

                    <div class="card-body">
                        <form class="form" method="post" action="{{ route('statistics.store') }}">
                            @csrf
                            <div class="form-group">

                                <label>Month</label><br>
                                <input type="month" name="report_date"><br>

                                <label>Animal</label><br>
                                <select name="animalId">
                                @foreach($animals as $animal)
                                        <option value="{{ $animal['id'] }}">{{ $animal['title'] }}</option>
                                @endforeach
                                </select><br>

                                @foreach($types as $type)
                                    <label> {{ $type['title'] }} </label><br>
                                    <input type="number" name="{{ 'amount' . $type['id'] }}"><br>
                                @endforeach

                                <input type="submit" value="Report" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
