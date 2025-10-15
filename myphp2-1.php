<?php
//HTML文を出力 HTMLの開始
print("<HTML>\n");

//HTML文を出力 HEADの開始
print("<HEAD>\n");

//文字コードをUTF-8と指定
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");

//HTML文を出力 TITLEの指定
print("<TITLE>myphp2-1</TITLE>\n");

//HTML文を出力 HEADの終了
print("</HEAD>\n");

//HTML文を出力 <BODYの開始
print("<BODY>\n");

//myphp2.phpから入力フォーマットに入力されたデータをpostで渡されるので
//filter_inputによりフィールドの内容を取り出し $search_s_numberに格納
$search_s_number = filter_input(INPUT_POST, "s_number");

// 検索キーが入力されているかチェック
if (empty($search_s_number)) {
    print("エラー: 検索する学籍番号が入力されていません。<br>");
    print ("<br><a href=javascript:history.back()>戻る</a><br>");
    print("</BODY>\n");
    print("</HTML>\n");
    exit();
}

$dbHandle = mysqli_connect("localhost","root","171641")
 or die("DB接続エラー: " . mysqli_connect_error());

//MySQLのクライアントの文字コードをutf8に設定
mysqli_set_charset($dbHandle, "utf8");
 
//使用するdb名を指定する studentを指定
mysqli_select_db($dbHandle,"student");


$stmt = mysqli_prepare($dbHandle, "SELECT * FROM submission WHERE s_number = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $search_s_number); // 's' は文字列型を示す
    mysqli_stmt_execute($stmt);
    $rs = mysqli_stmt_get_result($stmt); // 結果セットを取得

    $rows = mysqli_num_rows($rs);
    
    // 入力された学籍番号の行があった場合はデータを出力する
    if ($rows > 0) {
        print("<b>検索結果</b><br><br>");
        print("学籍番号 [" . htmlspecialchars($search_s_number) . "] に該当するデータが " . $rows . " 件見つかりました。<br><br>");

        print("<TABLE border=1>");
        print("<tr>");
        // ヘッダー行の出力
        $fields_info = mysqli_fetch_fields($rs); // 列情報を取得
        foreach ($fields_info as $finfo) {
            print("<th>" . htmlspecialchars($finfo->name) . "</th>");
        }
        print("</tr>");

        // ★★★ すべての検索結果をループして表示 ★★★
        while ($row = mysqli_fetch_array($rs)) {
            print("<tr>");
            foreach ($fields_info as $index => $finfo) {
                print("<td>" . htmlspecialchars($row[$index]) . "</td>"); // XSS対策
            }
            print("</tr>");
        }
        print("</TABLE>"); // テーブルの閉じタグをループの外に出す

    } else {
        // 入力された学籍番号の行が存在しなかった場合はエラーメッセージを出力する
        print("学籍番号が  [" . htmlspecialchars($search_s_number) . "]  のデータは登録されていません<br>");
    }  

    //結果レコードをメモリから開放
    mysqli_free_result($rs);
    // プリペアドステートメントを閉じる
    mysqli_stmt_close($stmt);

} else {
    print("SQLステートメントの準備に失敗しました: " . htmlspecialchars(mysqli_error($dbHandle)) . "<br>");
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