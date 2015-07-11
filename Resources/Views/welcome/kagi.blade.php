@extends('module_info')

{{-- Web site Title --}}
@section('title')
{{ Config::get('general.title') }} :: @parent
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
@stop


{{-- Content --}}
@section('content')

	<div class="container">
		<div class="content">
			<a href="/">
				<img src="/assets/images/kagi.png">
			</a>
			<div class="title">
				<a href="/">
					Kagi
				</a>
			</div>
			<div class="quote">
				鍵 : kagi
				<br>
				noun - key also can refer to the lock itself
				<br>
				Kagi is a module for Laravel 5 Authentification and Authorization
			</div>
		</div>
	</div>

@stop
