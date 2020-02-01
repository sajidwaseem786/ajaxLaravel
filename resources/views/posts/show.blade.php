@extends('layouts.app')
@section('content')

<div class="container">

<h3 class="display-3">Detail Of Post</h3>


<h4>Title:{{$detailPost->title}}</h4>
Body:{{$detailPost->body}}

<br><br>
<a href="{{url('posts')}}" class="btn btn-primary">Back</a>
</div>

@endsection