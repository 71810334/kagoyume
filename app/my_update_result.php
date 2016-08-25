<?php
 require_once '../util/defineUtil.php';
 require_once '../util/scriptUtil.php';
  require_once '../util/dbaccesUtil.php';
session_start();
/* $_GET['mode']に値が入っていたら$modeへ代入、
  値が入っていなければnullを入れて$modeへ代入 */
  $mode=isset($_POST['mode'])?$_POST['mode']:null;
  ?>

  <!DOCTYPE html>
  <html lang="ja">
  <head>
  <meta charset="UTF-8">
        <title>更新結果画面</title>
  </head>
    <body>
      <?php
      //直リンク防止のif文追加
      if($mode != "mydata_update_result"){
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
        //各セッションを変数へ代入
        $_SESSION['userID'] = $result[0]['userID'];
        $name = $_SESSION['name'];
        $password = $_SESSION['password'];
        $mail = $_SESSION['mail'];
        $address = $_SESSION['address'];
}
      //$name, $birthday, $type, $tell, $comment,$idをupdate_profilesで検索し、$resultへ代入
      $result = update_profiles($name, $password, $mail, $address);
      //エラーが発生しなければ表示を行う
      if(!isset($result)){
      ?>
      <h1>更新確認</h1>
      以上の内容で更新しました。<br>
      <?php
      }else{
          echo 'データの更新に失敗しました。次記のエラーにより処理を中断します:'.$result;
      }
     }
      echo return_top();  //トップページへ戻るボタン追加
      ?>
    </body>
  </html>