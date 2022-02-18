<?php
session_start();

$id = $_GET["id"];
require_once('funcs.php');
loginCheck();
$pdo = db_conn();

// id 一番の人だったら、その人が登録したデータ
// だけが欲しいので、DBに接続して検索をして表示するため
/**
 * １．PHP
 * [ここでやりたいこと]
 * まず、クエリパラメータの確認 = GETで取得している内容を確認する
 * イメージは、select.phpで取得しているデータを一つだけ取得できるようにする。
 * →select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * ※SQLとデータ取得の箇所を修正します。
 */


// SQLを準備する記述を書きます
$stmt = $pdo->prepare('SELECT * FROM gs_shop_table WHERE id=:id;');

// sqlが安全かチエックする
$stmt->bindValue(':id',$id,PDO::PARAM_INT);

// sqlを実行
$status = $stmt->execute();  //成功？失敗

## 結果表示

$view = '';

if ($status === false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();   //fetch 1行だけ取ってくるおまじない
}

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/handlebars/4.7.7/handlebars.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="css/locatorplus.css" rel="stylesheet">
    <script src="js/locatorplus.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script>
      const CONFIGURATION = {
        "locations": [
          {"title":"サツドラ 北８条店","address1":"日本、〒060-0908 北海道札幌市東区北８条東４丁目１−２０","coords":{"lat":43.07219864186095,"lng":141.3603368932541},"placeId":"ChIJr2s2UG0pC18REDM-izDhD84"}
        ],
        "mapOptions": {"center":{"lat":38.0,"lng":-100.0},"fullscreenControl":true,"mapTypeControl":false,"streetViewControl":false,"zoom":4,"zoomControl":true,"maxZoom":17},
        "mapsApiKey": "AIzaSyB_1O2SufjuLw4-T9l44hRxH6Y9i33jd2U"
      };

      function initMap() {
        new LocatorPlus(CONFIGURATION);
      }
    </script>
    <script id="locator-result-items-tmpl" type="text/x-handlebars-template">
      {{#each locations}}
        <li class="location-result" data-location-index="{{index}}">
          <button class="select-location">
            <h2 id= "name" class="name">{{title}}</h2>
          </button>
          <div id="address" class="address">{{address1}}<br>{{address2}}</div>
          {{#if travelDistanceText}}
            <div class="distance">{{travelDistanceText}}</div>
          {{/if}}
        </li>
      {{/each}}
    </script>
    <!-- 現在位置取得 -->
    <script>
      function getMyPlace() {
        var output = document.getElementById("result");
        if (!navigator.geolocation){//Geolocation apiがサポートされていない場合
          output.innerHTML = "<p>Geolocationはあなたのブラウザーでサポートされておりません</p>";
          return;
        }
        function success(position) {
          var latitude  = position.coords.latitude;//緯度
          var longitude = position.coords.longitude;//経度
          output.innerHTML = '<p>緯度 ' + latitude + '° <br>経度 ' + longitude + '°</p>';
          // 位置情報
          var latlng = new google.maps.LatLng( latitude , longitude ) ;
          // Google Mapsに書き出し
          var map = new google.maps.Map( document.getElementById( 'map' ) , {
              zoom: 15 ,// ズーム値
              center: latlng ,// 中心座標
          } ) ;
          // マーカーの新規出力
          new google.maps.Marker( {
              map: map ,
              position: latlng ,
          } ) ;
        };
        function error() {
          //エラーの場合
          output.innerHTML = "座標位置を取得できません";
        };
        navigator.geolocation.getCurrentPosition(success, error);//成功と失敗を判断
      }
    </script>
    <title>飯ログデータ詳細</title>
  </head>
  <body>
  <top>
    <img id="top-img" src="img/linkedin_banner_image_1.png"></img>
  </top>
  <div id="map-container">
    <div id="locations-panel">
      <div id="locations-panel-list">
        <header>
            <h1 class="search-title">
              <img src="https://fonts.gstatic.com/s/i/googlematerialicons/place/v15/24px.svg"/>
              お店を探す
            </h1>
    
            <div class="search-input">
                 <!-- ここからページ遷移 -->
              <form action='update.php' method="post">
                <input name ='address' id="location-search-input" placeholder="店名、ジャンルなど" value="<?= $result['address'] ?>">
                
                <div id="search-overlay-search" class="search-input-overlay search">
                  <button type="button" id="location-search-button">
                    <img class="icon" src="https://fonts.gstatic.com/s/i/googlematerialicons/search/v11/24px.svg" alt="Search"/>
                  </button>
                </div>
              
                <div id="nowplace">
                  <button id="nowbtn" type="button" onclick="getMyPlace()">現在位置を取得</button>
                </div>

               
                
                  <label for="inputEmail4" class="form-label">店名</label>
                  <input name='name' type="text" class="form-control" id="inputEmail4" value="<?= $result['name'] ?>">
                  
                  <p>評価</p>
                  <select name='hyouka' class="form-select" placeholder="選択" aria-label="Default select example" value="<?= $result['hyouka'] ?>">
                
                    <option selected></option>
                    <option value="⭐️">⭐️</option>
                    <option value="⭐️⭐️">⭐️⭐️</option>
                    <option value="⭐️⭐️⭐️">⭐️⭐️⭐️</option>
                  </select>
                  <!-- <div>
                    <label for="inputPassword4" class="form-label">評価</label>
                    <input name='hyouka' type="text" class="form-control" id="inputPassword4">
                  </div> -->
                  <div>
                    <label for="inputAddress" class="form-label">口コミ</label>
                    <input name='kutikomi' type="text" class="form-control" id="inputAddress" placeholder="お店のこと教えて" value="<?= $result['kutikomi'] ?>">
                  </div>
                  <input type='hidden' name="id" value="<?=$result["id"]?>">
                  <div>
                    <button type="button" onclick="submit();" class="btn btn-primary">投稿</button>
                  </div>
                </form>
                <a href="select.php">投稿履歴</a>
            </div>
            
        </header>
            <div class="section-name" id="location-results-section-name">
              All locations
            </div>
            <div class="results">
              <ul id="location-results-list"></ul>
            </div>
      </div>
    </div>
            <div id="map"></div>
            <div id="result"></div>
  </div>
          
    
    
   
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_1O2SufjuLw4-T9l44hRxH6Y9i33jd2U&callback=initMap&libraries=places,geometry&solution_channel=GMP_QB_locatorplus_v4_cABD" async defer></script>
  </body>
</html>