# Scinable_Notification_Server-php-
  
> 푸시 전송을위한 Notification Server  
  
Php를 이용하여 푸시전송을 위한 서버기능 구축, 사이트에서 본문과 제목을 작성하고 이미지 사용 여부를 체크하여 푸시전송  
이때 서버DB에서 필요한 토큰값과 플랫폼정보를 가져와 해당 플랫폼에맞게 분기하여 payload 방식을 선택 후 전송  

<img src="https://user-images.githubusercontent.com/48575996/72696479-a8607300-3b7f-11ea-8308-190ad21d32d5.png" width="90%"></img>(http://nobles1030.cafe24.com/fcmindex.php)

## 사용 방법

#### 원하는 이미지를 업로드 후 본문과 제목을 작성하여 전송하세요.  

## 개발 환경 및 구현방법 

* ATOM을 이용하여 php작성  
* 이미지 클릭시 URL 부분은 자동으로 해당 이미지의 URL 입력  
* DB에 이미지를 바로 저장하는 방식이 아닌 서버에 이미지 저장 후 DB에는 해당 URL을 저장  
* 라디오 버튼으로 버튼을 구현하여 긴 본문과 이밎가 함께 선택이 안되도록 구현 -> 이미지를 전송하면 긴 텍스트는 받을 수 없기 때문 
*Xampp와 ngrok을 이용해 서버를 사용하다 편의를 위해 cafe24 hosting 서비스 이용* 
