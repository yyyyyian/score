<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>顯示成績紀錄的PHP程式</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/table2.css">
</head>
   <button onclick="window.location.href='entry.html'">登陸學生成績</button>
   <button onclick="window.location.href='showdata.php'">顯示學生成績</button>
   <button onclick="window.location.href='index.html'">回主功能頁面</button>
   <h2>顯示成績紀錄的PHP程式</h2>
<body>
<table class=blueTable>
<tr>
  <th>學號</th><th>姓名</th><th>系別</th>
  <th>國文</th><th>英文</th><th>數學</th>
  <th>總分</th><th>平均</th>
</tr>
<?php

  $myfile = fopen("score.csv", "r") or die("Unable to open file"); 
  while (($row = fgetcsv($myfile, 0, ",")) !==FALSE){
    echo '<tr>';
    echo '<td>' . $row[1] . '</td>';
    echo '<td>' . $row[2] . '</td>';
    echo '<td>' . $row[6] . '</td>';
    echo '<td>' . $row[8] . '</td>';
    echo '<td>' . $row[9] . '</td>';
    echo '<td>' . $row[10] . '</td>';
    $s = array($row[8],$row[9],$row[10]);
    $score = array_sum($s);
    $average = ($score / 3);
    echo '<td>' . $score . '</td>';
    echo '<td>' . round($average, 1) . '</td>';
    echo '</tr>';
   }
fclose($myfile)
?>
</table>
<br>
<?php
$myfile = fopen("score.csv","r") or die("Unable to open file!");
  $chinese_sum=0;
  $chinese_n=0;
  while (($row = fgetcsv($myfile, 0, ",")) !==FALSE) {
   $b=($row[8]);
   $chinese_sum=($chinese_sum + $b);
   $chinese_n=($chinese_n + 1);
  }
   $chinese_ave=round($chinese_sum/$chinese_n, 1);
   echo "國文平均分數: $chinese_ave";
?>
<br>
<?php
$myfile = fopen("score.csv","r") or die("Unable to open file!");
  $eng_sum=0;
  $eng_n=0;
  while (($row = fgetcsv($myfile, 0, ",")) !==FALSE) {
   $b=($row[9]);
   $eng_sum=($eng_sum + $b);
   $eng_n=($eng_n + 1);
  }
   $eng_ave=round($eng_sum/$eng_n, 1);
   echo "英文平均分數: $eng_ave";
?>
<br>
<?php
$myfile = fopen("score.csv","r") or die("Unable to open file!");
  $math_sum=0;
  $math_n=0;
  while (($row = fgetcsv($myfile, 0, ",")) !==FALSE) {
   $b=($row[10]);
   $math_sum=(intval($math_sum) + intval($b));
   $math_n=($math_n + 1);
  }
   $math_ave=round($math_sum/$math_n, 1);
   echo "數學平均分數: $math_ave";
?>

</body>
</html>