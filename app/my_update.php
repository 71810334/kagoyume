<?php
 require_once '../util/defineUtil.php';
 require_once '../util/scriptUtil.php';
  require_once '../util/dbaccesUtil.php';
/* $_GET['mode']に値が入っていたら$modeへ代入、
値が入っていなければnullを入れて$modeへ代入 */
$mode=isset($_POST['mode'])?$_POST['mode']:null;
session_start();  //再入力時用
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>変更入力画面</title>
</head>
<body>
    <form action="<?php echo mydata_update_result ?>" method="POST">

    <?php
    //直リンク防止のif文追加
    if($mode != "updata"){
        echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
    }else{
      //前のページから飛ばされてきている$_GET['id']を代入して$idを作成
      // $idをprofile_detailで検索して、その内容を$resultへ代入
      $id = $_SESSION['login_userID'];
      $result = profile_detail($id);
      //エラーが発生しなければ表示を行う
      if(is_array($result)){
      //表示された内容を次のページでも使いたいので、name,birthdayなどの各項目をセッションへ代入
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
    }
      ?>

      ユーザー名: <br>
      <input type="text" name="name" value="<?php echo $name; ?>">
      <br><br>

      パスワード: <br>
      <input type="text" name="password" value="<?php echo $password; ?>">
      <br><br>

      メールアドレス: <br>
      <input type="text" name="mail" value="<?php echo $mail; ?>">
      <br><br>

      住所: <br>
      <textarea name="address" rows=4 cols=50 style="resize:none" wrap="soft"><?php echo $address; ?></textarea><br><br>

    <form action="<?php echo mydata_update_result; ?>" method="POST">
    <input type="submit" name="btnSubmit" value="以上の内容で更新を行う">
    <input type="hidden" name="mode" value="mydata_update_result">
    <input type="hidden" name="id" value=<?php echo $id ?>>
    </form>

      <form action="<?php echo mydata; ?>" method="POST">
      <input type="submit" name="NO" value="詳細画面に戻る"style="width:100px">
      <input type="hidden" name="id" value=<?php echo $id ?>>
    </form>
    <?php
     }
     echo return_top(); //トップページへ戻るボタン追加
    ?>
</body>
</html>