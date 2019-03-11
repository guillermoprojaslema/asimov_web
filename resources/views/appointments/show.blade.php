@extends('layouts.app')

@section('title', 'Dance with The Death')

@section('content')
    @if($appointment->user_id)
        <h2>Sorry, this appointmet has already been taken by {{$appointment->user()->first()->name}}. Please choose
            another available hour</h2>
    @else
        <h2>On {{\Carbon\Carbon::parse($appointment->start)->format('d-M-Y')}}, The Death is available to dance
            from {{\Carbon\Carbon::parse($appointment->start)->format('H:i:s')}}
            to {{\Carbon\Carbon::parse($appointment->end)->format('H:i:s')}}</h2>
        <p>Would you like to book an appointment?</p>

        <a class="btn btn-primary" href="{{route('appointments.create', $appointment->start)}}">Yes, I would</a>
        <a class="btn btn-danger" href="{{route('appointments.index')}}">No thanks. Just take me back</a>

    @endif





@endsection
