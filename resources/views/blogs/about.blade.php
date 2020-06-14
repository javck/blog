@extends('layouts.master')

@section('title')
    關於我
@endsection

@section('js')
    @parent
    <script src="jquery.js" />
@endsection

@section('content')
    <div class="container">
        <p> 我的生平...</p>
    </div>
    @php
        $a = 11;
    @endphp

    @forelse ($items as $item)
        <span>{{ $item }}</span>
        @if($loop->first)
            <span>第一個商品</span>
        @endif
        <span>{{ $loop->first }}</span>
    @empty
        沒有商品
    @endforelse
@endsection

@section('below_js')
    <script src="below.js" />
@stop

