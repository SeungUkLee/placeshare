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
                    <input type="text" id="searchKeyword" size="25" placeholder="저장할 장소, 주소...">
                    <button type="submit" onclick="searchPlaces()">검색</button>
                </div>
                <ul id="placesList"></ul>
                <div id="pagination"></div>
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
  width: 260px;
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
    daum.maps.event.addListener(map, 'idle', showCurrentAddress);
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

function showCurrentAddress() {
    var geocoder = new daum.maps.services.Geocoder();
    var latlng = map.getCenter(); 
    
    geocoder.coord2Address(latlng.getLng(), latlng.getLat(), callback);
    
    function callback(result, status) {
        if (status === daum.maps.services.Status.OK) {
            var detailAddr = !!result[0].road_address ?
                result[0].road_address.address_name : 
                result[0].address.address_name;
                
            console.log(detailAddr);
            searchPlaceAndShowList(detailAddr);
        }
    }
}

function searchPlaceAndShowList(query) {
    var ps = new daum.maps.services.Places();
    var infowindow = new daum.maps.InfoWindow({zIndex:1, disableAutoPan:true});

    ps.keywordSearch(query, placesSearchCB);

    function placesSearchCB(data, status, pagination) {
        if (status === daum.maps.services.Status.OK) {
            displayPlaces(data, markers);
            displayPagination(pagination);
        }
    }

    function displayPlaces(places, markers) {
        var listEl = document.getElementById('placesList'),
            menuEl = document.getElementById('menu-wrap'),
            fragment = document.createDocumentFragment(),
            bounds = new daum.maps.LatLngBounds(),
            listStr = '';    

        removeAllChildNodes(listEl);

        removeMarker(markers);

        for ( var i=0; i<places.length; i++ ) {
            var placePosition = new daum.maps.LatLng(places[i].y, places[i].x),
                marker = addMarker(placePosition, i, markers), 
                itemEl = getListItem(i, places[i]); 
    
            bounds.extend(placePosition);
    
            (function(marker, title) {
                daum.maps.event.addListener(marker, 'mouseover', function() {
                    displayInfowindow(marker, title);
                });
    
                daum.maps.event.addListener(marker, 'mouseout', function() {
                    infowindow.close();
                });
    
                itemEl.onmouseover =  function () {
                    displayInfowindow(marker, title);
                };
    
                itemEl.onmouseout =  function () {
                    infowindow.close();
                };
            })(marker, places[i].place_name);
    
            fragment.appendChild(itemEl);
        }

        listEl.appendChild(fragment);
        menuEl.scrollTop = 0;
    
        return bounds;
    }

    function getListItem(index, places) {
        var el = document.createElement('li'),
            itemStr = '<span class="markerbg marker_' + (index+1) + '"></span>' +
                    '<div class="info">' +
                    '   <h5>' + places.place_name + '</h5>';
    
        if (places.road_address_name) {
            itemStr += '    <span>' + places.road_address_name + '</span>' +
                        '   <span class="jibun gray">' +  places.address_name  + '</span>';
        } else {
            itemStr += '    <span>' +  places.address_name  + '</span>'; 
        }
                     
        itemStr += '  <span class="tel">' + places.phone  + '</span></div>';           
    
        el.innerHTML = itemStr;
        el.className = 'item';
    
        return el;
    }

    function addMarker(position, idx, markers) {
        var imageSrc = 'http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/marker_number_blue.png',
            imageSize = new daum.maps.Size(36, 37),
            imgOptions =  {
                spriteSize : new daum.maps.Size(36, 691),
                spriteOrigin : new daum.maps.Point(0, (idx*46)+10),
                offset: new daum.maps.Point(13, 37)
            },
            markerImage = new daum.maps.MarkerImage(imageSrc, imageSize, imgOptions),
                marker = new daum.maps.Marker({
                position: position,
                image: markerImage 
            });
    
        marker.setMap(map);
        markers.push(marker);
    
        return marker;
    }
    
    function removeMarker(markers) {
        for ( var i = 0; i < markers.length; i++ ) {
            markers[i].setMap(null);
        }   
        markers = [];
    }
    
    function displayPagination(pagination) {
        var paginationEl = document.getElementById('pagination'),
            fragment = document.createDocumentFragment(),
            i; 
    
        while (paginationEl.hasChildNodes()) {
            paginationEl.removeChild (paginationEl.lastChild);
        }
    
        for (i=1; i<=pagination.last; i++) {
            var el = document.createElement('a');
            el.href = "#";
            el.innerHTML = i;
    
            if (i===pagination.current) {
                el.className = 'on';
            } else {
                el.onclick = (function(i) {
                    return function() {
                        pagination.gotoPage(i);
                    }
                })(i);
            }
    
            fragment.appendChild(el);
        }
        paginationEl.appendChild(fragment);
    }
    
    function displayInfowindow(marker, title) {
        var content = '<div style="padding:5px;z-index:1;">' + title + '</div>';
    
        infowindow.setContent(content);
        infowindow.open(map, marker);
    }
    
    function removeAllChildNodes(el) {   
        while (el.hasChildNodes()) {
            el.removeChild (el.lastChild);
        }
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
