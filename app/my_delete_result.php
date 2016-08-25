<?php
 require_once '../util/defineUtil.php';
 require_once '../util/scriptUtil.php';
 require_once '../util/dbaccesUtil.php';
/* $_GET['mode']に値が入っていたら$modeへ代入、
値が入っていなければnullを入れて$modeへ代入 */
$mode=isset($_POST['mode'])?$_POST['mode']:null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>削除結果画面</title>
</head>
<body>
    <?php
    //直リンク防止のif文追加
    if($mode != "my_delete_result"){
        echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
    }else{
    //前のページから飛ばされてきている$_GET['id']を代入して$idを作成
    // $idをdelete_profileで検索して、その内容を$resultへ代入
    $id = $_POST['id'];
    $result = delete_profile($id);
    //エラーが発生しなければ表示を行う
    if(!isset($result)){
    ?>
    <h1>削除確認</h1>
    削除しました。<br>
    </form>
    <?php
    }else{
        echo 'データの削除に失敗しました。次記のエラーにより処理を中断します:'.$result;
    }
    }
    echo return_top();  //トップページへ戻るボタン追加
    ?>
</body>
</html>