@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>My Galleries</h1>
		</div>
	</div>
		{{-- =====================Listings and Forms======= --}}	
	<div class="row">
		<div class="col-md-8">
			@if ($galleries->count() > 0)
				<table class="table table-striped table-bordered">
					<thead>
						<tr class="info">
							<th>Name of the gallery</th>
							<th>Number of Image</th>
							<th>Created By</th>
							<th></th>
						</tr>		
					</thead>

					<tbody>
						@foreach ($galleries as $gallery)
							<tr>
								<td>{{$gallery->name}}</td>
								<td>{{$gallery->images()->count()}}</td>
								<td>{{$gallery->created_by}}</td>
								<td><a href="{{ url('gallery/view/' . $gallery->id) }}">View</a> / 
								<a href="{{ url('gallery/delete/' . $gallery->id) }}">Delete</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>

		<div class="col-md-4">
			{{-- Error Message --}}
			@if(count($errors)>0)
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			{{-- Error Message Ends --}}

			{{-- Success Message --}}
			@if(Session::has('success'))
		        <section class="alert alert-success" style="text-align: center;">
		            {{Session::get('success')}}
		        </section>
		    @endif

			{{-- Success Message Ends --}}


			{{-- Form Starts --}}

			<form method="POST" action="{{url('gallery/save')}}">
			<input type="hidden" value="{{ Session::token() }}" name="_token">		
			<div class="form-group">
				<input type="text" name="gallery_name" id="gallery_name" class="form-control" placeholder="Name of the gallery" value="{{ old('gallery_name') }}"/>
			</div>
			<button class="btn btn-default teal darken-1">SAVE</button>
			</form>
		</div>
	</div>
	
@stop