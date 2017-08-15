@extends('layouts.app')

@section('content')
    @php $viewName = 'placeposts.index'; @endphp
    <div class="row">
        <div id="map-wrap" class="col-md-9">
            <div id="map"></div>
            <div id="menu-wrap">
                <form>
                    <input class="list-toggle" id="list-toggle" type="checkbox" hidden>
                    <label for="list-toggle" id="listIcon">
                        <span class="listIcon-bar"></span>
                    </label>
                </form>

                <div id="searchPlaces-warp">
                    <input type="text" id="searchKeyword" size="25" placeholder="장소, 주소...">
                    <button type="submit" onclick="searchPlaces()">검색</button>
                </div>
                <ul id="placeList"></ul>
                <div id"paginationa"></div>
            </div>
        </div>
<!-- =====TODO 직접 추가 바람start-->
        @section('style')
<style>
#map-wrap {
  height: 60vh;        
  font-family: 'Malgun Gothic',dotum, '돋움',sans-serif;
  font-size: 12px;
}

#map-wrap a, #map-wrap a:hover, #map-wrap a:active{
  color: #000;
  text-decoration: none;
}

#menu-wrap {
  position: absolute;
  top: 5px;left: 20px;
  min-height: 35px;
  max-height: 80%;
  width: 250px;
  padding 5px;
  overflow-y: auto;
  background:rgba(255, 255, 255, 0.6);
  z-index: 1;
  border-radius: 10px;
}

#map {
  height: 100%;
  /*position:relative;*/
  /*overflow:hidden;*/
}

.listIcon-bar {
  display: block;
  width: 20px;
  height: 3px;
  background-color: #333;
  position: relative;
  transition: background-color .2s ease-out;
}

.listIcon-bar::before, .listIcon-bar::after {
  display: block;
  background-color: #333;
  height: 100%;
  width: 100%;
  position: absolute;
  content: "";
}

.listIcon-bar::before {
  top: -7px;
}
.listIcon-bar::after{
  top: 7px;
}

#listIcon {
  float: left;
  cursor: pointer;
  margin: 5px;
  padding: 10px 0px;

  -webkit-user-select: none;  /* Chrome all / Safari all */
  -moz-user-select: none;     /* Firefox all */
  -ms-user-select: none;      /* IE 10+ */
  user-select: none;          /* Likely future */
}

#searchPlaces-warp {
  margin: 5px;
  float:right;
  /*position: absolute;
  top: 3px;
  left: 30px;*/
}

@media only screen and (min-width : 720px) { /*col-md 대응*/
  #map-wrap {
    height: 80vh;        
  }
}
</style>
        @stop

        @section('script')
<script>
var map = null;
var markers = [];
function loadedAction() {
    map = makeMap();

    setCurrentGps();

    makeCrosshair();
}

function makeMap() {
    var container = document.getElementById('map'); //지도를 담을 영역의 DOM 레퍼런스
    var options = { //지도를 생성할 때 필요한 기본 옵션
        center: new daum.maps.LatLng(33.450701, 126.570667), //지도의 중심좌표.
        level: 3 //지도의 레벨(확대, 축소 정도)
    };
    return new daum.maps.Map(container, options); //지도 생성 및 객체 리턴        
}

function setCurrentGps() {
    navigator.geolocation.getCurrentPosition(function(pos){
            console.log("시작위도 : " + pos.coords.latitude);
            console.log("시작경도 : " + pos.coords.longitude);
            var moveLatlng = new daum.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
            map.panTo(moveLatlng);
        }, function(error) {
            console.log('Error occurred. Error code: ' + error.code);
            // error.code는 다음을 의미함:
            //   0: 알 수 없는 오류
            //   1: 권한 거부
            //   2: 위치를 사용할 수 없음 (이 오류는 위치 정보 공급자가 응답)
            //   3: 시간 초과
        }
    );
}

function makeCrosshair() {
    var markerImgSrc = 'https://www.daftlogic.com/images/cross-hairs.gif'; 
    var markerImgSize = new daum.maps.Size(30,30);
    var markerImgeOption = {
        offset: new daum.maps.Point(15,15)
    }

    var markerImg = new daum.maps.MarkerImage(markerImgSrc, markerImgSize, markerImgeOption);
    var latlng = map.getCenter();

    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(latlng.getLat(), latlng.getLng()),
        clickable: false,
        image: markerImg
    });

    marker.setMap(map);

    daum.maps.event.addListener(map, 'drag', onCrosshairEvent);
    daum.maps.event.addListener(map, 'idle', onCrosshairEvent);

    function onCrosshairEvent() {
        marker.setPosition(map.getCenter());
    }
}

loadedAction();
</script>
	@stop
<!-- =====TODO 직접 추가 바람end-->

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
