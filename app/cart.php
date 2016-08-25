<?php
   require_once '../util/defineUtil.php';
   require_once '../util/scriptUtil.php';
   require_once '../util/dbaccesUtil.php';
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
   //カートから指定された商品を削除する
     if(isset($_GET['delete_item'])){
       $key = $_GET['key'];
       unset($_SESSION['cart'][$key]);
       $_SESSION['cart'] = NULL;
     }
?>

   <html>
       <head>
           <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
           <title>カート</title>
           <link rel="stylesheet" type="text/css" href="../css/prototype.css"/>
       </head>
       <body>
           <h1><a href="./top.php">カート</a></h1>
            <?php
            if (isset($_SESSION['cart'])) {
            $total_price = 0;
            //$_SESSION['cart']の中身をforeachで表示
            foreach ($_SESSION['cart'] as $key => $value) {
             echo '------------------------------------------------------------<br>';
             echo '商品名：' .$value['name'] . '<br>';
             echo '画像：';?><img src="<?php echo $value['image']; ?>" />
    <?php
            echo '<br>価格：' . $value['price'] . '円<br>';
            echo "<br>"; ?>

            <form action="<?php echo cart; ?>" method="GET">
            <input type="submit" name="delete_item" value="カートから商品を削除">
            <input type="hidden" name="key" value="<?php echo $key; ?>">
            </form>

    <?php
            echo '------------------------------------------------------------<br><br>';
            //合計金額を計算
            $total_price += (int)$value['price'] * 1;
          }
            echo "合計金額：" . $total_price . "円";
          ?>

            <form action="<?php echo buy_confirm; ?>" method="GET">
            <input type="submit" name="buy" value="購入する">
            <input type="hidden" name="buy" value="buy">
            </form>
  <?php
      echo '<br><br>' . return_top();
  //カートに何も入っていないときはこちらへ分岐
    }else{
        echo "カートが空です<br><br>";
        echo return_top();
      }
        ?>
           <br><br><br>
       </body>
   </html>