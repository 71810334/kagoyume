<?php 
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';

$mode=isset($_GET['mode'])?$_GET['mode']:null;

session_start();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <title>マイデータ</title>
</head>
<body>
    <h1>マイデータ</h1><br>
    <?php
    if($mode == "mydata"){
    	echo 'アクセスルートが不正です。もう一度トップページからやり直して下さい<br>';
    }else{}
    
    $id = $_SESSION['login_userID'];
    $result = profile_detail($id);

    if(is_array($result)){
    
    $_SESSION['userID'] = $result[0]['userID'];
    $_SESSION['name'] = $result[0]['name'];
    $_SESSION['password'] = $result[0]['password'];
    $_SESSION['mail'] =  $result[0]['mail'];
    $_SESSION['address'] = $result[0]['address'];
    $_SESSION['newDate'] = $result[0]['newDate'];
    //各セッションを変数へ代入
    $_SESSION['userID'] = $result[0]['userID'];
    $name = $_SESSION['name'];
    $password = $_SESSION['password'];
    $mail = $_SESSION['mail'];
    $address = $_SESSION['address'];
    $newDate = $_SESSION['newDate'];

    ?>
      
    <h1>詳細情報</h1>
    名前:<?php echo $result[0]['name'];?><br>
    パスワード:<?php echo $result[0]['password'];?><br>
    メールアドレス:<?php echo $result[0]['mail'];?><br>
    住所:<?php echo $result[0]['address'];?><br>
    登録日時:<?php echo date('Y年n月j日　G時i分s秒', strtotime($result[0]['newDate'])); ?><br>
    
    
    <form action="<?php echo my_update; ?>" method="POST">
        <input type="submit" name="update" value="変更"style="width:100px">
        <input type="hidden" name="id" value="<?php echo $result[0]['userID'] ?>">
    </form>
    <form action="<?php echo my_delete; ?>" method="POST">
        <input type="submit" name="delete" value="削除"style="width:100px">
    </form>
    
    <?php
    }else{
        echo 'データの検索に失敗しました。次記のエラーにより処理を中断します:'.$result;
    }
    //登録したユーザー情報の閲覧
    //購入履歴リンク有り
    //登録情報の更新または削除リンク有り
	
    // トップページへの戻るリンクの実装
    echo return_top(); // トップへ戻るリンクを設置?>
</body>
</html>
