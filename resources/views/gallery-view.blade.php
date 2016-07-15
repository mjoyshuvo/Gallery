@extends('layouts.app')

@section('content')
<style type="text/css">
	#gallery_images img{
		width: 240px;
		height: 160px;
		border:2px groove indigo;
		margin-bottom: 10px;
	}
	#gallery_images ul{
		margin: 0;
		padding: 0;
	}
	#gallery_images li{
		margin: 0;
		padding: 0;
		list-style: none;
		float: left;
		padding-right: 10px;
	}
</style>
	<div class="row">
		<div class="col-md-12" style="color: teal">
			<h1>{{$gallery->name}}</h1>
		</div>
	</div><br>

	{{-- Image Field Starts--}}
	<div class="row">
		<div class="col-md-12">
			<div id="gallery_images">
				<ul>
					@foreach ($gallery->images as $image)
						<li>
							<a href="{{ url($image->file_path) }}" data-lightbox="mygallery">
								<img src="{{ url($image->file_path) }}">
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	{{-- Image Field Ends --}}

	{{-- Dropzone Box Starts--}}

	<div class="row">
		<div class="col-md-12">
			<form action="{{ url('image/do-upload') }}" class="dropzone" id="addImages">
				{{ csrf_field() }}
				<input type="hidden" name="gallery_id" value="{{ $gallery->id }}">
			</form>
		</div>
	</div><br>

	{{-- DropzoneBox Ends --}}

	<div class="row">
		<div class="col-md-12">
			<a href="{{url('gallery/list')}}" class="btn btn-default teal darken-1">Back</a>
		</div>
	</div>
@stop