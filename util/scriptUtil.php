<?php
require_once '../util/defineUtil.php';
// 時刻を東京に合わせる
date_default_timezone_set('Asia/Tokyo');


//使用した場所にトップページへのリンクを挿入する
//@return トップページへのリンクのaタグ

function return_top(){
     return "<a href='".top."'>トップへ戻る</a>";
}
// トップページへ飛ぶ
function jump_to_top(){
  header('Location:http://localhost/ECsite/app/top.php');
}


//フォームの再入力時に、すでにセッションに対応した値があるときはその値を返却する
//@param type $name formのname属性
//@return type セッションに入力されていた値

function form_value($name){
    if(isset($_POST['mode']) && $_POST['mode']=='REINPUT'){
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
    }
}


//ポストからセッションに存在チェックしてから値を渡す。
//二回目以降のアクセス用に、ポストから値の上書きがされない該当セッションは初期化する
//@param type $name
//@return type

function bind_p2s($name){
    if(!empty($_POST[$name])){
        $_SESSION[$name] = $_POST[$name];
        return $_POST[$name];
    }else{
        $_SESSION[$name] = null;
        return null;
    }
}

function bind_2($name){
      if(!empty($_GET[$name])){
          $_SESSION[$name] = $_GET[$name];
          return $_GET[$name];
      }else{
          $_SESSION[$name] = null;
          return null;
      }
  }

//YahooAPIのアイテムコード（商品コード）からその商品の情報を取り出す
function search_item($itemcode){
  $appID = APPID;
  $url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup?appid=$appID&itemcode=$itemcode&responsegroup=large";
 $xml = simplexml_load_file($url);
 $hits = $xml->Result->Hit;
return $hits;
}
// 購入方法
//  種別番号から実際の種別名を返却する
//  @param type $type 種別と対応した数字
//  @return string 種別名
function ex_typenum($type){
    switch ($type){
        case 1;
            return "クレジットカード";
        case 2;
            return "銀行振り込み";
        case 3;
            return "口座振替";
    }
}

//YahooAPIのID
const APPID = "dj0zaiZpPXI4ZXA3cGlZWHlQOSZzPWNvbnN1bWVyc2VjcmV0Jng9N2M-";
//商品検索に用いるカテゴリー
const CATEGORYES = array(
                    "1" => "すべてのカテゴリから",
                    "13457"=> "ファッション",
                    "2498"=> "食品",
                    "2500"=> "ダイエット、健康",
                    "2501"=> "コスメ、香水",
                    "2502"=> "パソコン、周辺機器",
                    "2504"=> "AV機器、カメラ",
                    "2505"=> "家電",
                    "2506"=> "家具、インテリア",
                    "2507"=> "花、ガーデニング",
                    "2508"=> "キッチン、生活雑貨、日用品",
                    "2503"=> "DIY、工具、文具",
                    "2509"=> "ペット用品、生き物",
                    "2510"=> "楽器、趣味、学習",
                    "2511"=> "ゲーム、おもちゃ",
                    "2497"=> "ベビー、キッズ、マタニティ",
                    "2512"=> "スポーツ",
                    "2513"=> "レジャー、アウトドア",
                    "2514"=> "自転車、車、バイク用品",
                    "2516"=> "CD、音楽ソフト",
                    "2517"=> "DVD、映像ソフト",
                    "10002"=> "本、雑誌、コミック"
                    );
//商品検索に用いるソート
const SORT_ORDER = array(
                                       "-score" => "おすすめ順",
                                       "+price" => "商品価格が安い順",
                                       "-price" => "商品価格が高い順",
                                       "+name" => "ストア名昇順",
                                       "-name" => "ストア名降順",
                                       "-sold" => "売れ筋順"
                                       );


function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}
