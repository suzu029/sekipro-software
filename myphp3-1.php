<?php
//HTML文を出力 HTMLの開始
print("<HTML>\n");

//HTML文を出力 HEADの開始
print("<HEAD>\n");

//文字コードをUTF-8と指定
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");

//HTML文を出力 TITLEの指定
print("<TITLE>myphp3-1</TITLE>\n");

//HTML文を出力 HEADの終了
print("</HEAD>\n");

//HTML文を出力 <BODYの開始
print("<BODY>\n");

//myphp3.phpから入力フォーマットに入力されたデータをpostで渡されるので
//filter_inputによりフィールドの内容を取り出し各変数に格納
$s_number = filter_input(INPUT_POST, 's_number');
$subject = filter_input(INPUT_POST, 'subject');
$sub = filter_input(INPUT_POST, 'sub');
$name = filter_input(INPUT_POST, 'name');
$day = filter_input(INPUT_POST, 'day');

// 必須入力項目のチェック (例としてs_numberとname)
if (empty($s_number) || empty($name)) {
    print("エラー: 学籍番号と名前は必須入力です。<br>");
    print ("<br><a href=javascript:history.back()>戻る</a><br>");
    print("</BODY>\n");
    print("</HTML>\n");
    exit();
}


//DBへ接続開始 サーバー名--localhost ユーザー名--root パスワード--root
$dbHandle = mysqli_connect("localhost","root","171641")
 or die("DB接続エラー: " . mysqli_connect_error());

//MySQLのクライアントの文字コードをutf8に設定
mysqli_set_charset($dbHandle, "utf8");

//使用するdb名を指定する studentを指定
mysqli_select_db($dbHandle,"student");


$stmt_insert = mysqli_prepare($dbHandle, "INSERT INTO submission (s_number, name, subject, sub,day) VALUES (?, ?, ?, ?, ?)");
if ($stmt_insert) {
    mysqli_stmt_bind_param($stmt_insert, "sssss", $s_number, $name, $subject, $sub,$day);
    
    if (mysqli_stmt_execute($stmt_insert)) {
        print("学籍番号 [" . htmlspecialchars($s_number) . "] のデータを登録しました。<br>");
    } else {
        print("データの登録に失敗しました: " . htmlspecialchars(mysqli_error($dbHandle)) . "<br>");
    }
    mysqli_stmt_close($stmt_insert);
} else {
    print("SQLステートメントの準備に失敗しました (挿入): " . htmlspecialchars(mysqli_error($dbHandle)) . "<br>");
}


//DBへの接続を切断
mysqli_close($dbHandle);

//HTML文を出力 javascriptを使用して直前のページに戻るリンク
print ("<br><a href=javascript:history.back()>戻る</a><br>");

//HTML文を出力 BODYの終了
print("</BODY>\n");

//HTML文を出力 HTMLの終了
print("</HTML>\n");
?>
<br>
<a href="myphp.php">メニュー</a><br>