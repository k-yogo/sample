<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <style type="text/css">
    div.hide_content{display:none;}
  </style>
  <title>mysqlInsert.php</title>
</head>
<body>
<?php
  try{
    $pdo = new PDO('mysql:dbname=test; host=localhost; charset=utf8', 'root');
    $st = $pdo->prepare("create table if not exists information_table (time datetime not null, no int(100) not null auto_increment PRIMARY KEY, name varchar(100) CHARACTER SET utf8 not null, content varchar(1000) CHARACTER SET utf8 not null);");
    $st->execute();
  }catch(PDOException $e){
    die($e->getMessage());  
  }
  if (!empty($_POST['clear'])) {
    $st = $pdo->prepare("DELETE from information_table");
    $st->execute();
  }elseif (!empty($_POST['drop'])) {
    $st = $pdo->prepare("drop table information_table");
    $st->execute();
    header('Location: http://localhost/test/mysqlInsert.php');
    exit;
  }elseif (!empty($_POST['name']) && preg_match("/^.{0,10}$/u", $_POST['name']) && !empty($_POST['content']) ) {
    $st = $pdo->prepare("INSERT INTO information_table VALUES(NOW(),?,?,?)");
    $st->execute(array(NULL, $_POST['name'], $_POST['content']));
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
  }elseif (isset($_POST['name']) || isset($_POST['content'])) {
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
  }
  $st = $pdo->query("SELECT * FROM information_table");
?>
<form action="" method="post" name="formA">
  <table>
    <tr><td>情報追加</td></tr>
    <tr>
      <td align="right">名前(10文字以下)</td>
      <td><input type="text" name="name"></td>
    </tr>
    <tr>
      <td align="right">本文</td>
      <td><textarea name="content"></textarea></td>
    </tr>
    <tr>
      <td>
        <input type="submit">
      </td>
    </tr>
  </table>
  <input type="hidden" name="clear" value="">
  <input type="hidden" name="drop" value="">
</form>
<table border="1">
<tr bgcolor='##ccffcc'><th>time</th><th>no</th><th>name</th><th>content</th></tr>
<?php
  while ($row = $st->fetch()) {
    if(isset($row)){
      $no = htmlspecialchars($row['no']);
      $name = htmlspecialchars($row['name']);
      $pre_content = htmlspecialchars($row['content']);
      $second_content = "";
      if (mb_strlen($pre_content, "UTF-8") > 20) {
        for ($i=0, $x = mb_strlen($pre_content, "UTF-8"); $x > 0; $i++) { 
          if ($x > 20) {
            $second_content .= mb_substr($pre_content, 20+(20*$i), 20, "UTF-8")."<br>";
          }else{
            $second_content .= mb_substr($pre_content, 20+(20*$i), $x, "UTF-8");
          }
          $x = $x-20;
        }
      $first_content = mb_substr($pre_content, 0, 20, "UTF-8");
      $content = $first_content." <a href=\"javascript:open('".$no."','".$no."_A','".$no."_B');\" id='".$no."_A'>▼</a><a href=\"javascript:close('".$no."','".$no."_A','".$no."_B');\" id='".$no."_B' style='display:none'>▲</a><div class='hide_content' id='".$no."'>".$second_content."</div>";
      }else{
        $content = $pre_content;
      }
      $date = date("Y/m/d H:i:s", strtotime($row['time']));
      echo "<tr><td>$date</td><td>$no</td><td>$name</td><td>".$content. "</td></tr>";
    }
  }
  ?>
  </table>
<a href='' onclick='dataClear(); return false;'>データ全削除</a>
<a href='' onclick='tableClear(); return false;'>テーブル削除</a>
<script>
  function dataClear(){
    document.getElementsByName('clear').item(0).value = "clear";
    document.getElementsByName('name').item(0).value = "";
    document.formA.submit();
  }
  function tableClear(){
    document.getElementsByName('drop').item(0).value = "drop";
    document.getElementsByName('name').item(0).value = "";
    document.formA.submit();
  }
  function open(id1,id2,id3){ 
    document.getElementById(id1).style.display = "block";
    document.getElementById(id2).style.display = "none";
    document.getElementById(id3).style.display = "inline";
  }
  function close(id1,id2,id3){
    document.getElementById(id1).style.display = "none";
    document.getElementById(id2).style.display = "inline";
    document.getElementById(id3).style.display = "none";
  }
</script>
</body>
</html>