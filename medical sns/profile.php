<?php
	if(isset($_GET['username']) === true && empty($_GET['username']) === false){
		include 'core/init.php';
		$username = $getFromU->checkInput($_GET['username']);
		$profileId = $getFromU->userIdByUsername($username);
		$profileData = $getFromU->userData($profileId);
		$user_id = @$_SESSION['user_id'];
		$user = $getFromU->userData($user_id);
		$notify = $getFromM->getNotificationCount($user_id);

		if(!$profileData){
			header('Location: '.BASE_URL.'index.php');
		}
	}
?>


<!doctype html>
<html>
	<head>
		<title><?php echo $profileData->screenName.' (@'.$profileData->username.')'; ?></title>
		<meta charset="UTF-8" />
 		<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-sheet.css"/>
   		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>  
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  	  

    </head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">	
	<div class="nav-container">
    	<div class="nav">
		<div class="nav-left">
			<ul>
				<li><a href="<?php echo BASE_URL;?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<?php if($getFromU->loggedIn() === true){ ?>
				<li><a href="<?php echo BASE_URL;?>i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification<span id="notification"><?php if($notify->totalN > 0){echo '<span class="span-i">'.$notify->totalN.'</span>';}?></span></a></li>
				<li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages<span id="messages"><?php if($notify->totalM > 0){echo '<span class="span-i">'.$notify->totalM.'</span>';} ?></span></li>
			<?php } ?>
				 
			</ul>
		</div><!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result"> 			
					</div>
				</li>

				<?php if($getFromU->loggedIn() === true){ ?>
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$user->profileImage;?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL.$user->username;?>"><?php echo $user->username;?></a></li>
							<li><a href="<?php echo BASE_URL;?>settings/account">Settings</a></li>
							<li><a href="<?php echo BASE_URL;?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-post" class="addPostBtn">Post</label></li>
			<?php }else{
				echo '<li><a href= "'.BASE_URL.'index.php">Have an account? Log In to continue!</a></li>';
			} ?>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->
	</div><!-- nav container ends -->
</div><!-- header wrapper end -->

<script type="text/javascript" src="assets/js/search.js"></script>

<!--Profile cover-->
<div class="profile-cover-wrap"> 
<div class="profile-cover-inner">
	<div class="profile-cover-img">
		<!-- PROFILE-COVER -->
		<img src="<?php echo BASE_URL.$profileData->profileCover;?>"/>
	</div>
</div>
<div class="profile-nav">
 <div class="profile-navigation">
	<ul>
		<li>
		<div class="n-head">
			POSTS
		</div>
		<div class="n-bottom">
		  <?php $getFromP->countPosts($user_id); ?>
		</div>
		</li>
		<li>
			<a href="<?php echo BASE_URL.$profileData->username;?>/following">
				<div class="n-head">
					<a href="<?php echo BASE_URL.$profileData->username;?>/following">FOLLOWING</a>
				</div>
				<div class="n-bottom">
					<span class="count-following"><?php echo $profileData->following;?></span>
				</div>
			</a>
		</li>
		<li>
		 <a href="<?php echo BASE_URL.$profileData->username;?>/followers">
				<div class="n-head">
					FOLLOWERS
				</div>
				<div class="n-bottom">
					<span class="count-followers"><?php echo $profileData->followers;?></span>
				</div>
			</a>
		</li>
		<li>
			<a href="#">
				<div class="n-head">
					LIKES
				</div>
				<div class="n-bottom">
					<?php $getFromP->countLikes($user_id); ?>
				</div>
			</a>
		</li>
	</ul>
	<div class="edit-button">
		<span>
			<?php echo $getFromF->followBtn($profileId, $user_id, $profileData->user_id);?>
		</span>
	</div>
    </div>
</div>
</div><!--Profile Cover End-->

<!---Inner wrapper-->
<div class="in-wrapper">
 <div class="in-full-wrap">
   <div class="in-left">
     <div class="in-left-wrap">
	<!--PROFILE INFO WRAPPER END-->
	<div class="profile-info-wrap">
	 <div class="profile-info-inner">
	 <!-- PROFILE-IMAGE -->
		<div class="profile-img">
			<img src="<?php echo BASE_URL.$profileData->profileImage;?>"/>
		</div>	

		<div class="profile-name-wrap">
			<div class="profile-name">
				<a href="<?php echo BASE_URL.$profileData->username;?>"><?php echo $profileData->screenName;?></a>
			</div>
			<div class="profile-tname">
				@<span class="username"><?php echo $profileData->username;?></span>
			</div>
		</div>

		<div class="profile-bio-wrap">
		 <div class="profile-bio-inner">
		   <?php echo $profileData->bio;?>
		 </div>
		</div>

<div class="profile-extra-info">
	<div class="profile-extra-inner">
		<ul>
		<?php if(!empty($profileData->country)){?>
			<li>
				<div class="profile-ex-location-i">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
				</div>
				<div class="profile-ex-location">
					<?php echo $profileData->country;?>
				</div>
			</li>
		<?php }?>
		<?php if(!empty($profileData->website)){?>
			<li>
				<div class="profile-ex-location-i">
					<i class="fa fa-link" aria-hidden="true"></i>
				</div>
				<div class="profile-ex-location">
					<a href="<?php echo $profileData->website;?>" target= "_blink"><?php echo $profileData->wbebsite;?></a>
				</div>
			</li>
		<?php }?>
			<li>
				<div class="profile-ex-location-i">
					<!-- <i class="fa fa-calendar-o" aria-hidden="true"></i> -->
				</div>
				<div class="profile-ex-location">
 				</div>
			</li>
			<li>
				<div class="profile-ex-location-i">
					<!-- <i class="fa fa-tint" aria-hidden="true"></i> -->
				</div>
				<div class="profile-ex-location">
				</div>
			</li>
		</ul>						
	</div>
</div>

<div class="profile-extra-footer">
	<div class="profile-extra-footer-head">
		<div class="profile-extra-info">
			<ul>
				<li>
					<div class="profile-ex-location-i">
						<i class="fa fa-camera" aria-hidden="true"></i>
					</div>
					<div class="profile-ex-location">
						<a href="#">0 Photos and videos </a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="profile-extra-footer-body">
		<ul>
			 <!-- <li><img src="#"/></li> -->
		</ul>		
	</div>
</div>

	 </div>
	<!--PROFILE INFO INNER END-->

	</div>
	<!--PROFILE INFO WRAPPER END-->

	</div>
	<!-- in left wrap-->

  </div>
	<!-- in left end-->

<div class="in-center">
	<div class="in-center-wrap">
	<?php
		$posts = $getFromP->getUserPosts($profileId);
		foreach ($posts as $post) {

			$likes = $getFromP->likes($user_id, $post->postID);

			//echo $likes['likeOn'];
			if(is_bool($likes)){
				$likes = array();
				$likes['likeOn'] = -1;
			}

			$repost = $getFromP->checkRepost($post->postID, $user_id);
			if(is_bool($repost)){
				$repost = array();
				$repost['repostID'] = -1;
				$repost['repostBy'] = -1;
				$repost['postID'] = -1;
				$repost['postedOn']=-1;
			}
			$user = $getFromP->userData($post->repostBy);

			echo '<div class="all-post">
					<div class="t-show-wrap">
					 <div class="t-show-inner">
						'.(($repost['repostID'] === $post->repostID OR $post->repostID > 0) ? '
						<div class="t-show-banner">
							<div class="t-show-banner-inner">
								<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>'.$user->screenName.' Reposted</span>
							</div>
						</div>' 
						: '').'

						'.((!empty($post->repostMsg) && $post->postID === $repost['postID'] or $post->repostID > 0) ? '
							<div class="t-show-popup" data-post="'.$post->postID.'">
							<div class="t-show-head">
								<div class="t-show-img">
									<img src="'.BASE_URL.$user->profileImage.'"/>
								</div>
								<div class="t-s-head-content">
									<div class="t-h-c-name">
										<span><a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></span>
										<span>@'.$user->username.'</span>
										<span>'.$getFromU->timeAgo($post->postedOn).'</span>
									</div>
									<div class="t-h-c-dis">
										'.$getFromP->getPostLinks($post->repostMsg).'
									</div>
								</div>
							</div>
							<div class="t-s-b-inner">
								<div class="t-s-b-inner-in">
									<div class="repost-t-s-b-inner">
										'.((!empty($post->postimage)) ? '
										<div class="repost-t-s-b-inner-left">
											<img src="'.BASE_URL.$post->postimage.'" class="imagePopup" data-post ="'.$post->postID.'"/>	
										</div>' : '' ).'
										<div>
											<div class="t-h-c-name">
												<span><a href="'.BASE_URL.$post->username.'">'.$post->screenName.'</a></span>
												<span>@'.$post->username.'</span>
												<span>'.$getFromU->timeAgo($post->postedOn).'</span>
											</div>
											<div class="repost-t-s-b-inner-right-text">		
												'.$getFromP->getPostLinks($post->status).'
											</div>
										</div>
									</div>
								</div>
							</div> 
							</div>' : '
						
						<div class="t-show-popup" data-post="'.$post->postID.'">
							<div class="t-show-head">
								<div class="t-show-img">
									<img src="'.BASE_URL.$post->profileImage.'"/>
								</div>
								<div class="t-s-head-content">
									<div class="t-h-c-name">
										<span><a href="'.$post->username.'">'.$post->screenName.'</a></span>
										<span>@'.$post->username.'</span>
										<span>'.$getFromU->timeAgo($post->postedOn).'</span>
									</div>
									<div class="t-h-c-dis">
										'.$getFromP->getPostLinks($post->status).'
									</div>
								</div>
							</div> '.
							((!empty($post->postimage)) ? 
							 '<!--post show head end-->
							<div class="t-show-body">
							  <div class="t-s-b-inner">
							   <div class="t-s-b-inner-in">
							     <img src="'.BASE_URL.$post->postimage.'" class="imagePopup" data-post= "'.$post->postID.'"/>
							   </div>
							  </div>
							</div>
							<!--post show body end-->
							' : '' ).'
						

						 </div> ' ).'
						<div class="t-show-footer">
							<div class="t-s-f-right">
								<ul>
								'.(($getFromU->loggedIn() === true)? '
									<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>
									<li>'.(($post->postID === $repost['repostID'] OR $user_id == $repost['repostBy']) ? '<button class="reposted" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="repostsCount">'.$post->repostCount.'</span></button>' : '<button class="repost" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="repostsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>' ).'</li>
									<li>'.(($likes['likeOn'] === $post->postID) ? '<button class="unlike-btn" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a><span class="likesCounter">'.$post->likesCount.'</span></button>' : '<button class="like-btn" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>').'</li>
										'.(($post->postBy === $user_id)? '
										<li>
										<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
										<ul>
										  <li><label class="deletePost" data-post="'.$post->postID.'">Delete Post</label></li>
										</ul>
									</li>' : '').'
									' : '<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>
											 <li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>
											 <li><button><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a></button></li>
										').'
								</ul>
							</div>
						</div>
					</div>
					</div>
					</div>';
		}
	?>
	</div><!-- in left wrap-->
  <div class="popupPost"></div>
  <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/repost.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupposts.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/fetch.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/messages.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>


</div>
<!-- in center end -->

<div class="in-right">
	<div class="in-right-wrap">
			
		<!--==WHO TO FOLLOW==-->
	      <?php $getFromF->whoToFollow($user_id,$profileId); ?>
		<!--==WHO TO FOLLOW==-->
			
		<!--==TRENDS==-->
	 	 <?php $getFromP->trends(); ?>
	 	<!--==TRENDS==-->
			
	</div><!-- in right wrap-->
</div>

<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
<!-- in right end -->

		</div>
		<!--in full wrap end-->
	</div>
	<!-- in wrappper ends-->	
 </div>
 <!-- ends wrapper -->
</body>
</html>
