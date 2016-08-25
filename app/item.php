<?php
   require_once '../util/defineUtil.php';
   require_once '../util/scriptUtil.php';
   session_start();

$itemcode = $_GET['item'];
    //YahooAPIで検索した情報を$hitsへ格納
    $hits = search_item($itemcode);
   //$hitsに格納した商品の全情報から必要な情報のみ取得する
    $name = h($hits->Name);
    $image = h($hits->Image->Medium);
    $syousai = strip_tags($hits->Description);
    $rebyu = h($hits->Review->Rate);
?>

<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
        <title>商品詳細</title>
        <link rel="stylesheet" type="text/css" href="../css/prototype.css"/>
    </head>
    <body>
        <h1><a href="./top.php">商品詳細</a></h1>
        <form action="<?php echo add; ?>" method="GET">

        <h1>詳細情報</h1>
        商品名:<?php echo $name;?><br><br>
        画像:<br><img src="<?php echo $image; ?>" /><br><br>
        商品詳細:<br><?php echo $syousai;?><br><br>
        レビュー平均:<?php echo $rebyu;?><br>

        <br><br>
        <form action="<?php echo add ?>" method="GET">
        <input type="submit" name="add" value="カートへ追加">
        <input type="hidden" name="add" value="<?php echo $itemcode;?>">
        </form>
      <br><br>
      <?php  echo return_top(); ?>
       <br><br><br>
    </body>
</html>