@extends('layouts.app')

@section('content')
    <script>
        document.getElementsByTagName('body')[0].setAttribute('onload','loadedAction()');
    </script>
    <div class="container">
        <h1>
            Placepost 상세보기
        </h1>
        <hr/>

        <div class="map_wrap">
            <div id="map" style="width:100%;height:100%;position:relative;overflow:hidden;"></div>
        </div>

        <article data-id="{{ $placepost->id }}">
            <div class="form-group">
                <label for="title">
                    제목
                </label>
                <input type="text" name="title" id="title" value="{{ $placepost->title }}" class="form-control" readonly="true">
            </div>

            <div class="form-group">
                <label for="content">
                    본문
                </label>
            <textarea name="content" id="content" rows="5" class="form-control" readonly="true">
                {{ $placepost->content }}
            </textarea>
            </div>
                @include('attachments.partial.list', ['attachments' => $placepost->attachments])
            <br>
        </article>

        <div class="text-center">
            <p>
                @can('update', $placepost)
                <a href="{{ route('placeposts.edit', $placepost->id) }}" class="btn btn-info">
                    <i class="fa fa-pencil"></i>
                    수정하기
                </a>
                @endcan
                @can('delete', $placepost)
                {{--destroy 와 show 는 같은 uri로 맵핑되고 메서드가 다르다. destory는 delete, show는 get--}}
                {{--이렇게 하면 get메서드로 보내지기 때문에 destory가 아니라 show가 되버린다 이를 form으로 처리하던지 ajax로 처리하던지--}}
                {{--<a href="{{ route('placeposts.destroy', $placepost->id) }}" class="btn btn-danger">--}}
                    {{--<i class="fa fa-trash-o"></i>--}}
                    {{--삭제하기--}}
                {{--</a>--}}
                <button class="btn btn-danger button__delete">
                    <i class="fa fa-trash-o"></i>
                    삭제하기
                </button>
                @endcan
                <a href="#" class="btn btn-info">위치 수정</a>
                <a href="{{ route('placeposts.index') }}" class="btn btn-default">
                    <i class="fa fa-list"></i>
                    글 목록
                </a>
            </p>
        </div>
    </div>
@stop

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.button__delete').on('click', function (e) {
            console.log('hello')
            var placepostId = $('article').data('id');
            console.log('placepostId')
            if (confirm('글을 삭제합니다.')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/placeposts/' + placepostId
                }).then(function () {
                    window.location.href = '/placeposts';
                });
            }
        });
    </script>
@stop
@section('style')
    <style>
        .map_wrap, .map_wrap * {
            margin: 0;
            padding: 0;
            font-family: 'Malgun Gothic', dotum, '돋움', sans-serif;
            font-size: 12px;
        }

        .map_wrap a, .map_wrap a:hover, .map_wrap a:active {
            color: #000;
            text-decoration: none;
        }

        .map_wrap {
            position: relative;
            width: 100%;
            height: 500px;
        }

    </style>
@stop

@section('script')
    <script>
        function loadedAction() {
            var map = makeMap();
            var lat = '{{$placepost->lat}}';
            var lng = '{{$placepost->lng}}';
            var name =

            var marker = makeMarker(map, lat, lng)

            displayInfowindow(marker, name);
        }

        function makeMap() {
            var container = document.getElementById('map'); //지도를 담을 영역의 DOM 레퍼런스
            var options = { //지도를 생성할 때 필요한 기본 옵션
                center: new daum.maps.LatLng(33.450701, 126.570667), //지도의 중심좌표.
                level: 3 //지도의 레벨(확대, 축소 정도)
            };

            return new daum.maps.Map(container, options); //지도 생성 및 객체 리턴
        }

        function makeMarker(map, lat, lng) {
            var marker = new daum.maps.Marker({
                position: new daum.maps.LatLng(lat, lng),
                clickable: true
            });

            marker.setMap(map);
            return marker;
        }

        function displayInfowindow(marker, title) {
            var content = '<div style="padding:5px;z-index:1;">' + title + '</div>';

            infowindow.setContent(content);
            infowindow.open(map, marker);
        }
    </script>
@stop
