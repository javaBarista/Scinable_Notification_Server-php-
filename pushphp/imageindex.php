<!doctype html>
<html lang="ko">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>이미지 파일 등록</title>
 </head>
 <body>
	<div align=center border-collapse>
		<h3>이미지 파일 업로드</h3>

		<form action="upload_img.php" method="post" enctype="multipart/form-data">
			<div>
				<input type="file" name="fileToUpload" id="fileToUpload">
			</div>
			<input type="submit" value="업로드" name="submit" style="margin: .9em">
		</form>
	</div>

	<!-- database에서 이미지 목록을 가져 온다. -->
	<ul>
<?php
	$conn = mysqli_connect("localhost", "nobles1030", "hero!0628", "nobles1030");
	if(mysqli_connect_errno()){
		echo "연결실패! ".mysqli_connect_error();
	}
	$query = "SELECT * FROM images";
	$result = mysqli_query($conn, $query);

	while($data = mysqli_fetch_array($result)){

		echo '<li style=\'float:left; margin: 2px;\'>';
		echo '<img src='.$data['imgurl'].' width=200 height=100><br>';
		echo ($data['filename']);
		echo '</li>';
	}

   mysqli_close($conn);
?>

	</ul>

 </body>
</html>
