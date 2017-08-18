@extends('layouts.app')

@section('content')
    <script>
        document.getElementsByTagName('body')[0].setAttribute('onload','loadedAction()');
    </script>
    <div class="container">
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

        function loadedAction() {
            var lat = '{{$placepost->lat}}';
            var lng = '{{$placepost->lng}}';
            var name = '{{$placepost->placename}}';

            var map = makeMap(name, lat, lng);

            changeLinkForSearchPath(map, name, lat, lng);
        }

        function makeMap(name, lat, lng) {
            var container = document.getElementById('map');
            var options = {
                center: new daum.maps.LatLng(lat, lng),
                level: 3,
                marker : {
                    position: new daum.maps.LatLng(lat, lng),
                    text: name
                }
            };

            return new daum.maps.StaticMap(container, options);
        }
        function changeLinkForSearchPath(map, name, lat, lng) {
            $('#map').ready(function () {
                $('#map>a')[0].href = "http://map.daum.net/link/to/" + name + "," + lat + "," + lng;
            });
        }
    </script>
@stop