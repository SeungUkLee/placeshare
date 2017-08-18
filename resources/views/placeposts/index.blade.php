@extends('layouts.app')

@section('content')
    @php $viewName = 'placeposts.index'; @endphp
    {{--<div class="container" id="content-wrap">--}}
    <div class="row-fluid">
        <div class="col-sm-9" id="map-wrap">
            @include('map.index')
        </div>
        <div class="col-sm-3" id="placeposts-wrap">
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
    {{--</div>--}}
@stop

@section('script')
