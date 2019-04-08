<?php
 /* 
 --------------------------------------
 -- Tên Code : Code Link Protect Facebook Page
 -- Người Coder : Hậu Nguyễn 
 -- Sử Dụng : PHP 7 & PDO 
 -- Vui Lòng Tôn Trọng Bản Quyền 
 --------------------------------------
 */
define('Hadpro', 1);
require('inc/head.php');
require('inc/PseudoCrypt.php');
if(!isset($accessToken)){
   echo '<div class="row">
          <div class="card col-md-12">
            <div class="card-block">
              <h3 class="card-title text-primary text-left mb-5 mt-4">Link Protect Lock</h3>
              <form>
                <div class="text-center">
				    <a href="'.$loginUrl.'" id="btn-ketnoi" class="btn btn-primary btn-round"> <i class="fa fa-facebook-square"></i>  Login</a>
                </div><br />
				 <div class="form-group">
                     Lưu ý: Nếu là lần đầu tiên sử dụng Ứng dụng sẽ yêu cầu quyền lấy thông tin cá nhận <strong>Công khai</strong> của bạn. Ứng dụng chỉ lấy những thông tin mà bạn công khai như <strong>Tên</strong> và <strong>ID</strong> để xác nhận. Ngoài ra <strong>không lấy bất cứ quyền nào</strong>, không lưu cookie hay token.</p>
              </div>
              </form>
            </div>
          </div>
      </div>';	
	  exit;
}
?>
<div class="row">
          <div class="card col-md-12">
            <div class="card-block">
<h5 class="card-title text-primary text-left mb-5 mt-4">Tạo Link Khóa</h5>
        <form action="" method="POST">
         <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-unlink"></i></span>
                    <input type="link" class="form-control p_input" id="link" name="link" placeholder="Link cần giấu">
                  </div>
                </div>
	     <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                    <input type="password" class="form-control p_input" id="pass" name="pass" placeholder="Pass Mở Link | Có Thể Để Trống">
                  </div>
                </div>
				<div class="text-center">
                  <button name="submit" type="submit" class="btn btn-success">Tạo Link</button>
                </div>
<br />

</form>
</div></div></div>
<?php 
	 if(isset($_POST['submit'])){

			function userID($Token){
				$ProfileApi = 'https://graph.facebook.com/me?access_token='.$Token;
				$user = json_decode(file_get_contents($ProfileApi, true));
				return $user->id;
			}

			$EncodeLink = PseudoCrypt::hash(time(), 10);
			$LockedLink = ''.$url.'/x/'.$EncodeLink;
			$HashLink = '#protect@'.$EncodeLink.'@';

			$longUrl = $LockedLink;
			$apiKey  = $GoogleApiKey;

			$postData = array('longUrl' => $longUrl);
			$jsonData = json_encode($postData);

			$curlObj = curl_init();

			curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
			curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curlObj, CURLOPT_HEADER, 0);
			curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
			curl_setopt($curlObj, CURLOPT_POST, 1);
			curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

			$reply = curl_exec($curlObj);

			$json = json_decode($reply);

			curl_close($curlObj);

			if(isset($json->error)){
			echo $json->error->message;
			}else{
				$GoogleShortUrl = $json->id;
			}
			 $password = isset($_POST['pass']) ? md5($_POST['pass']) : '';
			 if (empty($password)) {
				 $pass = 'anlink';
			 } else {
				 $pass = isset($_POST['pass']) ? md5($_POST['pass']) : '';
			 }
			 
			 $db->prepare('
                  INSERT INTO `link` SET
                  `FBID` = ?,
                  `PostID` = \'0\',
                  `Hash` = ?,
				  `Password` = ?,
				  `Url` = ?,
				  `SUrl` = ?,
				  `Time` = ?
                ')->execute([
                    userID($_SESSION['facebook_access_token']),
                    $EncodeLink,
                    $pass,
					$_POST['link'],
					$GoogleShortUrl,
					date("Y-m-d H:i:s"),
                ]);
		echo '<div class="row">
          <div class="card col-md-12">
            <div class="card-block">
              <h5 class="card-title mb-4">Link Khóa Hash</h5>
         <strong>*Lưu ý:</strong><br>
           - Khi post bài trong Group bạn phải kèm theo <span class="label label-danger">Hash của bài viết</span> Có thể để ở bất cứ đâu trong bài viết để tool có thể tự cập nhật link bài viết cho bạn.<br>
           - Nếu link bài viết không được cập nhật thì ngoài chức năng khóa mật khẩu các chức năng khác sẽ không hoạt động.
           </div>
           <br/>
		      <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-unlink"></i></span>
                    <input type="link" id="linktonghop" class="form-control p_input" value="'.$GoogleShortUrl.' | '.$HashLink.'">
                  </div>
                </div>      
        </div></div></div>';
			}