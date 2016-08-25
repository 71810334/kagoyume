<?php 
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';
require_once '../util/dbaccesUtil.php';
session_start();

//入力フォームに名前とパスワード両方入力されているか検証し、
//入力されていたら入力された値を変数へ格納
if (isset($_POST['name'])&&($_POST['password'])){
  $login = login($_POST['name'],$_POST['password']);
//入力フォームに入力された値がDBの情報と合致するか検証
      if ($_POST['name'] ==  $login[0]['name']  && $_POST['password'] ==  $login[0]['password']) {
        $_SESSION['ok'] = 'ok';
        $_SESSION['login_name'] = $login[0]['name'];
        $_SESSION['login_userID'] = $login[0]['userID'];
        }
//トップページへ遷移
echo '<meta http-equiv="refresh" content="0;URL='.top.'">';
//ログイン状態ではない場合はログイン画面を表示
}else{
?>

<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>ログイン画面</title>
</head>
<body>
<h1>ログインページ</h1>

<a href="<?php echo registration; ?>">新規登録</a><br><br>
<form action="<?php echo login ?>" method="POST">

ユーザー名: <br>
      <input type="text" name="name" value="<?php echo form_value('name'); ?>">
      <br><br>

      パスワード: <br>
      <input type="text" name="password" value="<?php echo form_value('password'); ?>">
      <br><br>

      <input type="hidden" name="mode"  value="login">
      <input type="submit" name="btnSubmit" value="ログイン">

</form>
 <!-- トップページへの戻るリンクの実装 -->
    <?php
     echo return_top(); // トップへ戻るリンクを設置
}
?>
</body>
</html>