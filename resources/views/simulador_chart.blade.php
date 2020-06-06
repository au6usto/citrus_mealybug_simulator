@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="app">
                {!! $chart->container() !!}
            </div>
        </div>
    </div>
</div>
<script type="module" src="{{ asset('js/app_vue.js') }}"></script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.js charset=utf-8></script>
{!! $chart->script() !!}
@endsection