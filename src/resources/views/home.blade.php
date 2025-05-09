@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="section_title">どこで酔い旅する？</h2>

        {{-- 検索フォーム --}}
        <div class="container mt-4 text-center">
            <div class="mb-4">
                <input type="text" id="searchInput" class="form-control d-inline w-50" placeholder="検索キーワードを入力" style="height: 50px;">
                <button class="btn btn-primary" onclick="performCombinedSearch()">検索</button>
                    {{-- ↑ buttonをクリックすると、performCombinedSearch() 関数が実行され、検索が開始される。↑ --}}
            </div>
            <div id="map" class="border" style="width: 75%; height: 400px; margin: 0 auto;"></div>
        </div>

        {{-- Google Map --}}
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQBvWc3bxd1kmtpr0olsWNuM-2-WGIYz0&libraries=places&callback=initMap" async defer></script>

        <script>
            let map;
            let placesService;
            let markers = [];
        
            function initMap() {        
                // マップの初期化（東京駅）
                map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 35.682839, lng: 139.759455 },
                    zoom: 14,
                });
        
                // Googleの場所検索APIを利用するためのオブジェクトを作成
                placesService = new google.maps.places.PlacesService(map);
        
                console.log("Google Maps 初期化完了！");
            }
        
            function performCombinedSearch() {
                const query = document.getElementById("searchInput").value.trim();
        
                if (!query) {
                    alert("検索キーワードを入力してください");
                    return;
                }
        
                clearMarkers();
        
                // 1️. テキスト検索（新版）で場所を検索
                const request = {
                    query: query,
                    fields: ["name", "geometry", "place_id"],
                };
        
                placesService.findPlaceFromQuery(request, function (results, status) { // findPlaceFromQuery() → テキスト検索で入力キーワードに関連する場所を検索
                    if (status === google.maps.places.PlacesServiceStatus.OK && results.length > 0) {
                        const firstResult = results[0];
        
                        // マップを検索結果の位置に移動
                        map.setCenter(firstResult.geometry.location);
                        map.setZoom(15);
        
                        // マーカーを追加（Googleマップの詳細ページリンク付き）
                        addMarker(firstResult.geometry.location, firstResult.name, firstResult.place_id);
        
                        // 2️. Nearby Search を実行（検索結果の場所を中心に）
                        performNearbySearch(firstResult.geometry.location, query);
                    } else {
                        alert("検索結果が見つかりませんでした");
                    }
                });
            }
        
            function performNearbySearch(location, keyword) { 
                const request = {
                    location: location,
                    radius: 1000, // 半径 1km
                    keyword: keyword,
                };
        
                placesService.nearbySearch(request, function (results, status) { // nearbySearch() → 指定した位置の周辺でキーワードに一致する場所を検索
                    if (status === google.maps.places.PlacesServiceStatus.OK && results.length > 0) {
                        results.forEach((place) => {
                            addMarker(place.geometry.location, place.name, place.place_id);
                        });
                    } else {
                        alert("近くの検索結果が見つかりませんでした");
                    }
                });
            }
        
            function addMarker(location, title, placeId) {
                const marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: title,
                });
        
                // マーカークリック時に Googleマップのお店詳細ページへ遷移
                marker.addListener("click", () => {
                    if (placeId) {
                        window.open(`https://www.google.com/maps/place/?q=place_id:${placeId}`, "_blank");
                    } else {
                        alert("詳細情報が見つかりませんでした");
                    }
                });
        
                markers.push(marker);
            }
        
            function clearMarkers() {
                markers.forEach(marker => marker.setMap(null));
                markers = [];
            }
        </script>
        {{-- Google Map ここまで --}}

        <div class="d-flex">
            <div class="btn_wrapper">
                <a href="{{ route('post.show') }}" class="btn_link">
                    <img src="{{ asset('storage/images/26317842.png') }}">
                    <p class="btn_custom">みんなの酔い旅</p>
                </a>
            </div>
            <div class="btn_wrapper">
                <a href="{{ route('post.create') }}" class="btn_link">
                    <img src="{{ asset('storage/images/26317845.png') }}">
                    <p class="btn_custom">新たな酔い旅</p>
                </a>
            </div>
        </div>
    </div>
@endsection
