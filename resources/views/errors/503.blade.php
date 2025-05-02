@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('image')
    <img src="{{asset('backend/assets/images/maintenance.jpg')}}" width="500" height="500">
@endsection
@section('message', __($exception->getMessage() ?: 'Service Unavailable'))
