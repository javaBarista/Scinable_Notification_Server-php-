<?php
$conn = mysqli_connect("localhost", "nobles1030", "hero!0628", "nobles1030");

$userID = $_POST['userID'];

$sql = "SELECT pushNum, title, body, imgUrl, receivedDate, chkread, userUrl FROM PushStorage WHERE userID = '".$userID."' ORDER BY pushNum DESC;";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_assoc($result)){
    $arr[] = $row;
  }
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
mysql_free_result($result);

mysqli_close($conn);
?>
