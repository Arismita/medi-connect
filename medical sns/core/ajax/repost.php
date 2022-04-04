<?php
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
	$user_id = $_SESSION['user_id'];

	if(isset($_POST['repost']) && !empty($_POST['repost'])){
		$post_id = $_POST['repost'];
		$get_id = $_POST['user_id'];
		$comment = $getFromU->checkInput($_POST['comment']);
		$getFromP->repost($post_id, $user_id, $get_id, $comment);
	}

	if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])){
		$post_id = $_POST['showPopup'];
		$get_id = $_POST['user_id'];
		$post = $getFromP->getPopupPost($post_id);
		?>
		<div class="repost-popup">
			<div class="wrap5">
				<div class="repost-popup-body-wrap">
					<div class="repost-popup-heading">
						<h3>Repost this to followers?</h3>
						<span><button class="close-repost-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
					</div>
					<div class="repost-popup-input">
						<div class="repost-popup-input-inner">
							<input type="text" class="repostMsg" placeholder="Add a comment.."/>
						</div>
					</div>
					<div class="repost-popup-inner-body">
						<div class="repost-popup-inner-body-inner">
							<div class="repost-popup-comment-wrap">
								 <div class="repost-popup-comment-head">
								 	<img src="<?php echo BASE_URL.$post->profileImage;?>"/>
								 </div>
								 <div class="repost-popup-comment-right-wrap">
									 <div class="repost-popup-comment-headline">
									 	<a><?php echo $post->screenName;?>  </a><span>@<?php echo $post->username;?>  -  <?php echo $post->postedOn;?>  </span>
									 </div>
									 <div class="repost-popup-comment-body"> 
									 	 - <?php echo  $post->status;?>   -  <?php echo $post->postimage;?>
									 </div>
								 </div>
							</div>
						</div>
					</div>
					<div class="repost-popup-footer"> 
						<div class="repost-popup-footer-right">
							<button class="repost-it" type="submit"><i class="fa fa-repost" aria-hidden="true"></i>Repost</button>
						</div>
					</div>
				</div>
			</div>
		</div><!-- Repost PopUp ends-->
		<?php
	}
?>