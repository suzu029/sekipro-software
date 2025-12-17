<?php
//HTML文を出力 HTMLの開始
    print("<HTML>\n");

//HTML文を出力 HEADの開始
    print("<HEAD>\n");

//文字コードをUTF-8と指定
    print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");

    print("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/myphp5.css\">\n");

//HTML文を出力 TITLEの指定
    print("<TITLE>myphp5</TITLE>\n");

//HTML文を出力 HEADの終了
    print("</HEAD>\n");

//HTML文を出力 BODYの開始
    print("<BODY>\n");

//ACTOR_CDフィールドへの入力の有無をチェック
if (strlen(filter_input(INPUT_POST, 's_number') ?? '') == 0) {

//HTML文を出力 登録確認
    print("<b>登録変更</b><br><br>");

//HTML文を出力 FORMの開始
    print("<FORM action=myphp5.php method=post>");

//HTML文を出力 入力フィールドの説明
    print("変更したいデータの学生番号を入力してください<br><br>");

//HTML文を出力 入力フィールドの指定
    print("<INPUT type=text name=s_number size=8 maxlengh=8><br><br>");

//HTML文を出力 変更ボタン
    print("<INPUT type=submit value=変更>");

//HTML文を出力 取消ボタン
    print("<INPUT type=reset value=取消><br>");

//HTML文を出力 FORMの終了
    print("</FORM>");

} else {

//filter_inputによりフィールド ACTOR_CD の内容を取り出し $ACTOR_CDに格納
$key=filter_input(INPUT_POST,'s_number');

//DBへ接続開始 サーバー名--localhost ユーザー名--root パスワード--root
$dbHandle = mysqli_connect("localhost","root","171641")
    or die("can not connect db\n");
    
//MySQLのクライアントの文字コードをutf8に設定
mysqli_set_charset($dbHandle, "utf8");

//使用するdb名を指定する  studentを指定
mysqli_select_db($dbHandle,"student");

// SQLインジェクション対策のためにプリペアドステートメントを使用
$stmt = mysqli_prepare($dbHandle, "select * from submission where s_number = ?");
mysqli_stmt_bind_param($stmt, "s", $key); // 's' は文字列型を示す
mysqli_stmt_execute($stmt);
$rs = mysqli_stmt_get_result($stmt); // 結果セットを取得

//mysqli_num_rows 関数を使用し行数を取得する
$rows = mysqli_num_rows($rs);

//列情報を取得
$fields_info = mysqli_fetch_fields($rs);


//入力された学籍番号の行があった場合はデータを出力する
if ($rows > 0) {

    print("<b>検索結果</b><br><br>");
    print("学生番号 [" . htmlspecialchars($key) . "] に該当するデータが " . $rows . " 件見つかりました。<br>");
    print("変更したいレコードの「変更」ボタンを押してください。<br><br>");

    print("<TABLE border=1>");
    print("<tr>");
    // ヘッダー行の出力
    foreach ($fields_info as $finfo) {
        print("<th>" . htmlspecialchars($finfo->name) . "</th>");
    }
    print("<th>操作</th>"); // 変更ボタン用の列を追加
    print("</tr>");

    // すべての検索結果をループして表示
    while ($row = mysqli_fetch_array($rs)) {
        print("<tr>");
        foreach ($fields_info as $index => $finfo) {
            print("<td>" . htmlspecialchars($row[$index]) . "</td>"); // XSS対策
        }
        // 各行の「変更」ボタンを追加
        // id列の値を渡す
        print("<td><form action='myphp5-1.php' method='post'>");
        print("<input type='hidden' name='record_id' value='" . htmlspecialchars($row['id']) . "'>"); // id列の値を渡す
        print("<input type='submit' value='変更'>");
        print("</form></td>");
        print("</tr>");
    }
    print("</TABLE><br>");

} else {
    //入力された学籍番号の行が存在しなかった場合はエラーメッセージを出力する
    print("学生番号が  [" . htmlspecialchars($key) . "]  のデータは登録されていません<br>");
}   

//結果レコードをメモリから開放
    mysqli_free_result($rs);
// プリペアドステートメントを閉じる
    mysqli_stmt_close($stmt);

//DBへの接続を切断
    mysqli_close($dbHandle);
}
//HTML文を出力 javascriptを使用して直前のページに戻るリンク
print ("<a href=javascript:history.back()>戻る</a>");

//HTML文を出力 BODYの終了
print("</BODY>\n");

//HTML文を出力 HTMLの終了
print("</HTML>\n");

?>
<a href="myphp.php">メニュー</a>