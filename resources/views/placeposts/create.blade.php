@extends('layouts.app')

@section('content')
<script>
    document.getElementsByTagName('body')[0].setAttribute('onload','loadedAction()');
    document.getElementsByTagName('body')[0].setAttribute('onresize','changeList()');
</script>
<div class="container">
    <h1>
        글 쓰기
    </h1>
    <hr/>
    {{--form id 임의로 일단 지정 dropzone 때문--}}
    <form id="createForm" action="{{route('placeposts.store')}}"
          method="POST" enctype="multipart/form-data" class="form__article">
        {!! csrf_field() !!}


        @include('placeposts.partial.form')


        <div class="form-group">
            <button type="submit" class="btn-primary">
                저장하기
            </button>
        </div>
    </form>
</div>
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

    #menu_wrap {
        position: absolute;
        top: 0;
        left: 0;
        /*bottom:initial;*/
        min-height: 23px;
        max-height: 400px;
        width: 250px;
        margin: 10px 0 30px 10px;
        padding: 5px;
        overflow-y: auto;
        background: rgba(255, 255, 255, 0.7);
        z-index: 1;
        font-size: 12px;
        border-radius: 10px;
    }

    .bg_white {
        background: #fff;
    }

    #menu_wrap hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 2px solid #5F5F5F;
        margin: 3px 0;
    }

    #menu_wrap .option {
        text-align: center;
    }

    #menu_wrap .option p {
        margin: 10px 0;
    }

    #menu_wrap .option button {
        margin-left: 5px;
    }

    #placesList {
        margin-top: 25px;
    }

    #placesList li {
        list-style: none;
    }

    #placesList .item {
        position: relative;
        border-bottom: 1px solid #888;
        overflow: hidden;
        cursor: pointer;
        min-height: 65px;
    }

    #placesList .item span {
        display: block;
        margin-top: 4px;
    }

    #placesList .item h5, #placesList .item .info {
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    #placesList .item .info {
        padding: 10px 0 10px 55px;
    }

    #placesList .info .gray {
        color: #8a8a8a;
    }

    #placesList .info .jibun {
        padding-left: 26px;
        background: url(http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/places_jibun.png) no-repeat;
    }

    #placesList .info .tel {
        color: #009900;
    }

    #placesList .item .markerbg {
        float: left;
        position: absolute;
        width: 36px;
        height: 37px;
        margin: 10px 0 0 10px;
        background: url(http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/marker_number_blue.png) no-repeat;
    }

    #placesList .item .marker_1 {
        background-position: 0 -10px;
    }

    #placesList .item .marker_2 {
        background-position: 0 -56px;
    }

    #placesList .item .marker_3 {
        background-position: 0 -102px
    }

    #placesList .item .marker_4 {
        background-position: 0 -148px;
    }

    #placesList .item .marker_5 {
        background-position: 0 -194px;
    }

    #placesList .item .marker_6 {
        background-position: 0 -240px;
    }

    #placesList .item .marker_7 {
        background-position: 0 -286px;
    }

    #placesList .item .marker_8 {
        background-position: 0 -332px;
    }

    #placesList .item .marker_9 {
        background-position: 0 -378px;
    }

    #placesList .item .marker_10 {
        background-position: 0 -423px;
    }

    #placesList .item .marker_11 {
        background-position: 0 -470px;
    }

    #placesList .item .marker_12 {
        background-position: 0 -516px;
    }

    #placesList .item .marker_13 {
        background-position: 0 -562px;
    }

    #placesList .item .marker_14 {
        background-position: 0 -608px;
    }

    #placesList .item .marker_15 {
        background-position: 0 -654px;
    }

    #pagination {
        margin: 10px auto;
        text-align: center;
    }

    #pagination a {
        display: inline-block;
        margin-right: 10px;
    }

    #pagination .on {
        font-weight: bold;
        cursor: default;
        color: #777;
    }

    .list-icon {
        cursor: pointer;
        /*height: 60px;*/
        padding: 10px 0px;
        position: absolute;
        /*top: -15px; left: -15px;*/

        -webkit-user-select: none; /* Chrome all / Safari all */
        -moz-user-select: none; /* Firefox all */
        -ms-user-select: none; /* IE 10+ */
        user-select: none; /* Likely future */
    }

    .list-icon-bar {
        display: block;
        width: 20px;
        height: 3px;
        background-color: #333;
        position: relative;
        transition: background-color .2s ease-out;
    }

    .list-icon-bar::before, .list-icon-bar::after {
        background-color: #333;
        content: "";
        display: block;
        height: 100%;
        width: 100%;
        position: absolute;
        transition: all .2s ease-out;
    }

    .list-icon-bar::before {
        top: -7px;
    }

    .list-icon-bar::after {
        top: 7px;
    }

    .list-toggle:checked ~ .list-icon > .list-icon-bar {
        background: transparent;
    }

    .list-toggle:checked ~ .list-icon > .list-icon-bar::before {
        transform: rotate(45deg);
        top: 0;
    }

    .list-toggle:checked ~ .list-icon > .list-icon-bar::after {
        transform: rotate(-45deg);
        top: 0;
    }

    .list-toggle {
        checked: true;
    }

    /*.list-toggle, .list-icon {*/
    /*  display: none;*/
    /*}*/

    .list-toggle:checked ~ #menu_wrap {
        width: 250px;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.05), 0 1px 0 rgba(0, 0, 0, 0.05);
    }

    .list-toggle:checked ~ #placesList, .list-toggle:checked ~ #pagination {
        display: block;
    }

    #placesList, #pagination {
        display: none;
    }

    #place {
        color: orangered;
    }
</style>
@stop

@section('script')
<script>
var map = null;
var markers = [];
var bindedGetCurrentAddress = null;

function loadedAction() {
    map = makeMap();

    getCurrentGps(map)
    // makeMarker(map, 33.450701, 126.570667);

    var crosshair = makeCrosshair(map);
    var bindedOnCrosshairEvent = onCrosshairEvent.bind(null, map, crosshair);
    daum.maps.event.addListener(map, 'drag', bindedOnCrosshairEvent);
    daum.maps.event.addListener(map, 'idle', bindedOnCrosshairEvent);

    bindedGetCurrentAddress = getCurrentAddress.bind(null, map, markers);
    daum.maps.event.addListener(map, 'idle', bindedGetCurrentAddress);
}

function getCurrentGps(map) {
    navigator.geolocation.getCurrentPosition(function (pos) {
            console.log("시작위도 : " + pos.coords.latitude);
            console.log("시작경도 : " + pos.coords.longitude);
            var moveLatlng = new daum.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
            map.panTo(moveLatlng);
        }, function (error) {
            console.log('Error occurred. Error code: ' + error.code);
            // error.code는 다음을 의미함:
            //   0: 알 수 없는 오류
            //   1: 권한 거부
            //   2: 위치를 사용할 수 없음 (이 오류는 위치 정보 공급자가 응답)
            //   3: 시간 초과
        }
    );
}

function makeMap() {
    var container = document.getElementById('map'); //지도를 담을 영역의 DOM 레퍼런스
    var options = { //지도를 생성할 때 필요한 기본 옵션
        center: new daum.maps.LatLng(33.450701, 126.570667), //지도의 중심좌표.
        level: 3 //지도의 레벨(확대, 축소 정도)
    };

    return new daum.maps.Map(container, options); //지도 생성 및 객체 리턴
}

function addMarker(map, mouseEvent) {
    var latlng = mouseEvent.latLng;
    makeMarker(map, latlng.getLat(), latlng.getLng());
}

function makeMarker(map, lat, lng) {
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(lat, lng),
        clickable: true
    });

    marker.setMap(map)
    var bindedRemoveMarker = removeMarker.bind(null, marker);
    daum.maps.event.addListener(marker, 'click', bindedRemoveMarker);

    return marker;
}

function removeMarker(marker) {
    marker.setMap(null);
}

function makeCrosshair(map) {
    var markerImageSrc = 'https://www.daftlogic.com/images/cross-hairs.gif';
    var markerImageSize = new daum.maps.Size(24, 24);
    var markerImageOption = {
        offset: new daum.maps.Point(12, 12)
    };

    var markerImage = new daum.maps.MarkerImage(markerImageSrc, markerImageSize, markerImageOption);
    var latlng = map.getCenter();

    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(latlng.getLat(), latlng.getLng()),
        clickable: false,
        image: markerImage
    });

    var latlng = map.getCenter();

    marker.setMap(map);

    return marker;
}

function onCrosshairEvent(map, crosshair) {
    crosshair.setPosition(map.getCenter());
}

function getCurrentAddress(map, markers) {
    // 주소-좌표 변환 객체를 생성합니다
    var geocoder = new daum.maps.services.Geocoder();
    var latlng = map.getCenter();

    geocoder.coord2Address(latlng.getLng(), latlng.getLat(), callback);

    function callback(result, status) {
        if (status === daum.maps.services.Status.OK) {
            var detailAddr = !!result[0].road_address ?
                result[0].road_address.address_name :
                result[0].address.address_name;

            console.log(detailAddr);
            searchPlaceAndShowList(map, detailAddr, markers);
        }
    }
}

function searchPlaces() {
    var keyword = document.getElementById('keyword').value;


    if (!keyword.replace(/^\s+|\s+$/g, '')) {
        alert('키워드를 입력해주세요!');
        return false;
    }

    daum.maps.event.removeListener(map, 'idle', bindedGetCurrentAddress);

    bounds = searchPlaceAndShowList(map, keyword, markers);
    map.setBounds(bounds);

    daum.maps.event.addListener(map, 'idle', bindedGetCurrentAddress);
}

function searchPlaceAndShowList(map, query, markers) {
    // 장소 검색 객체를 생성합니다
    var ps = new daum.maps.services.Places();

    // 검색 결과 목록이나 마커를 클릭했을 때 장소명을 표출할 인포윈도우를 생성합니다
    var infowindow = new daum.maps.InfoWindow({
        zIndex: 1,
        disableAutoPan: true
    });

    ps.keywordSearch(query, placesSearchCB);

    function placesSearchCB(data, status, pagination) {
        if (status === daum.maps.services.Status.OK) {

            // 정상적으로 검색이 완료됐으면
            // 검색 목록과 마커를 표출합니다
            displayPlaces(data, markers);

            // 페이지 번호를 표출합니다
            displayPagination(pagination);
        }
    }

    function displayPlaces(places, markers) {
        var listEl = document.getElementById('placesList'),
            menuEl = document.getElementById('menu_wrap'),
            fragment = document.createDocumentFragment(),
            bounds = new daum.maps.LatLngBounds(),
            listStr = '';

        // 검색 결과 목록에 추가된 항목들을 제거합니다
        removeAllChildNods(listEl);

        // 지도에 표시되고 있는 마커를 제거합니다
        removeMarker(markers);

        for (var i = 0; i < places.length; i++) {
            // 마커를 생성하고 지도에 표시합니다
            var placePosition = new daum.maps.LatLng(places[i].y, places[i].x),
                marker = addMarker(placePosition, i, markers),
                itemEl = getListItem(i, places[i]); // 검색 결과 항목 Element를 생성합니다

            // 검색된 장소 위치를 기준으로 지도 범위를 재설정하기위해
            // LatLngBounds 객체에 좌표를 추가합니다
            bounds.extend(placePosition);

            // 마커와 검색결과 항목에 mouseover 했을때
            // 해당 장소에 인포윈도우에 장소명을 표시합니다
            // mouseout 했을 때는 인포윈도우를 닫습니다
            (function (marker, title, placePosition) {
                daum.maps.event.addListener(marker, 'mouseover', function () {
                    displayInfowindow(marker, title);
                });

                daum.maps.event.addListener(marker, 'mouseout', function () {
                    infowindow.close();
                });
                daum.maps.event.addListener(marker, 'click', function () {
                    showSelectedPlace(placePosition, title);
                });

                itemEl.onmouseover = function () {
                    displayInfowindow(marker, title);
                };
                itemEl.onmouseout = function () {
                    infowindow.close();
                };
                itemEl.onclick = function () {
                    showSelectedPlace(placePosition, title);
                };
            })(marker, places[i].place_name, placePosition);

            fragment.appendChild(itemEl);
        }

        // 검색결과 항목들을 검색결과 목록 Elemnet에 추가합니다
        listEl.appendChild(fragment);
        menuEl.scrollTop = 0;

        // 검색된 장소 위치를 기준으로 지도 범위를 재설정합니다
        // map.setBounds(bounds);

        return bounds;
    }

    // 검색결과 항목을 Element로 반환하는 함수입니다
    function getListItem(index, places) {

        var el = document.createElement('li'),
            itemStr = '<span class="markerbg marker_' + (index + 1) + '"></span>' +
                '<div class="info">' +
                '   <h5>' + places.place_name + '</h5>';

        if (places.road_address_name) {
            itemStr += '    <span>' + places.road_address_name + '</span>' +
                '   <span class="jibun gray">' + places.address_name + '</span>';
        } else {
            itemStr += '    <span>' + places.address_name + '</span>';
        }

        itemStr += '  <span class="tel">' + places.phone + '</span>' +
            '</div>';

        el.innerHTML = itemStr;
        el.className = 'item';

        return el;
    }

    // 마커를 생성하고 지도 위에 마커를 표시하는 함수입니다
    function addMarker(position, idx, markers) {
        var imageSrc = 'http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/marker_number_blue.png', // 마커 이미지 url, 스프라이트 이미지를 씁니다
            imageSize = new daum.maps.Size(36, 37),  // 마커 이미지의 크기
            imgOptions = {
                spriteSize: new daum.maps.Size(36, 691), // 스프라이트 이미지의 크기
                spriteOrigin: new daum.maps.Point(0, (idx * 46) + 10), // 스프라이트 이미지 중 사용할 영역의 좌상단 좌표
                offset: new daum.maps.Point(13, 37) // 마커 좌표에 일치시킬 이미지 내에서의 좌표
            },
            markerImage = new daum.maps.MarkerImage(imageSrc, imageSize, imgOptions),
            marker = new daum.maps.Marker({
                position: position, // 마커의 위치
                image: markerImage
            });

        marker.setMap(map); // 지도 위에 마커를 표출합니다
        markers.push(marker);  // 배열에 생성된 마커를 추가합니다

        return marker;
    }

    // 지도 위에 표시되고 있는 마커를 모두 제거합니다
    function removeMarker(markers) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }

    // 검색결과 목록 하단에 페이지번호를 표시는 함수입니다
    function displayPagination(pagination) {
        var paginationEl = document.getElementById('pagination'),
            fragment = document.createDocumentFragment(),
            i;

        // 기존에 추가된 페이지번호를 삭제합니다
        while (paginationEl.hasChildNodes()) {
            paginationEl.removeChild(paginationEl.lastChild);
        }

        for (i = 1; i <= pagination.last; i++) {
            var el = document.createElement('a');
            el.href = "#";
            el.innerHTML = i;

            if (i === pagination.current) {
                el.className = 'on';
            } else {
                el.onclick = (function (i) {
                    return function () {
                        pagination.gotoPage(i);
                    }
                })(i);
            }

            fragment.appendChild(el);
        }
        paginationEl.appendChild(fragment);
    }

    // 검색결과 목록 또는 마커를 클릭했을 때 호출되는 함수입니다
    // 인포윈도우에 장소명을 표시합니다
    function displayInfowindow(marker, title) {
        var content = '<div style="padding:5px;z-index:1;">' + title + '</div>';

        infowindow.setContent(content);
        infowindow.open(map, marker);
    }

    // 검색결과 목록의 자식 Element를 제거하는 함수입니다
    function removeAllChildNods(el) {
        while (el.hasChildNodes()) {
            el.removeChild(el.lastChild);
        }
    }
}

function searchPlace(map, query) {
    // 장소 검색 객체를 생성합니다
    var ps = new daum.maps.services.Places();
    // 키워드로 장소를 검색합니다
    ps.keywordSearch(query, placesSearchCB);

    var infowindow = new daum.maps.InfoWindow({zIndex: 1});

    // 키워드 검색 완료 시 호출되는 콜백함수 입니다
    function placesSearchCB(data, status, pagination) {
        if (status === daum.maps.services.Status.OK) {

            // 검색된 장소 위치를 기준으로 지도 범위를 재설정하기위해
            // LatLngBounds 객체에 좌표를 추가합니다
            var bounds = new daum.maps.LatLngBounds();

            for (var i = 0; i < data.length; i++) {
                displayMarker(data[i]);
                bounds.extend(new daum.maps.LatLng(data[i].y, data[i].x));
            }

            // 검색된 장소 위치를 기준으로 지도 범위를 재설정합니다
            // map.setBounds(bounds);
        }
    }

    // 지도에 마커를 표시하는 함수입니다
    function displayMarker(place) {

        // 마커를 생성하고 지도에 표시합니다
        var marker = new daum.maps.Marker({
            map: map,
            position: new daum.maps.LatLng(place.y, place.x)
        });

        // 마커에 클릭이벤트를 등록합니다
        daum.maps.event.addListener(marker, 'click', function () {
            // 마커를 클릭하면 장소명이 인포윈도우에 표출됩니다
            infowindow.setContent('<div style="padding:5px;font-size:12px;">' + place.place_name + '</div>');
            infowindow.open(map, marker);
        });
    }
}
function showSelectedPlace(latLng, name) {
    var placeId = document.getElementById('place');
    var latInputTag = document.getElementById('place-lat');
    var lngInputTag = document.getElementById('place-lng');

    placeId.innerHTML = name;
    latInputTag.value = latLng.getLat();
    lngInputTag.value = latLng.getLng();
}
</script>
<script>
    var isExceeded768Px = false;

    function changeList() {
        var w = window.innerWidth;
        var checkbox = document.getElementById('list-toggle');
        // 작은데서 커졌으면
        if (w > 768 && !isExceeded768Px) {
            isExceeded768Px = true;
            checkbox.checked = true;
        }
        // 큰데서 작아졌으면
        else if (w <= 768 && isExceeded768Px) {
            isExceeded768Px = false;
            checkbox.checked = false;
        }
    }
    changeList();
</script>
@stop
