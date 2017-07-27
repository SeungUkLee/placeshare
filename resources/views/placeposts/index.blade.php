@extends('layouts.app')

@section('content')
    @php $viewName = 'placeposts.index'; @endphp
    {{--<div class="container">--}}
        {{--<h1>--}}
            {{--위치 정보 목록--}}
        {{--</h1>--}}
        {{--<ul>--}}
            {{--@forelse ($placeposts as $placepost)--}}
                {{--<li>--}}
                    {{--{{ $placepost->title }}--}}
                    {{--<small>--}}
                        {{--by {{ $placepost->user->name }}--}}
                    {{--</small>--}}
                {{--</li>--}}
            {{--@empty--}}
                {{--<p> 추가하신 위치 정보가 없습니다.</p>--}}
            {{--@endforelse--}}
        {{--</ul>--}}
    {{--</div>--}}

    {{--@if($placepost->count())--}}
        {{--<div class="text-center">--}}
            {{--{!! $placepost->render() !!}--}}
        {{--</div>--}}
    {{--@endif--}}
    <div class="row">
        <div class="col-md-9">
            지도
        </div>

        <div class="col-md-3">
            <article>
                @forelse($placeposts as $placepost)
                    @include('placeposts.partial.placepost', compact('placepost'))
                @empty
                    <p class="text-center text-danger">
                        추가하신 위치 정보가 없습니다
                    </p>
                @endforelse
            </article>
        </div>
    </div>



@stop
