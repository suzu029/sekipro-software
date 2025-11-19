<?php
//HTML文を出力 HTMLの開始
print("<HTML>\n");

//HTML文を出力 HEADの開始
print("<HEAD>\n");

//文字コードをUTF-8と指定
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");

//HTML文を出力 TITLEの指定
print("<TITLE>myphp2</TITLE>\n");

//HTML文を出力 HEADの終了
print("</HEAD>\n");

//HTML文を出力 BODYの開始
print("<BODY>\n");

//HTML文を出力 登録確認
print("<b>提出確認</b><br><br>");

//HTML文を出力 FORMの開始
print("<FORM action=myphp2-1.php method=post>");

//HTML文を出力 入力フィールドの説明
print("学籍番号と提出状況を選択してください<br><br>"); // 説明文変更

//HTML文を出力 入力フィールドの指定
print("学籍番号: <INPUT type=text name=s_number size=8 maxlengh=8 required><br><br>"); // requiredを追加

// HTML文を出力 入力フィールドの指定 (提出状況のプルダウン)
print("提出状況: <select name=\"sub\" required>");
print("<option value=\"\">選択してください</option>");
print("<option value=\"全て\">全て</option>"); // 全てのデータを見る選択肢
print("<option value=\"提出済み\">提出済み</option>");
print("<option value=\"未提出\">未提出</option>");
print("</select><br><br>");

//HTML文を出力 確認ボタン
print("<INPUT type=submit value=確認>");

//HTML文を出力 取消ボタン
print("<INPUT type=reset value=取消><br>");

//HTML文を出力 FORMの終了
print("</FORM>");

//HTML文を出力 BODYの終了
print("</BODY>\n");

//HTML文を出力 HTMLの終了
print("</HTML>\n");
?>
<br>
<a href="myphp.php">メニュー</a><br>