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
      <title>削除確認画面</title>
</head>
  <body>
    <?php
    //直リンク防止のif文追加
    if($mode != "my_delete"){
        echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
    }else{
      //前のページから飛ばされてきている$_GET['id']を代入して$idを作成
      // $idをprofile_detailで検索して、その内容を$resultへ代入
    $id = $_POST['id'];
    $result = profile_detail($id);
    //前のページから飛ばされてきている$_GET['id']を代入して$idを作成
    // $idをprofile_detailで検索して、その内容を$resultへ代入
    $id = $_SESSION['login_userID'];
    $result = profile_detail($id);
    //エラーが発生しなければ表示を行う
    if(is_array($result)){
    //表示された内容を次のページでも使いたいので、name,birthdayなどの各項目をセッションへ代入
    $_SESSION['name'] = $result[0]['name'];
    $_SESSION['password'] = $result[0]['password'];
    $_SESSION['mail'] =  $result[0]['mail'];
    $_SESSION['address'] = $result[0]['address'];
    $_SESSION['total'] = $result[0]['total'];
    $_SESSION['newDate'] = $result[0]['newDate'];
    //各セッションを変数へ代入
    $name = $_SESSION['name'];
    $password = $_SESSION['password'];
    $mail = $_SESSION['mail'];
    $address = $_SESSION['address'];
    $total = $_SESSION['total'];
    $newDate = $_SESSION['newDate'];
  }
    ?>
<?php
    //エラーが発生しなければ表示を行う
    if(is_array($result)){
     ?>
    <h1>削除確認</h1>
    以下の内容を削除します。よろしいですか？<br>
    名前:<?php echo $name;?><br>
    パスワード:<?php echo $password;?><br>
    メールアドレス:<?php echo $mail;?><br>
    住所:<?php echo $address;?><br>
    総購入金額:<?php echo $total;?>円<br>
    登録日時:<?php echo date('Y年n月j日　G時i分s秒', strtotime($newDate)); ?><br>

    <form action="<?php echo my_delete_result; ?>" method="POST">
      <input type="submit" name="YES" value="はい"style="width:100px">
      <input type="hidden" name="mode" value="my_delete_result">
      <input type="hidden" name="id" value=<?php echo $id ?>>
    </form>

    <form action="<?php echo mydata; ?>" method="POST">
      <input type="submit" name="NO" value="詳細画面に戻る"style="width:100px">
      <input type="hidden" name="id" value=<?php echo $id ?>>
    </form>

    <?php
    }else{
        echo 'データの取得に失敗しました。次記のエラーにより処理を中断します:'.$result;
    }
    }
    echo return_top();//トップページへ戻るボタン追加
    ?>
   </body>
</html>