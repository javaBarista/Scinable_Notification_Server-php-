<?php
$conn = mysqli_connect("localhost", "nobles1030", "hero!0628", "nobles1030");

if($conn){
    echo "접속 성공<br>";
}
else{
    echo "접속 실패<br>";
}

$id = $_POST['id'];
$token = $_POST['Token'];
$platform = $_POST['Platform'];

$db_sql = "INSERT INTO FCMSERVER(id, Token, Platform) values('".$id."', '".$token."', '".$platform."') ON DUPLICATE KEY UPDATE Token = '".$token."';";
mysqli_query($conn, $db_sql);

mysqli_close($conn);
?>
