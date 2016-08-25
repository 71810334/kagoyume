<?php
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';
session_start();
//ログアウトボタンを押されたときにセッション切断
if (isset($_POST['logout'])&&$_POST['logout'] == 'LOGOUT'){
   session_unset();
}
//ログイン状態かどうか判断する
      if (isset($_SESSION['ok']) == 'ok' ){?>
        <div align="right">
           <form action="<?php echo my_data; ?>" method="GET">
          <?php echo 'ようこそ';?><a href="./mydata.php?id=<?php echo $_SESSION['login_userID']?>"><?php echo $_SESSION['login_name'];?></a><?php echo  'さん！';?>
           <input type="hidden" name="mode" value="mydata">
           </form>

           <form action="<?php echo cart ?>">
           <input type="submit" name="cart" value="買い物かごへ">
             </form>

          <form action="<?php echo top ?>" method="POST">
          <input type="submit" name="logout" value="ログアウト">
          <input type="hidden" name="logout" value="LOGOUT">
            </form>
            </div>

<?php     }else{
          //ログイン状態ではない場合はこちらへ分岐  ?>
            <div align="right">
    <?php  echo 'ようこそゲストさん！' ; ?>
            <form action="<?php echo login ?>" method="POST">
            <input type="submit" name="login" value="ログイン"></div>
            <input type="hidden" name="mode" value="login">
            </form>
            </div>
          <?php
          }
$hits = array();
$appID = APPID;
$query = !empty($_GET["query"]) ? $_GET["query"] : "";
$sort =  !empty($_GET["sort"]) && array_key_exists($_GET["sort"], SORT_ORDER) ? $_GET["sort"] : "-score";
$category_id = isset($_GET["category_id"]) &&ctype_digit($_GET["category_id"]) && array_key_exists($_GET["category_id"], CATEGORIES) ? $_GET["category_id"] : 1;
//YahooAPIで商品を検索して、検索内容を$hitsへ格納
if ($query != "") {
$query4url = rawurlencode($query);
$sort4url = rawurlencode($sort);
$url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appID&product_id=$product_id&query=$query4url&category_id=$category_id&sort=$sort4url";
$xml = simplexml_load_file($url);
if ($xml["totalResultsReturned"] != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
$hits = $xml->Result->Hit;
    }
}
?>

<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>商品を検索する</title>
        <link rel="stylesheet" type="text/css" href="../css/prototype.css"/>
    </head>
    <body>
        <h1><a href="./top.php">商品を検索する</a></h1>
        <form action="./search.php" class="Search" method="GET">

        表示順序:
        <select name="sort">
        <?php foreach (SORT_ORDER as $key => $value) { ?>
        <option value="<?php echo h($key); ?>" <?php if($sort == $key) echo "selected=\"selected\""; ?>><?php echo h($value);?></option>
        <?php } ?>
        </select>

        キーワード検索：
        <select name="category_id">
        <?php foreach (CATEGORYES as $id => $name) { ?>
        <option value="<?php echo h($id); ?>" <?php if($category_id == $id) echo "selected=\"selected\""; ?>><?php echo h($name);?></option>
        <?php } ?>
        </select>

        <input type="text" name="query" value="<?php echo h($query); ?>"/>
        <input type="submit" value="Yahooショッピングで検索"/>
        </form>

        <!-- YahooAPIで検索した商品を表示させる -->
        <?php foreach ($hits as $hit) { ?>
        <div class="Item">
            <h2><a href="<?php echo h($hit->Url); ?>"><?php echo h($hit->Name); ?></a></h2>
            <p><a href="<?php echo h($hit->Url); ?>"><img src="<?php echo h($hit->Image->Medium); ?>" /></a><?php echo h($hit->Description); ?></p>
        </div>
        <?php } ?>

<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
<a href="http://developer.yahoo.co.jp/about">
<img src="http://i.yimg.jp/images/yjdn/yjdn_attbtn2_105_17.gif" width="105" height="17" title="Webサービス by Yahoo! JAPAN" alt="Webサービス by Yahoo! JAPAN" border="0" style="margin:15px 15px 15px 15px"></a>
<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->
    </body>
</html>