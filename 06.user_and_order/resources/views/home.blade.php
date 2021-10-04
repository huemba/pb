@extends('layouts.app')

@section('content')
<x-pb-label for="Home" :value="__('Home')" class="pb" aaa="ccc" />

@endsection

@section('inline_js')
    @parent
@endsection