@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="section_title">
            新たな酔い旅
        </h2>
        <div class="create_form w-75">
            <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- google APIで店名を検索 -->
                <input id="search" type="text" placeholder="お店の名前を入力" class="d-block mx-auto mb-4" style="width: 100%; height: 50px;">

                <!-- 情報を隠しフィールドで保存 -->
                {{-- GoogleのAPIで取得した情報を、見えない状態でフォームにセットするために hidden input を使用。 --}}
                <input type="hidden" id="bar_id" name="bar_id">
                <input type="hidden" id="name" name="name">
                <input type="hidden" id="address" name="address">
                <input type="hidden" id="google_place_id" name="google_place_id">
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
            
            <!-- 投稿フォーム -->
                <div class="form-group mb-4">
                    <textarea class="form-control" name="review" rows="10" placeholder="ここに投稿内容を入力"></textarea>
                </div>
                @if($errors->has('review'))
                    <div class="alert alert-danger">投稿内容を入力してください</div>
                @endif

                <!-- 画像登録 -->
                <input type="file" name="image" class="form-control mb-4" accept="image/*">

                <div class="m-2 text-center">
                    <button type="submit" class="btn btn-primary">投稿</button>
                </div>
            </form>

            {{-- バリデーションエラーメッセージ --}}
            <div>  
                @if ($errors->any())  
                    <ul>  
                        @foreach ($errors->all() as $error)  
                            <li>{{ $error }}</li>  
                        @endforeach  
                    </ul>  
                @endif  
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQBvWc3bxd1kmtpr0olsWNuM-2-WGIYz0&libraries=places"></script>

    <script>
        let autocomplete;
        let isAutocompleteSelected = false; // Google APIで選択されたかを判定

        function initAutocomplete() {
            const input = document.getElementById("search");
            autocomplete = new google.maps.places.Autocomplete(input, {
                componentRestrictions: { country: "JP" } // 日本国内の結果のみ
            });
            
            autocomplete.addListener("place_changed", async () => {
                isAutocompleteSelected = true; // Google APIで選択されている
                const place = autocomplete.getPlace();
                if (!place.geometry) return;

                // 取得した情報を hidden input に保存
                document.getElementById("name").value = place.name || "";
                document.getElementById("address").value = place.formatted_address || "";
                document.getElementById("google_place_id").value = place.place_id || "";
                document.getElementById("latitude").value = place.geometry.location.lat();
                document.getElementById("longitude").value = place.geometry.location.lng();

                saveBar();
            });

            // ユーザーが手入力を始めたらGoogle選択を無効化（Googleから取得したデータが正しいかチェックするための仕組み）
            input.addEventListener("input", () => {
                isAutocompleteSelected = false;
            });

            // フォーカスが外れたときにGoogle選択されていない場合、入力情報をクリア
            input.addEventListener("blur", () => {
                if (!isAutocompleteSelected) {
                    resetBarInfo();
                }
            });
        }

        // 入力情報を全てクリアにする関数
        function resetBarInfo() {
            document.getElementById("bar_id").value = "";
            document.getElementById("name").value = "";
            document.getElementById("address").value = "";
            document.getElementById("google_place_id").value = "";
            document.getElementById("latitude").value = "";
            document.getElementById("longitude").value = "";
        }

        async function saveBar() {
            const name = document.getElementById("name").value;
            const address = document.getElementById("address").value;
            const google_place_id = document.getElementById("google_place_id").value;
            const latitude = document.getElementById("latitude").value;
            const longitude = document.getElementById("longitude").value;

            const response = await fetch("/bar/store", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ name, address, google_place_id, latitude, longitude })
            });

            const data = await response.json();
            if (data.bar_id) {
                document.getElementById("bar_id").value = data.bar_id;
            }
        }

        document.addEventListener("DOMContentLoaded", initAutocomplete);
    </script>
@endsection