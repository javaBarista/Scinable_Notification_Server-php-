<?php
function send_notification_android ($tokens, $data){
	$url = 'https://fcm.googleapis.com/fcm/send';
	//어떤 형태의 data/notification payload를 사용할것인지에 따라 폰에서 알림의 방식이 달라 질 수 있다.
	$msg = array(
		'title'	=> $data["title"],
		'body' 	=> $data["body"],
		'imgurl' => $data["imgurl"],
		'iconurl' => $data["iconurl"],
		'campaign' => 'hiroCampaign',
		'channel' => '20166439'
	);

	$fields = array(
		'registration_ids'		=> $tokens,
		'data'	=> $msg
	);

	$headers = array(
		'Authorization:key =' . "AAAAXLTJ8Hc:APA91bEXKy5baW3qHGP-r0FC5w79KUwgaeUvSjJWrjTpgwtb1crfZmXdSat4-zDMGdDwoSArZvhef-GENAubDQySG7fCl6xC8LqLZGdXzzTAgP3ZT5zyFEduDAZct55puE7U6ZgqoBvH",
		'Content-Type: application/json'
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, ($url));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	$result = curl_exec($ch);
	if ($result === FALSE) {
		die('Curl failed: ' . curl_error($ch));
	}
	curl_close($ch);
	return $result;
}

function send_notification_iOS ($tokens, $data){

	$url = 'https://fcm.googleapis.com/fcm/send';
	//어떤 형태의 data/notification payload를 사용할것인지에 따라 폰에서 알림의 방식이 달라 질 수 있다.

	$msg = array(
		'title'	=> $data["title"],
		'body' 	=> $data["body"],
		'sound' => 'default',
		'badge' => '1',
		'category' => 'CustomSamplePush'
	);

	$datas = array(
		'image_url' => $data["imgurl"]
	);

	$fields = array(
		'registration_ids'		=> $tokens,
		'notification'	=> $msg,
		'content_available' => true,
		'mutable_content' => true,
		'priority'=>'high',
		'data' => $datas
	);

	$headers = array(
		'Authorization:key =' . "AAAAXLTJ8Hc:APA91bEXKy5baW3qHGP-r0FC5w79KUwgaeUvSjJWrjTpgwtb1crfZmXdSat4-zDMGdDwoSArZvhef-GENAubDQySG7fCl6xC8LqLZGdXzzTAgP3ZT5zyFEduDAZct55puE7U6ZgqoBvH",
		'Content-Type: application/json'
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, ($url));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	$result = curl_exec($ch);
	if ($result === FALSE) {
		die('Curl failed: ' . curl_error($ch));
	}
	curl_close($ch);
	return $result;
}

function send_pushStorage($data){
	$conn = mysqli_connect("localhost", "nobles1030", "hero!0628", "nobles1030");

	$sql = "SELECT * FROM FCMSERVER";
	$result = mysqli_query($conn,$sql);
  $today = date("Y/m/d");

	if(mysqli_num_rows($result) > 0 ){
		while($row = mysqli_fetch_assoc($result)){
			$db_sql = "INSERT INTO PushStorage(userID, title, body, imgUrl, receivedDate, userUrl) values('".$row["id"]."', '".$data["title"]."', '".$data["body"]."', '".$data["imgurl"]."', '".$today."', '".$data["userurl"]."');";
			mysqli_query($conn, $db_sql);
		}
	}

	mysqli_close($conn);
}

//데이터베이스 저장된 토큰을 array변수에 모두 담는다.
$conn = mysqli_connect("localhost", "nobles1030", "hero!0628", "nobles1030");

$sql = "SELECT * FROM FCMSERVER";

$result = mysqli_query($conn,$sql);
$androidTokens = array();
$iOSTokens = array();

if(mysqli_num_rows($result) > 0 ){
	//DB에서 가져온 토큰을 모두 $tokens에 담아 둔다.
	while ($row = mysqli_fetch_assoc($result)) {
		if($row["Platform"] == iOS){
			$iOSTokens[] = $row["Token"];
		}
		else{
			$androidTokens[] = $row["Token"];
		}
	}
}
mysqli_close($conn);

//관리자페이지 폼에서 입력한 내용들을 가져와 정리한다.
$mTitle = $_POST['title'];
$mMessage = $_POST['message'];
if($_POST['chk_info'] != 'nouse'){
	$IconUrl = $_POST['imgurl']; //폼에서 image url link를 받음
	if($_POST['chk_info'] == 'bothuse'){
		$ImgUrl = $_POST['imgurl']; //폼에서 image url link를 받음
	}
}
$userUrl = $_POST['userurl'];
//알림할 내용들을 취합해서 $data에 모두 담는다.
$inputData = array("title" => $mTitle, "body" => $mMessage, "imgurl" => $ImgUrl, "iconurl" => $IconUrl, 'userurl' => $userUrl);

//마지막에 알림을 보내는 함수를 실행하고 그 결과를 화면에 출력해 준다.
$result1 = send_notification_iOS($iOSTokens, $inputData);
$result2 = send_notification_android($androidTokens, $inputData);
send_pushStorage($inputData);
echo 'android: '.$result2.'<br>';
echo 'iOS: '.$result1;

echo '
<br><br>
<button><a href="/fcmindex.php">돌아가기</a></button>
';

?>
