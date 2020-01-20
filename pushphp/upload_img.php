<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "이미 존재하는 파일 입니다.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "파일의 크기가 큽니다. 파일의 크기를 다시 확인해 주세요.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "파일의 형식을 다시 확인해 주세요.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "업로드 실패";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

		$filename = $_FILES["fileToUpload"]["name"];
		$imgurl = "https://nobles1030.cafe24.com/uploads/". $_FILES["fileToUpload"]["name"];
		$size = $_FILES["fileToUpload"]["size"];

		$conn = mysqli_connect("localhost", "nobles1030", "hero!0628", "nobles1030");
		//images 테이블에 이미지정보를 저장
		$sql = "insert into images(filename, imgurl, size) values('$filename','$imgurl','$size')";
		mysqli_query($conn,$sql);
		mysqli_close($conn);

    echo "<p>The file ". basename( $_FILES["fileToUpload"]["name"]). " 를 업로드 했습니다.</p>";
		echo "<br><img src=/uploads/". basename( $_FILES["fileToUpload"]["name"]). " width=300 height=150>";
		echo "<br><button type='button' onclick='window.close()'>완료</button>";
    }
    else {
    echo "<p>업로드 실패...서버상태를 확인하세요</p>";
		echo "<br><button type='button' onclick='history.back()'>돌아가기</button>";
    }
}
?>
