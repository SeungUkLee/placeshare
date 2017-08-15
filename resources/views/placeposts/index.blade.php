@extends('layouts.app')

@section('content')
    @php $viewName = 'placeposts.index'; @endphp
    <div class="row">
        <div id="map" class="col-md-9">
        </div>
<!-- =====TODO 직접 추가 바람start-->
        @section('style')
        <style>
#map {
  height:60vh;        
}
@media only screen and (min-width : 720px) { /*col-md 대응*/
  #map {
    height:80vh;        
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
