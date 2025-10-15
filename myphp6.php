<?php

//ダウンロード前に表示するダイアログの指定
header("Content-Type: application/octet-stream");



//ダウンロード前に表示するダイアログの指定 ファイル名を bu+日付.csv
//と指定
header("Content-Disposition: attachment; filename=\"out_".date('Ymd_His').".csv");

//DBへ接続開始 サーバー名--localhost ユーザー名--root パスワード--root
$dbHandle = mysqli_connect("localhost","root","171641")
  or die("can not connect db\n");
  
//MySQLのクライアントの文字コードをutf8に設定
mysqli_set_charset($dbHandle, "sjis");

//使用するdb名を指定する  movieを指定
$rs = mysqli_select_db($dbHandle,"movie");

//SQL文 actor表からACTOR_CD列の値の昇順にソートした全行を取り出す
$sql = "select * from actor order by 1";

//SQL文を実行する
$rs = mysqli_query($dbHandle, $sql);

//mysqli_num_fields 関数を使用し列数を取得する
$num = mysqli_num_fields($rs);

//mysqli_num_rows 関数を使用し行数を取得する
$rows = mysqli_num_rows($rs);

//テーブルの行数と同じ回数を繰り返す
while($row=mysqli_fetch_array($rs)){
	
//テーブルの列数と同じ回数を繰り返す
	for($j=0;$j<$num;$j++){

//列の内容を出力
		print("\"".$row[$j]."\"");
//最終列でない場合は カンマ を出力する
	if ($j < $num - 1)
		print(",");
	}
//改行コードを出力する
	print("\n");
}

?>

