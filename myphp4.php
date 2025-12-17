<?php
//HTML文を出力 HTMLの開始
print("<HTML>\n");

//HTML文を出力 HEADの開始
print("<HEAD>\n");

//文字コードをUTF-8と指定
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");
print("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/myphp4.css\">\n");
//HTML文を出力 TITLEの指定
print("<TITLE>myphp4</TITLE>\n");
// 削除ボタンが押された際に確認メッセージを出力するJavascriptの記述の開始
print("<SCRIPT language=JavaScript>\n");
print("\n");
print("</SCRIPT>\n");
// 削除ボタンが押された際に確認メッセージを出力するJavascriptの記述の終了

//HTML文を出力 HEADの終了
print("</HEAD>\n");

//HTML文を出力 BODYの開始
print("<BODY>\n");

// ACTOR_CDフィールドへの入力の有無をチェック
if (strlen(filter_input(INPUT_POST,'s_number')) == 0) {
    // 学籍番号が入力されていない場合：検索フォームを表示
    print("<b>登録削除</b><br><br>");
    print("<FORM action=myphp4.php method=post>"); // 自分自身にPOST
    print("削除したいデータの学籍番号を入力してください<br><br>");
    print("<INPUT type=text name=s_number size=10 maxlengh=10><br><br>");
    print("<INPUT type=submit value=検索>"); // 検索ボタン
    print("<INPUT type=reset value=取消><br>");
    print("</FORM>");

} else {
    $search_s_number = filter_input(INPUT_POST,'s_number');

    $dbHandle = mysqli_connect("localhost","root","171641")
        or die("DB接続エラー: " . mysqli_connect_error());
    mysqli_set_charset($dbHandle, "utf8");
    mysqli_select_db($dbHandle,"student");

    // SQLインジェクション対策のためにプリペアドステートメントを使用
    $stmt = mysqli_prepare($dbHandle, "SELECT * FROM submission WHERE s_number = ?");
    mysqli_stmt_bind_param($stmt, "s", $search_s_number);
    mysqli_stmt_execute($stmt);
    $rs = mysqli_stmt_get_result($stmt);

    $rows = mysqli_num_rows($rs);
    $fields_info = mysqli_fetch_fields($rs);

    if ($rows > 0) {
        print("<b>削除対象データ一覧</b><br><br>");
        print("学籍番号 [" . htmlspecialchars($search_s_number) . "] に該当するデータが " . $rows . " 件見つかりました。<br>");
        print("削除したいレコードの「削除」ボタンを押してください。<br><br>");

        print("<TABLE border=1>");
        print("<tr>");
        // ヘッダー行の出力
        foreach ($fields_info as $finfo) {
            print("<th>" . htmlspecialchars($finfo->name) . "</th>");
        }
        print("<th>操作</th>"); // 削除ボタン用の列を追加
        print("</tr>");

        // すべての検索結果をループして表示
        while ($row = mysqli_fetch_array($rs)) {
            print("<tr>");
            foreach ($fields_info as $index => $finfo) {
                print("<td>" . htmlspecialchars($row[$index]) . "</td>"); // XSS対策
            }
            // 各行の「削除」ボタンを追加
            // そのレコードのIDをhiddenでPOSTする
            print("<td><form action='myphp4-1.php' method='post'>");
            print("<input type='hidden' name='record_id' value='" . htmlspecialchars($row['id']) . "'>");
            print("<input type='submit' value='削除' onClick='return diag()'>"); // JavaScript確認を付ける
            print("</form></td>");
            print("</tr>");
        }
        print("</TABLE><br>");

    } else {
        print("学籍番号 [" . htmlspecialchars($search_s_number) . "] のデータは登録されていません。<br>");
    }   

    mysqli_free_result($rs);
    mysqli_stmt_close($stmt);
    mysqli_close($dbHandle);
}

//HTML文を出力 javascriptを使用して直前のページに戻るリンク
print ("<br><a href=javascript:history.back()>戻る</a><br>"); // 検索フォームに戻る
print("</BODY>\n");
print("</HTML>\n");
?>
<br>
<a href="myphp.php">メニュー</a><br>