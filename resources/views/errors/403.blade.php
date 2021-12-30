@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('button')
    <a href="{{ url()->previous() }}" class="back-button">Go Back</a>
@endsection
