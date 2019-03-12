@extends('layouts.app')

@section('title', 'Dance with The Death')

@section('content')

    @include('partials.instructions')

    <ol class="breadcrumb">
        <li><a href="{{route('appointments.index')}}">Appointments</a></li>
        <li class="active">Details</li>
    </ol>

    @if($appointment['user_id'])
        <h2>Sorry, this appointment has already been taken by {{$appointment['name'].' '.$appointment['last_name'] }}</h2>
        <a class="btn btn-warning" href="{{route('appointments.edit', $appointment['id'])}}">I want to edit</a>
    @else
        <h2>On {{\Carbon\Carbon::parse($appointment['start'])->format('d-M-Y')}}, The Death is available to dance
            from {{\Carbon\Carbon::parse($appointment['start'])->format('H:i:s')}}
            to {{\Carbon\Carbon::parse($appointment['end'])->format('H:i:s')}}</h2>

        <p>Would you like to book an appointment?</p>
        <a class="btn btn-primary" href="{{route('appointments.create', $appointment['start'])}}">Yes, I would</a>


    @endif

    <a class="btn btn-info" href="{{route('appointments.index')}}">No thanks. Just take me back</a>

    <br><br>
    <form action="{{ url('appointments' , $appointment['id']) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button class="btn btn-danger">Delete this Appointment</button>
    </form>

    @include('partials.lyrics')





@endsection
