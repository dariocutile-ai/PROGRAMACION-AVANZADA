@extends('layouts.app')

@section('title', 'Nueva categoria | InventoryPro')
@section('page_title', 'Nueva categoria')

@section('content')
<div class="github-panel p-4">
    <form method="post" action="{{ route('categories.store') }}">
        @include('categories._form')
    </form>
</div>
@endsection
