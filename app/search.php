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
            <form action="<?php echo mydata; ?>" method="GET">
           <?php echo 'ようこそ';?><a href="./mydata.php?id=<?php echo $_SESSION['login_userID']?>"><?php echo $_SESSION['login_name'];?></a><?php echo  'さん！';?>
            <input type="hidden" name="mode" value="mydata">
            </form>

            <form action="<?php echo CART ?>">
            <input type="submit" name="cart" value="買い物かごへ">
              </form>

           <form action="<?php echo TOP ?>" method="POST">
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
 $query = $_GET['query'];//検索したいキーワード
 if (empty($query)){
   echo 'キーワードが入力されておりません。' .'<br>';
 }else{
//YahooAPIで商品を検索して、検索内容を$hitsへ格納
 if ($query != "") {
     $query4url = rawurlencode($query);
     $url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appID&query=$query4url";
     $xml = simplexml_load_file($url);
     if ($xml["totalResultsReturned"] != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
         $hits = $xml->Result->Hit;
         }
 }?>

<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
        <title>「<?php echo h($query); ?>」の検索結果</title>
        <link rel="stylesheet" type="text/css" href="../css/prototype.css"/>
    </head>
    <body>
        <h1><a href="./top.php">「<?php echo h($query); ?>」の検索結果 - 検索件数:20件</a></h1>
        <form action="ITEM" method="GET">

          <!-- 検索した商品を表示 -->
        <?php foreach ($hits as $hit) { ?>
        <div name="item" class="item">
           <a href="./item.php?item=<?php echo h($hit->Code);?>"><img src="<?php echo h($hit->Image->Medium); ?>" align="left" /></a>
         <h2><a href="./item.php?item=<?php echo h($hit->Code);?>"><?php echo h($hit->Name);?></a></h2>
          <br>
          <FONT color="red"><?php echo '価格' . h($hit->Price) . '円';?></FONT>
          <br clear="left">
        </div>
        <?php } ?>
      </form>

      <?php  }
      echo return_top(); ?>
    <br>
    </body>