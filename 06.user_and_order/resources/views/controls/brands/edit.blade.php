@extends('controls.layouts.app')

@section('content')
<div class="container mx-x1 px-2 py-6">
    <h1>Edit Brand</h1>
        <form method="POST" action="{{ route('controls.brands.update', $brand) }}">
            @csrf
            @method('PATCH')
            <p>name: <input type='text' name='name' value='{{ $brand->name }}'/></p>
            <p>search_key: <input type='text' name='search_key' value='{{ $brand->search_key }}'/></p>
            <p>index: <input type='number' name='order_index' min='0' max='9999' value='{{ $brand->order_index }}'/></p>
            <div>
                <p>show_in_list:</p>
                <p>Show <input type='radio' name='show_in_list' value='1' {{ ($brand->show_in_list ? "checked" : "") }}/></p>
                <p>Hide <input type='radio' name='show_in_list' value='0' {{ ($brand->show_in_list ? "" : "checked") }}/></p>
            </p>

            <div class="flex items-center mt-4">
                <x-button class="ml-3">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
</div>

@endsection

@section('inline_js')
    @parent
@endsection