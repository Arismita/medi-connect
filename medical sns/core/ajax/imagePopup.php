<?php
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
	if(isset($_POST['showImage']) && !empty($_POST['showImage'])){
		$post_id = $_POST['showImage'];
		$user_id = @$_SESSION['user_id'];
		$post = $getFromP->getPopupPost($post_id);
		$likes = $getFromP->likes($user_id, $post_id);
		if(is_bool($likes)){
				$likes = array();
				$likes['likeOn'] = -1;
			}
		$repost = $getFromP->checkRepost($post_id, $user_id);
		if(is_bool($repost)){
				$repost = array();
				$repost['repostID'] = -1;
			}
		?>

		<div class="img-popup">
		<div class="wrap6">
		<span class="colose">
			<button class="close-imagePopup"><i class="fa fa-times" aria-hidden="true"></i></button>
		</span>
		<div class="img-popup-wrap">
			<div class="img-popup-body">
				<img src="<?php echo BASE_URL.$post->postimage;?>"/>
			</div>
			<div class="img-popup-footer">
				<div class="img-popup-post-wrap">
					<div class="img-popup-post-wrap-inner">
						<div class="img-popup-post-left">
							<img src="<?php echo BASE_URL.$post->profileImage;?>"/>
						</div>
						<div class="img-popup-post-right">
							<div class="img-popup-post-right-headline">
								<a href="<?php echo BASE_URL.$post->username;?>"><?php echo $post->screenName;?></a><span>@<?php echo $post->username.' - '. $post->postedOn;?></span>
							</div>
							<div class="img-popup-post-right-body">
								<?php echo $getFromP->getPostLinks($post->status);?>
							</div>
						</div>
					</div>
				</div>
				<div class="img-popup-post-menu">
					<div class="img-popup-post-menu-inner">
					  	<ul> 
					  		<?php  if($getFromU->loggedIn() === true){ 
					  				echo '
					  				<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>
									<li>'.(($post->postID === $repost['repostID']) ? '<button class="reposted" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="repostsCount">'.$post->repostCount.'</span></button>' : '<button class="repost" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="repostsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>' ).'</li>
									<li>'.(($likes['likeOn'] === $post->postID) ? '<button class="unlike-btn" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a><span class="likesCounter">'.$post->likesCount.'</span></button>' : '<button class="like-btn" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>').'</li>
									'.(($post->postBy === $user_id) ? '
									<li><label for="img-popup-menu"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></label>
										<input id="img-popup-menu" type="checkbox"/>
										<div class="img-popup-footer-menu">
											<ul>
											  <li><label class="deletePost" data-post = "'.$post->postID.'">Delete Post</label></li>
											</ul>
										</div>
									</li>' : '');
					  				}else{
					  					echo '
					  					<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
										<li><button class="repost"><i class="fa fa-retweet" aria-hidden="true"></i><span class="repostsCount"></span></button></li>
										<li><button class="like-btn"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter"></span></button></li>'; 
					  				}
					  		?>
							
							
							
						</ul>
					</div>
				</div>
			</div>
		</div>
		</div>
		</div><!-- Image PopUp ends-->

		<?php
	}
?>