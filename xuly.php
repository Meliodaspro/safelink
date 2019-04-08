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
if(isset($accessToken)){
$sHash = $_GET['x'];
$CheckHash = $db->query("SELECT * FROM `link` WHERE `Hash` = '$sHash'");
$wap = $CheckHash->fetch();
// Hàm Kiểm Tra Mật Khẩu
	if(isset($wap['Password'])){
		if($wap['Password'] !== ""){
			$PasswordLocked = true;
			if(isset($_POST['password'])){
				if(md5($_POST['password']) == $wap['Password']){
					unset($PasswordLocked);
				}
			} else {
				$Password = null;
			}
		}
	}
function userID($Token){
  global $userID, $userName;
	$ProfileApi = 'https://graph.facebook.com/me?access_token='.$Token;
	$user = json_decode(file_get_contents($ProfileApi, true));
	$userID = $user->id;
  $userName = $user->name;
}
function Group($groupid, $Token, $Hashtag, $PostID, $userID){
	global $FoundPost, $FoundPostID, $FoundPostURL, $Nguoitao, $TKLike, $TKBL, $Liked, $Mem, $Comments;
	//Feed (timeline) data
	$FeedApi = 'https://graph.facebook.com/'.$groupid.'/feed?limit=100&access_token='.$Token;
	$FeedJson = json_decode(file_get_contents($FeedApi), true);

	if(is_array($FeedJson) or is_object($FeedJson)){
		foreach($FeedJson['data'] as &$feed) {
			if(strpos(@$feed['message'], $Hashtag) !== FALSE) {
				$FoundPost = true;
				$FoundPostID = str_replace($groupid.'_', '',$feed['id']);

				// Kiểm Tra Thông Tin Bài Viết
				$PostApi = 'https://graph.facebook.com/v2.11/'.$groupid.'_'.$FoundPostID.'?fields=id,permalink_url,message&access_token='.$Token;
				$PostPage = json_decode(file_get_contents($PostApi));
				$FoundPostURL = $PostPage->permalink_url;
				
				// Người Tạo Bài Viết
				$userapi = 'https://graph.facebook.com/v2.11/'.$groupid.'_'.$FoundPostID.'?fields=from&access_token='.$Token;
				$Postuser = json_decode(file_get_contents($userapi));
				$Nguoitao = $Postuser->from->name;
				// Thống Kê Like Bài Viết
				 $demlike = 'https://graph.facebook.com/v2.11/'.$groupid.'_'.$FoundPostID.'/likes?summary=total_count&access_token='.$Token;
		         $timdl = json_decode(file_get_contents($demlike));
	             $TKLike = $timdl->summary->total_count;
				 // Thống Kê Bình Luận Bài Viết
				 $dembl = 'https://graph.facebook.com/v2.11/'.$groupid.'_'.$FoundPostID.'/comments?summary=total_count&access_token='.$Token;
		         $timbl = json_decode(file_get_contents($dembl));
	             $TKBL = $timbl->summary->total_count;
               //Kiểm Tra Thành Viên Nhóm
		         $MemberApi = 'https://graph.facebook.com/v2.11/'.$groupid.'/members?limit=5000&access_token='.$Token;
		         $FindMem = json_decode(file_get_contents($MemberApi));
		          foreach($FindMem->data as $member){
	              if($member->id == $userID){
	                  $Mem = true;
	    	           }
		            }
				// Kiểm Tra Cảm Xúc Bài Viết
				$LikeApi = 'https://graph.facebook.com/v2.11/'.$groupid.'_'.$FoundPostID.'/reactions?fields=id&pretty=0&live_filter=no_filter&limit=5000&access_token='.$Token;
				$FindLike = json_decode(file_get_contents($LikeApi));
				foreach($FindLike->data as $like){
				if($like->id == $userID){
					$Liked = true;
					}
				}
				//Tìm Bình Luận Thành Viên
		        $CmtApi = 'https://graph.facebook.com/v2.11/'.$groupid.'_'.$FoundPostID.'/comments?limit=5000&access_token='.$Token;
		        $CmtApi_decode = json_decode(file_get_contents($CmtApi));
		        foreach($CmtApi_decode->data as $cmt){
	            if($cmt->from->id == $userID){
	                  $Comments = true;
	    	        }
		        }
			}
		}
	}
}

userID($accessToken);
Group($groupid, $accessToken, $wap['Hash'], $wap['PostID'], $userID);

if($FoundPost == true && $PostID == 0){
	$db->exec("UPDATE `link` SET `PostID` = '$FoundPostID' WHERE `Hash` = '$sHash'");
}
} 

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
<?php if(isset($Mem) && isset($Comments) && isset($Liked) && empty($PasswordLocked)){ ?>
 <div class="row mb-4">
    <div class="col-md-12">
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="card-title mb-4">UnLock Protect Link</h5><hr>
									<p class="text-center text-danger"> Link Bài Viết Đã Được Mở Khóa Cảm Ơn Bạn</p>
									<i class="fa fa-link fa-spin" aria-hidden="true"></i> Link Khóa : <center><a class="text-info" href="<?php echo $wap['Url'] ?>"><?php echo $wap['Url'] ?></a></center>
                                </div>
                            </div>
                        </div>
</div>
<?php }  ?>
 <div class="row">
    <div class="col-md-4">
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="card-title mb-4">Thành Viên Đăng Bài</h5><hr>
                                    <div class="text-center">
                                        <img src="https://graph.facebook.com/<?php echo $wap['FBID'] ?>/picture?type=large&redirect=true&width=82&height=82" alt="<?php echo $Nguoitao; ?>" class="rounded-circle" width="100" height="100" />
                                    </div><br />
                                    <p class="card-text">Người Gửi : <a href="https://facebook.com/<?php echo $wap['FBID'] ?>" target="_blanks"><b><?php echo $Nguoitao; ?></b></a></p>
                                    <hr><p class="card-text">ID : <b><?php echo $wap['FBID'] ?></b></p>
                                </div>
                            </div>
                        </div>
						
	<div class="col-md-8">
                            <div class="card">
                                <div class="card-block">
                                    <h5 class="card-title mb-4">Thông Tin Chung</h5><hr>
                                    <h6 class="card-title mb-4">Link Protect</h6>
									<p class="text-center"><a class="text-info" href="<?php echo ($FoundPostURL !== null) ? $FoundPostURL : '#';?>"><?php echo ($FoundPostURL !== null) ? $FoundPostURL : 'Link khóa này chưa được cập nhật link bài viết trong Group';?></a></p>
<hr >
<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-6">
                            <div class="card">
                                <div class="card-block">
                                    <h4 class="card-title font-weight-normal text-danger"><?php echo ''.$TKLike.'';?></h4>
                                    <p class="card-text"><i class="fa fa-heart" aria-hidden="true"></i> Lượt Thích Bài Viết</p>
                                </div>
                            </div>
                        </div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-6">
                            <div class="card">
                                <div class="card-block">
                                    <h4 class="card-title font-weight-normal text-danger"><?php echo ''.$TKBL.'';?></h4>
                                    <p class="card-text"><i class="fa fa-comments" aria-hidden="true"></i> Lượt Bình Luận Bài Viết</p>
                                </div>
                            </div>
                        </div>
						</div><hr>
<h6 class="card-title mb-4">UnLock Protect</h6>
<?php 
if($Mem == true) { 
echo '<p class="text-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Xác Nhận Thành Viên Thành Công</p>'; } else { echo '<p class="text-danger"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Bạn Không Phải Là Thành Viên Của Nhóm Hãy Tham Gia Nhóm !</p>'; }
if($Comments == true) { 
echo '<p class="text-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Bạn Đã Bình Luận Bài Viết Này</p>'; } else { echo '<p class="text-danger"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Bạn Chưa Bình Luận Bài Viết Này !</p>'; }
if($Liked == true) {
echo '<p class="text-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Bạn đã thích bài viết của liên kết này</p>'; } else { echo '<p class="text-danger"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Bạn chưa thích bài viết của liên kết này</p>'; }
if(empty($PasswordLocked)) {
echo '<p class="text-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Khóa Mật Khẩu - OK</p>'; 
} else { 
echo '<p class="text-danger"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Liên kết này có mật khẩu, hãy điền mật khẩu để mở khóa</p>'; }

if(isset($PasswordLocked)){ ?>
<form action="" method="POST">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="text" name="password" class="form-control p_input" placeholder="Password"> &#160;<button type="submit" class="btn btn-primary">Mở Khóa</button>
                  </div>
                </div>
              </form>
                                </div>
                            </div>
                        </div>	
</div>
<?php
}
require('inc/end.php');
?>