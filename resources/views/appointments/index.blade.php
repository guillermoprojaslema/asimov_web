@extends('layouts.app')

@section('title', 'Dance with the Death')

@section('content')

    @include('partials.flash-message')

    @include('partials.instructions')




    @if($calendar)
        {!! $calendar->calendar() !!}
        {!! $calendar->script() !!}

    @else
        <h3>There isn't any appointments yet</h3>
    @endif

    <br>
    @include('partials.lyrics')


@endsection
