@extends('layouts.user')

@section('title', 'Home')

@section('content')
{{-- CAROUSEL --}}
<div class="row mx-0">
	<div class="col-12 mx-0">
		<div class="w-100" id="carousel" data-image="{{ route('api.carousel.fetch') }}" data-sp="{{ asset('storage/uploads/settings/carousel') }}" data-arrow="{{ asset('images/settings/carousel/arrow.png') }}" data-flex="true"></div>
		<script type="text/javascript" src="{{ asset('js/hooks/carouselHook.js') }}" id="carouselHook"></script>
		<script type="text/javascript" src="{{ asset('js/components/login-page.js') }}"></script>
	</div>
</div>

<h3 class="text-center">Latest Blogs</h3>

@livewire('blogs.components.partial-table')
@endsection