 @extends('layouts.principal')

@section('title', 'Page Title')
<!-- Required files IO Example 02-12-2016-->
  
@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@stop

@section('content')
hola


@endsection