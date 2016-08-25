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
          <?php }?>

   <html>
       <head>
           <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
           <title>購入確認ページ</title>
           <link rel="stylesheet" type="text/css" href="../css/prototype.css"/>
       </head>
       <body>
           <h1><a href="./top.php">購入確認ページ</a></h1>
           <form action="<?php echo buy_complete; ?>" method="GET">
          <?php
          $total_price = 0;
        //$_SESSION['cart']の中身をforeachで表示
          foreach ($_SESSION['cart'] as $key => $value) {
              echo '------------------------------------------------------------<br>';
              echo '商品名：' .$value['name'] . '<br>';
              echo '画像：';?><img src="<?php echo $value['image']; ?>" />
          <?php
              echo '<br>価格：' . $value['price'] . '円<br>';
              echo "<br>------------------------------------------------------------<br>";
                 //合計金額を計算
                  $total_price += (int)$value['price'] * 1;
                }
                  echo "合計金額：" . $total_price . "円";
                  $_SESSION['total'] = $total_price;
          ?>
          <br><br>
           購入方法:<br>
         <?php
         for($i = 1; $i<=3; $i++){ ?>
         <input type="radio" name="type" value="<?php echo $i; ?>"><?php echo ex_typenum($i);?><br>
         <?php $_SESSION['type'] = $i ;} ?>
         <br>

         <input type="submit" name="buy" value="上記の内容で購入する">
         <input type="hidden" name="buy" value="buy">
          </form>

        <form action="<?php echo cart; ?>" method="GET">
         <input type="submit" name="no" value="カートへ戻る">
         <input type="hidden" name="no" value="no">
         </form>

         <?php  echo '<br><br>' . return_top(); ?>
          <br><br><br>
       </body>
   </html>