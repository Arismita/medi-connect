<?php
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
	if(isset($_POST['deletePost']) && !empty($_POST['deletePost'])){
		$post_id = $_POST['deletePost'];
		$user_id = $_SESSION['user_id'];
		$getFromP->delete('posts', array('postID' => $post_id, 'postBy' => $user_id));
	}
	if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])){
		$post_id = $_POST['showPopup'];
		$user_id = $_SESSION['user_id'];
		$post = $getFromP->getPopupPost($post_id);
		?>
		<div class="repost-popup">
		  <div class="wrap5">
		    <div class="repost-popup-body-wrap">
		      <div class="repost-popup-heading">
		        <h3>Are you sure you want to delete this Post?</h3>
		        <span><button class="close-repost-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
		      </div>
		       <div class="repost-popup-inner-body">
		        <div class="repost-popup-inner-body-inner">
		          <div class="repost-popup-comment-wrap">
		             <div class="repost-popup-comment-head">
		              <img src="<?php echo BASE_URL.$post->profileImage;?>"/>
		             </div>
		             <div class="repost-popup-comment-right-wrap">
		               <div class="repost-popup-comment-headline">
		                <a><?php echo $post->screenName;?></a><span>@<?php echo $post->username.' '.$post->postedOn;?></span>
		               </div>
		               <div class="repost-popup-comment-body">
		                <?php echo $post->status.' '.$post->postimage;?> 
		               </div>
		             </div>
		          </div>
		         </div>
		      </div>
		      <div class="repost-popup-footer"> 
		        <div class="repost-popup-footer-right">
		          <button class="cancel-it f-btn">Cancel</button><button class="delete-it" type="submit">Delete</button>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>
		<?php
	}
?>