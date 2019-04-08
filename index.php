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
 // Thống Kê Like Bài Viết
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
if(isset($accessToken)){ 
// Thống kê mem
$tkmem = 'https://graph.facebook.com/v2.10/'.$groupid.'/members?summary=total_count&access_token='.$accessToken;
$mem = json_decode(file_get_contents($tkmem));
$memtk = $mem->summary->total_count;
?>
<div class="row">
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-block">
                                    <div class="clearfix">
                                        <i class="fa fa-user-o float-right icon-grey-big"></i>
                                    </div>
                                    <h4 class="card-title font-weight-normal text-success"><?php echo $memtk;?></h4>
                                    <h6 class="card-subtitle mb-4">Member Groups</h6>
                                    <div class="progress">
                                        <div class="progress-bar bg-success-gadient progress-slim" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-block">
                                    <div class="clearfix">
                                        <i class="fa fa-user-o float-right icon-grey-big"></i>
                                    </div>
                                    <h4 class="card-title font-weight-normal text-success">210313</h4>
                                    <h6 class="card-subtitle mb-4">Visitors</h6>
                                    <div class="progress">
                                        <div class="progress-bar bg-success-gadient progress-slim" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-block">
                                    <div class="clearfix">
                                        <i class="fa fa-user-o float-right icon-grey-big"></i>
                                    </div>
                                    <h4 class="card-title font-weight-normal text-success">45465</h4>
                                    <h6 class="card-subtitle mb-4">Visitors</h6>
                                    <div class="progress">
                                        <div class="progress-bar bg-success-gadient progress-slim" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
<?php 
} 
require('inc/end.php');
?>
