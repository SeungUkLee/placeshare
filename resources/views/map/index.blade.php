<div id="map">

</div>

<div id="button-wrap">
<a id="button-add" class="btn icon-btn btn-success" href="{{route('placeposts.create')}}">
    <span class="glyphicon btn-glyphicon glyphicon-plus img-circle text-success"></span>
    Add
</a>
</div>
{{--<div id="menu-wrap">--}}
    {{--<form>--}}
        {{--<input class="list-toggle" id="list-toggle" type="checkbox" hidden>--}}
        {{--<label for="list-toggle" id="listIcon">--}}
            {{--<span class="listIcon-bar"></span>--}}
        {{--</label>--}}
    {{--</form>--}}

    {{--<div id="searchPlaces-warp">--}}
        {{--<input type="text" id="searchKeyword" size="25" placeholder="저장할 장소, 주소...">--}}
        {{--<button type="submit" onclick="searchPlaces()">검색</button>--}}
    {{--</div>--}}
    {{--<ul id="placeList"></ul>--}}
    {{--<div id="pagination"></div>--}}
{{--</div>--}}


@section('script')
    @parent
    <script>
        var map = new daum.maps.Map(document.getElementById('map'), { // 지도를 표시할 div
            center : new daum.maps.LatLng(36.2683, 127.6358), // 지도의 중심좌표
            level : 13 // 지도의 확대 레벨
        });

        // 마커 클러스터러를 생성합니다
        var clusterer = new daum.maps.MarkerClusterer({
            map: map, // 마커들을 클러스터로 관리하고 표시할 지도 객체
            averageCenter: true, // 클러스터에 포함된 마커들의 평균 위치를 클러스터 마커 위치로 설정
            minLevel: 10 // 클러스터 할 최소 지도 레벨
        });

        // 데이터를 가져오기 위해 jQuery를 사용합니다
        // 데이터를 가져와 마커를 생성하고 클러스터러 객체에 넘겨줍니다
        $.get("getUserPlace", function(data) {

            // 데이터에서 좌표 값을 가지고 마커를 표시합니다
            // 마커 클러스터러로 관리할 마커 객체는 생성할 때 지도 객체를 설정하지 않습니다
            var markers = $(data.positions).map(function(i, position) {
                console.log('i:',i);
                var title = position.title;
                var maks = new daum.maps.Marker({
                    map:map,
                    position: new daum.maps.LatLng(position.lat, position.lng)
                });
                console.log('title : ',position.title );
                var infowindow = new daum.maps.InfoWindow({
                    {{--content: '@include('map.windowinfo', ['title'=> ''])',--}}
                    content:position.title,
                    removable : true
                });

                daum.maps.event.addListener(maks, 'click', makeOverListener(map, maks, infowindow));
//                daum.maps.event.addListener(maks, 'click', function() {
//                    infowindow.open(map, markers);
//                });
//                daum.maps.event.addListener(maks, 'mouseout', makeOutListener(infowindow));

                return maks;

//                return new daum.maps.Marker({
//                    position : new daum.maps.LatLng(position.lat, position.lng),
//                    clickable: true
//                });
            });
            console.log('markers : ',markers);
            // 클러스터러에 마커들을 추가합니다
            clusterer.addMarkers(markers);

//            // 마커에 클릭이벤트를 등록합니다
//            daum.maps.event.addListener(markers, 'click', function() {
//                console.log('click markers:',markers);
//                // 마커 위에 인포윈도우를 표시합니다
//                infowindow.open(map, markers);
//            });
        });

        // 인포윈도우를 표시하는 클로저를 만드는 함수
        function makeOverListener(map, marker, infowindow) {
            infowindow.close();
            return function() {
                infowindow.open(map, marker);
            };
        }

        // 인포윈도우를 닫는 클로저를 만드는 함수
//        function makeOutListener(infowindow) {
//            return function() {
//                infowindow.close();
//            };
//        }

    </script>
@stop

