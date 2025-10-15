<?php
//HTML文を出力 HTMLの開始
print("<HTML>\n");

//HTML文を出力 HEADの開始
print("<HEAD>\n");
print("<b>提出状況</b><br><br>");

//文字コードをUTF-8と指定
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");

//HTML文を出力 TITLEの指定
print("<TITLE>myphp1</TITLE>\n");

//HTML文を出力 HEADの終了
print("</HEAD>\n");

//DBへ接続開始 サーバー名--localhost ユーザー名--root パスワード--root
$dbHandle = mysqli_connect("localhost","root","171641")
	or die("can not connect db\n");

//MySQLのクライアントの文字コードをutf8に設定
mysqli_set_charset($dbHandle, "utf8");

//使用するdb名を指定する  movieを指定
mysqli_select_db($dbHandle, "student");

//SQL文 actor表から全行を取り出し、ACTOR_CD列の昇順に整列する
$sql = "select * from submission order by 1";

//SQL文を実行する
$rs = mysqli_query($dbHandle, $sql);

//列数を取得する
$num = mysqli_num_fields($rs);

//HTML文を出力 テーブルの開始を指定
print("<table border=1>");

//テーブルの列数と同じ回数を繰り返す
//mysqli_fetch_field関数を使用しテーブルの列名を出力する
if ($result = mysqli_query($dbHandle, $sql)) {
	while ($finfo = mysqli_fetch_field($rs)) {
	echo "<td><b>".$finfo->name."</b></td>";
	}
}

//テーブルの行数と同じ回数を繰り返す
while($row=mysqli_fetch_array($rs)){

//HTML文を出力 表の行の開始<tr> を出力
	print("<tr>");
	
//テーブルの列数と同じ回数を繰り返す
	for($j=0;$j<$num;$j++){
	
//HTML文を出力 列の内容を <td>で囲んで出力
		print("<td>".$row[$j]."</td>");
		}
//HTML文を出力 表の改行</tr> を出力
	print("</tr>");
}

//HTML文を出力 テーブルの終了を指定
print("</table>");

//結果レコードをメモリから開放
mysqli_free_result($rs);

//DBへの接続を切断
mysqli_close($dbHandle);

?>
<br>
<a href="myphp.php">メニュー</a><br>