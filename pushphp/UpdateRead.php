<?php
$conn = mysqli_connect("localhost", "nobles1030", "hero!0628", "nobles1030");

if($conn){
  echo "접속 성공<br>";
}
else{
  echo "접속 실패<br>";
}

$pushNumList = $_POST['pushNumList'];
$pushNumArray = explode(" ",$pushNumList);

for($i = 0; $i < count($pushNumArray); $i++){
  $pushNum = $pushNumArray[$i];
  $db_sql = "UPDATE PushStorage SET chkread = '1' WHERE pushNum = '".$pushNum."';";
  mysqli_query($conn, $db_sql);
}


mysqli_close($conn);
 ?>
