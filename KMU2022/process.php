<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>計算成績的PHP程式</title>
  <link rel="stylesheet" href="css/style.css">
</head>
  
<body>
   <button onclick="window.location.href='entry.html'">登陸學生成績</button>
   <button onclick="window.location.href='showdata.php'">顯示學生成績</button>
   <button onclick="window.location.href='index.html'">回主功能頁面</button>
<?php
  function getAge($year, $month, $day) {
    $date = "$year-$month-$day";
    if (version_compare(PHP_VERSION, '5.3.0') >=0) {
      $dob = new DateTime($date);
      $now = new DateTime();
      return $now->diff($dob)->y;
    }
    $difference = time() - strtotime($date);
    return floor($difference/31556926);  
  }
  
  /*function getscore($chinese, $english, $math){
    $SC = $chinese + $english + $math;
  }
  */
  function getAVERAGEStatus($averageValue){
    if ($averageValue >=100){
      $status = "<font color=#ff0000> (優良) </font>";
    } elseif ($averageValue >= 90 and $averageValue < 99){
      $status = "<font color=#ff0000> (甲等) </font>";
    } elseif ($averageValue >= 80 and $averageValue < 89){
      $status = "<font color=#ff0000> (乙等) </font>";
    } elseif ($averageValue >= 70 and $averageValue < 79){
      $status = "<font color=#ff0000> (丙等) </font>";
    } elseif ($averageValue >= 60 and $averageValue < 69){
      $status = "<font color=#0000ff> (丁等) </font>";
    } else {
      $status = "<font color=#00ff00> (不及格) </font>";
    }
    return $status;
  }
  
  function getTitle($genderValue){
    if ($genderValue == "M"){
      $title = "先生";
    } else {
      $title = "小姐";
    }
    return $title;
  }
    
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $receive_mtehod = "* 資料接收方式：GET";
    //指定變數$height，接收form 傳來的身高
    $stNo = $_GET['stNo'];
    $stName = $_GET['stName'];
    $gender = $_GET['gender'];
    $grade = $_GET['grade'];
    $dob_year = $_GET["dob_year"];
    $dob_month = $_GET["dob_month"];
    $dob_day = $_GET["dob_day"];
    $birthday =  $_GET["dob_year"]."/".$_GET["dob_month"]."/".$_GET["dob_day"];
    //$age = $_GET['age'];
    $department = $_GET['department'];
    $club = $_GET['club'];
    $chinese = $_GET['chinese'];
    //指定變數$weight，接收form 傳來的體重
    $english = $_GET['english']; 
    $math = $_GET['math']; 
    
  }
 
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receive_mtehod = "* 資料接收方式：POST";
    //指定變數$height，接收form 傳來的身高
    $stNo = $_POST['stNo'];
    $stName = $_POST['stName'];
    $gender = $_POST['gender'];
    $grade = $_POST['grade'];
    $dob_year = $_POST["dob_year"];
    $dob_month = $_POST["dob_month"];
    $dob_day = $_POST["dob_day"];
    $birthday = $_POST["dob_year"]."/".$_POST["dob_month"]."/".$_POST["dob_day"];
    //$age = $_POST['age'];
    $department = $_POST['department'];
    $club = $_POST['club'];
    $chinese = $_POST['chinese'];
    //指定變數$weight，接收form 傳來的體重
    $english = $_POST['english'];
    $math = $_POST['math'];
  }
   //將複選的變數$club項目以("/",$club)
  $myclub = implode("/",$club);
  
  //檢查接收資料是否為空值
  /*if (empty($chinese)||empty($english)) {
      echo "* Server：國文或英文或數學是空值，請輸入資料！";
      echo "<a href='entry.html'>《返回表單》</a>";
    } else {*/
      //pow()函數：可以將數值計算至指定的次方數
      //round()函數：可以將數值計算至指定的小數位數
      $score = $chinese + $english + $math;
      $age = getAge($dob_year,$dob_month,$dob_day);
      $average = ($score / 3);
      echo "<h2>PHP 計算成績的PHP程式</h2>";
      echo "<font color='red'><b>$receive_mtehod</b></font>";
      echo "<br>";
      echo "* 學號: $stNo ";
      echo"<br>";
      echo "* 姓名: $stName ";
      echo"<br>";
      echo "* 性別: $gender ";
      echo"<br>";
      echo "* 年級: $grade 年級";
      echo"<br>";
      echo"* 生日：".$birthday;
      echo"<br>";
      echo "* 年齡: $age 歲";
      echo"<br>";
      echo "* 科系: $department ";
      echo"<br>" ;
      echo "* 社團: $myclub ";
      echo"<br>";
      echo "* 國文：$chinese 分";
      echo "<br>";
      echo "* 英文：$english 分";
      echo "<br>";
      echo "* 數學：$math 分";
      echo "<br><br>";
      echo "* $stName ".getTitle($gender)." 好! 您的 總分 = ". $score;
      echo "平均：".round($average,1);
      echo getAVERAGEStatus($average);

       
      if (!$fp=fopen("score.csv", "a")) { //檢查能否開啟資料輸入檔案 class.txt
        echo "檔案無法開啟"; //如果不能開啟class.txt.，則顯示檔案無法開啟    
        exit; //結束
      }
      
      //設定時區
      date_default_timezone_set("Asia/Taipei");
      //擷取當地的系統時間
      $today = getdate();
      //時間格式 年/月/日-時:分
      $date = "$today[year]/$today[mon]/$today[mday]-$today[hours]:$today[minutes]:$today[seconds]";
      //寫入class.txt的時間格式
      $record1 = "$date,$stNo,$stName,$gender,$grade,$birthday,";
      $record2 = "$department,$myclub,$chinese,$english,$math \r\n";
      fputs($fp,$record1.$record2); //寫入輸入檔案class.txt
      fclose($fp);  //關閉檔案
      
      /*echo "<br><br>";
      $myfile = fopen("class.txt", "r") or die("Unable to open file!");
      echo fread($myfile, filesize("class.txt"));
      fclose($myfile);
      
      echo "<br><br>";
      $myfile = fopen("class.txt", "r") or die("Unable to open file!");
      echo fgets($myfile);
      fclose($myfile);
      
      echo "<br><br>";
      $myfile = fopen("class.txt", "r") or die("Unable to open file!");
      while(!feof($myfile)){
        echo fgets($myfile) . "<br>";
        } 
      
      
      fclose($myfile);
    }*/
           
  //PHP程式結束
?>
</body>