<?php
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
	if(isset($_POST['showpopup']) && !empty($_POST['showpopup'])){
		$postID = $_POST['showpopup'];
		$user_id = @$_SESSION['user_id'];
		$post = $getFromP->getPopupPost($postID);
		$user = $getFromU->userData($user_id);
		$likes = $getFromP->likes($user_id, $postID);
		if(is_bool($likes)){
				$likes = array();
				$likes['likeOn'] = -1;
			}
		$repost = $getFromP->checkRepost($postID, $user_id);
		if(is_bool($repost)){
				$repost = array();
				$repost['repostID'] = -1;
			}
		$comments = $getFromP->comments($postID);

		?> 
		<div class="post-show-popup-wrap">
			<input type="checkbox" id="post-show-popup-wrap">
			<div class="wrap4">
				<label for="post-show-popup-wrap">
					<div class="post-show-popup-box-cut">
						<i class="fa fa-times" aria-hidden="true"></i>
					</div>
				</label>
				<div class="post-show-popup-box">
				<div class="post-show-popup-inner">
					<div class="post-show-popup-head">
						<div class="post-show-popup-head-left">
							<div class="post-show-popup-img">
								<img src="<?php echo BASE_URL.$user->profileImage;?>"/>
							</div>
							<div class="post-show-popup-name">
								<div class="t-s-p-n">
									<a href="<?php echo BASE_URL.$post->username; ?>">
										<?php echo $post->screenName; ?>
									</a>
								</div>
								<div class="t-s-p-n-b">
									<a href="<?php echo BASE_URL.$post->username; ?>">
										@<?php echo $post->username; ?>
									</a>
								</div>
							</div>
						</div>
						<div class="post-show-popup-head-right">
							  <button class="f-btn"><i class="fa fa-user-plus"></i> Follow </button>
						</div>
					</div>
					<div class="post-show-popup-post-wrap">
						<div class="post-show-popup-post">
							<?php echo $getFromP->getPostLinks($post->status); ?>
						</div>
						<div class="post-show-popup-post-ifram">
						<?php if (!empty($post->postimage)) { ?>
			  			    <img src="<?php echo BASE_URL.$post->postimage;?>"/> 

			  			 <?php } ?>
						</div>
					</div>
					<div class="post-show-popup-footer-wrap">
						<div class="post-show-popup-repost-like">
							<div class="post-show-popup-repost-left">
								<div class="post-repost-count-wrap">
									<div class="post-repost-count-head">
										REPOST
									</div>
									<div class="post-repost-count-body">
										<?php echo $post->repostCount; ?>
									</div>
								</div>
								<div class="post-like-count-wrap">
									<div class="post-like-count-head">
										LIKES
									</div>
									<div class="post-like-count-body">
										<?php echo $post->likesCount; ?>
									</div>
								</div>
							</div>
							<div class="post-show-popup-repost-right">
							 
							</div>
						</div>
						<div class="post-show-popup-time">
							<span><?php echo $post->postedOn; ?></span>
						</div>
						<div class="post-show-popup-footer-menu">
							<ul>
								<?php if($getFromU->loggedIn() === true){
									echo '<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>
												<li>'.(($post->postID === $repost['repostID']) ? '<button class="reposted" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="repostsCount">'.$post->repostCount.'</span></button>' : '<button class="repost" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="repostsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>' ).'</li>
												<li>'.(($likes['likeOn'] === $post->postID) ? '<button class="unlike-btn" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a><span class="likesCounter">'.$post->likesCount.'</span></button>' : '<button class="like-btn" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>').'</li>
													'.(($post->postBy === $user_id) ? '
													<li>
													<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
													<ul>
													  <li><label class="deletePost" data-post = "'.$post->postID.'">Delete Post</label></li>
													</ul>
											</li>' : '');
								}else {
								?>
								<li><button type="buttton"><i class="fa fa-share" aria-hidden="true"></i></button></li>
								<li><button type="button"><i class="fa fa-repost" aria-hidden="true"></i><span class="repostsCount">REPOST-COUNT</span></button></li>
								<li><button type="button"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCount">LIKES-COUNT</span></button></button></li>
								<?php } ?>
									</ul>	
								</li>
							</ul>
						</div>
					</div>
				</div><!--post-show-popup-inner end-->
			 	<?php if ($getFromU->loggedIn() === true) { ?>
			 	<div class="post-show-popup-footer-input-wrap">
					<div class="post-show-popup-footer-input-inner">
						<div class="post-show-popup-footer-input-left">
							<img src="<?php echo BASE_URL.$user->profileImage; ?>"/>
						</div>
						<div class="post-show-popup-footer-input-right">
							<input id="commentField" type="text" data-post="<?php echo $post->postID; ?>" name="comment"  placeholder="Reply to @<?php echo $post->username; ?>">
						</div>
					</div>
					<div class="post-footer">
					 	<div class="t-fo-left">
					 		<ul>
					 			<li>
					 				<!-- <label for="t-show-file"><i class="fa fa-camera" aria-hidden="true"></i></label>
					 				<input type="file" id="t-show-file"> -->
					 			</li>
					 			<li class="error-li">
							    </li> 
					 		</ul>
					 	</div>
					 	<div class="t-fo-right">
			 		 		<input type="submit" id="postComment" value="Post">
			 		 		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
			 		 		
					 	</div>
					 </div>
				</div><!--post-show-popup-footer-input-wrap end-->
			<?php } ?>
			<div class="post-show-popup-comment-wrap">
				<div id="comments">
				 	<?php 
				 		foreach ($comments as $comment) {
				 			echo '
				 			<div class="post-show-popup-comment-box">
								<div class="post-show-popup-comment-inner">
									<div class="post-show-popup-comment-head">
										<div class="post-show-popup-comment-head-left">
											 <div class="post-show-popup-comment-img">
											 	<img src="'.BASE_URL.$comment->profileImage.'">
											 </div>
										</div>
										<div class="post-show-popup-comment-head-right">
											  <div class="post-show-popup-comment-name-box">
											 	<div class="post-show-popup-comment-name-box-name"> 
											 		<a href="'.BASE_URL.$comment->username.'">'.$comment->screenName.'</a>
											 	</div>
											 	<div class="post-show-popup-comment-name-box-tname">
											 		<a href="'.BASE_URL.$comment->username.'">@'.$comment->username.' - '.$comment->commentAt.'</a>
											 	</div>
											 </div>
											 <div class="post-show-popup-comment-right-post">
											 		<p><a href="'.BASE_URL.$post->username.'">@'.$post->username.'</a> '.$comment->comment.'</p>
											 </div>
										 	<div class="post-show-popup-footer-menu">
												<ul>
													<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
													<li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>
													'.(($comment->commentBy === $user_id)? '
													<li>
													<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
													<ul> 
													  <li><label class="deleteComment" data-post="'.$post->postID.'" data-comment="'.$comment->commentID.'">Delete Comment</label></li>
													</ul>
													</li>' : '').'
												</ul>
											</div>
										</div>
									</div>
								</div>
								<!--POST SHOW POPUP COMMENT inner END-->
							</div>';
				 		}
				 	?>
				</div>

			</div>
			<!--post-show-popup-box ends-->
			</div>
		</div>

		<?php 
	}
?>