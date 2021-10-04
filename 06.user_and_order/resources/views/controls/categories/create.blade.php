@extends('controls.layouts.app')

@section('content')
<div class="container mx-auto max-w-screen-lg px-2 py-6">
    <div class="lg:flex lg:items-center lg:justify-between py-6">
        <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Create Category
        </h1>
    </div>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <form method="POST" action="{{ route('controls.categories.store') }}">
            @csrf
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <div class="mb-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label> 
                    <input type="text" name="name" id="name" autocomplete="name" value="{{ old('name')}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div class="mb-3">
                    <label for="search_key" class="block text-sm font-medium text-gray-700">Search_key</label> 
                    <input type="text" name="search_key" id="name" autocomplete="search_key" value="{{ old('search_key')}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-3">
                    <label for="order_index" class="block text-sm font-medium text-gray-700">Index</label> 
                    <input type="number" name="order_index" id="order_index" autocomplete="order_index" min='0' max='3000' value="{{ old('order_index')}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 rounded-md">
                </div>
                
        <fieldset>
              <div>
                <legend class="text-base font-medium text-gray-900">show_in_list</legend>
              </div>
              <div class="mt-4 space-y-4">
                <div class="flex items-center">
                  <input id="push-everything" name="show_in_list" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"  value='1' checked/>
                  <label for="push-everything" class="ml-3 block text-sm font-medium text-gray-700">
                    Show
                  </label>
                </div>
                <div class="flex items-center">
                  <input id="push-email" name="show_in_list" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"  value='0'/>
                  <label for="push-email" class="ml-3 block text-sm font-medium text-gray-700">
                    Hide
                  </label>
                </div>                
              </div>
            </fieldset>
            </div>
        <div class="flex items-center mt-4">
            <x-button class="m1-3">
                {{ __('Submit') }}
            </x-button>
        </div>
        </form>
    </div>
</div>
@endsection
@section('inline_js')
    @parent
@endsection