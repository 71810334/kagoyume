<?php

//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=kagoyume_db;charset=utf8','root');
        //SQL実行時のエラーをtry-catchで取得できるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}

//レコードの挿入を行う。失敗した場合はエラー文を返却する
function insert_profiles($name, $password, $mail, $address,$date){
    //db接続を確立
    $insert_db = connect2MySQL();
    
    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO user_t(name,password,mail,address,newDate)"
            . "VALUES(:name,:password,:mail,:address,:newDate)";

    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':name',$name);
    $insert_query->bindValue(':password',$password);
    $insert_query->bindValue(':mail',$mail);
    $insert_query->bindValue(':address',$address);
    $insert_query->bindValue(':newDate',$date);

    //SQLを実行
    try{
        $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }

    $insert_db=null;
    return null;
}

//ユーザー情報閲覧
function profile_detail($id){
    //db接続 を確立
    $detail_db = connect2MySQL();
    $detail_sql = "SELECT * FROM user_t WHERE userID=:id";
    //クエリとして用意
    $detail_query = $detail_db->prepare($detail_sql);
    $detail_query->bindValue(':id',$id);
    //SQLを実行
    try{
        $detail_query->execute();
    } catch (PDOException $e) {
        $detail_query=null;
        return $e->getMessage();
    }
    //レコードを連想配列として返却
    return $detail_query->fetchall(PDO::FETCH_ASSOC);
}

function search_all_profiles(){
    
    //db接続を確立
    $search_db = connect2MySQL();
    
    $search_sql = "SELECT * FROM user_t";
    
    //クエリとして用意
    $search_query = $search_db->prepare($search_sql);
    
    //SQLを実行
    try{
        $search_query->execute();
    } catch (PDOException $e) {
        $search_query=null;
        return $e->getMessage();
    }
    
    //全レコードを連想配列として返却
    return $search_query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * 複合条件検索を行う
 * @param type $name
 * @param type $password
 * @param type $mail
 * @param type $address
 * @return type
 */
function search_profiles($name=null,$password=null,$mail=null,$address=null){
    //db接続を確立
    $search_db = connect2MySQL();
    
    $search_sql = "SELECT * FROM user_t";
    $flag = false;
    if(isset($name)){
        $search_sql .= " WHERE name like :name";
        $flag = true;
    }
    if(isset($password) && $flag = false){
        $search_sql .= " WHERE password like :password";
        $flag = true;
    }
    if(isset($mail) && $flag == false){
        $search_sql .= " WHERE mail like = :mail";
    }else if(isset($address)){
        $search_sql .= " WHERE mail like = :address";
    }
    
    //sql文の中にそれぞれの文字が入っているか検証
    $name_bind = strstr($search_sql,"name");
    $password_bind = strstr($search_sql,"password");
    $mail_bind = strstr($search_sql,"mail");
    $address_bind = strstr($search_sql,"address");
    
    //クエリとして用意
    $seatch_query = $search_db->prepare($search_sql);
    
    if(isset($name_bind)){
     $seatch_query->bindValue(':name','%'.$name.'%');
        if(!empty($year_bind)){
    }
      $seatch_query->bindValue(':password','%'.password.'%');
    }
    if(!empty($type_bind)){
      $seatch_query->bindValue(':mail',$mail);
    }
    if(!empty($type_bind)){
      $seatch_query->bindValue(':address',$address);
    }
    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_query=null;
        return $e->getMessage();
    }
    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}


//小文字のtを大文字に修正
function delete_profile($id){
    //db接続を確立
    $delete_db = connect2MySQL();
    $delete_sql = "DELETE FROM user_t WHERE userID=:id";
    //クエリとして用意
    $delete_query = $delete_db->prepare($delete_sql);
    $delete_query->bindValue(':id',$id);
    //SQLを実行
    try{
        $delete_query->execute();
    } catch (PDOException $e) {
        $delete_query=null;
        return $e->getMessage();
    }
    return null;
}


function update_profile($name,$password,$mail,$address){
    $update_db = connect2MySQL();

    $update_sql = "UPDATE user_t SET name = :name,password = :password,mail = :mail,
                address = :address,newDate = :newDate WHERE userID = :id;";
              
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');
   
     //クエリとして用意
    $update_query = $update_db->prepare($update_sql);
     //SQL文にセッションから受け取った値＆現在時をバインド
    $update_query->bindValue(':id',$_SESSION['login_userID']);
    $update_query->bindValue(':name',$name);
    $update_query->bindValue(':password',$password);
    $update_query->bindValue(':mail',$mail);
    $update_query->bindValue(':address',$address);
    $update_query->bindValue(':newDate',$date);
     //SQLを実行
    try{
     $update_query->execute();
   } catch (PDOException $e) {
    //接続オブジェクトを初期化することでDB接続を切断
    $update_db=null;
    return $e->getMessage();
  }
  $update_db=null;
  return null;
}


    function login($name,$password){
    //db接続を確立
    $login_db = connect2MySQL();
    $login_sql = "SELECT * FROM user_t WHERE name=:name and password=:password";
    //クエリとして用意
    $login_query = $login_db->prepare($login_sql);
    $login_query->bindValue(':name',$name);
    $login_query->bindValue(':password',$password);
    //SQLを実行
    try{
        $login_query->execute();
    } catch (PDOException $e) {
        $login_query=null;
        return $e->getMessage();
    }
    //レコードを連想配列として返却
    return $login_query->fetchall(PDO::FETCH_ASSOC);
}

//購入データ登録
function insert_buy($userID,$total, $type){
    //db接続を確立
    $insert_buy_db = connect2MySQL();
    //DBにレコードを登録するSQL
    $insert_buy_sql = "INSERT INTO buy_t(userID,type,buyDate)" . "VALUES(:userID,:type,:buyDate)";
    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');
    //クエリとして用意
    $insert_buy_query = $insert_buy_db->prepare($insert_buy_sql);
    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_buy_query->bindValue(':userID',$userID);
    
    $insert_buy_query->bindValue(':type',$type);
    $insert_buy_query->bindValue(':buyDate',$date);
    //SQLを実行
    try{
        $insert_buy_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_buy_db=null;
        return $e->getMessage();
    }
    $insert_buy_db=null;
    return null;
}