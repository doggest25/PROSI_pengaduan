@extends('layout.template')

@section('title')
@endsection
@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif



@endsection