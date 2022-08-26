@extends('layout')

@section('content')
    <div id="app" class="h-100 d-flex justify-content-center align-items-center app-bg-color">
        <div class="bg-main w-100 shadow-lg user-select-none {{ $isIndex ? 'py-5' : 'py-3' }}">
            <div class="justify-content-center bg-welcome {{ $isIndex ? 'row' : '' }}">
                <div class="{{ $isIndex ? 'col-11 col-md-8' : 'container' }}">
                    <div class="well">
                        @if($isIndex)
                            <main-menu :routes="{{ json_encode($routes) }}" :questions-data="{{ json_encode($questions) }}"></main-menu>
                        @else
                            <create-question :routes="{{ json_encode($routes) }}" :empty-question="{{ json_encode($emptyQuestion) }}"></create-question>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
