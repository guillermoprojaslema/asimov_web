@extends('layouts.app')

@section('title', 'Dance with The Death')

@section('content')



    @include('partials.instructions')

    <ol class="breadcrumb">
        <li><a href="{{route('appointments.index')}}">Appointments</a></li>
        <li class="active">Edit</li>
    </ol>


    <h4>Who's going to book it?</h4>
    <form method="POST" action="{{action('AppointmentsController@update', [$appointment['id']])}}">
        {{ method_field('PATCH') }}
        {!! csrf_field() !!}
        <div class="form-group  {{ $errors->has('name') ? 'has-error' : ''}}">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$appointment['name']}}">
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group  {{ $errors->has('last_name') ? 'has-error' : ''}}">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name"
                   value="{{$appointment['last_name']}}">
            {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group  {{ $errors->has('email') ? 'has-error' : ''}} ">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$appointment['email']}}">
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group  {{ $errors->has('start') ? 'has-error' : ''}}">
            <label for="start">Start:</label>
            <input type="text" class="form-control" id="start" name="start"
                   value="{{\Carbon\Carbon::parse($appointment['start'])->format('m/d/Y g:i A')}}">
            {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
        </div>

        <input type="submit" class="btn btn-info" value="Book it">

    </form>


    @include('partials.lyrics')


    <script type="text/javascript">
        $(function () {
            $('#start').datetimepicker();
        });
    </script>
@endsection
