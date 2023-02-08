@extends('layouts.user')

@section('title', 'Home')

@section('content')

<h3 class="text-center">Latest Blogs</h3>
@livewire('blogs.components.partial-table')

@endsection