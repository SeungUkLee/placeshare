@extends('layouts.app')

@section('content')
    @php $viewName = 'placeposts.index'; @endphp
    <div class="row">
        <div class="col-md-9" id="map-wrap">
            @include('map.index')
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

@section('script')
