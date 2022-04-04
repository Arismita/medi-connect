<?php
	include 'core/init.php';
	$user_id = $_SESSION['user_id'];
	$user = $getFromU->userData($user_id);
	$notify = $getFromM->getNotificationCount($user_id);
	if($getFromU->loggedIn() === false){
		header('Location: '.BASE_URL.'index.php');
	}

	$getFromU->delete('comments', array('commentID' => '2'));

	if(isset($_POST['post'])){
		$status = $getFromU->checkInput($_POST['status']);
		$postImage = '';

		if(!empty($status) or !empty($_FILES['file']['name'][0])){

			if(!empty($_FILES['file']['name'][0])){
				$postImage = $getFromU->uploadImage($_FILES['file']);
			}

			if(strlen($status) > 140){
				$error = "The text is too long!";
			}
			$post_id = $getFromU->create('posts', array('status' => $status, 'postBy' => $user_id, 'postimage' => $postImage, 'postedOn' => date('Y-m-d H:i:s')));
			preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
			if(!empty($hashtag)){
				$getFromP->addTrend($status);
			}
			$getFromP->addMention($status, $user_id, $post_id);
		}else{
			$error= "Type or chose an image to post";
		}
	}
?>


<!DOCTYPE HTML>
 <html>
	<head>
		<title>MediConnect</title>
		  <meta charset="UTF-8" />
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
 	  	  <link rel="stylesheet" href="assets/css/style-sheet.css"/>
   		  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	</head>
	<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">

<div class="nav-container">
	<!-- Nav -->
	<div class="nav">

		<div class="nav-left">
			<ul>
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification<span id="notification"><?php if($notify->totalN > 0){echo '<span class="span-i">'.$notify->totalN.'</span>';}?></span></a></li>
				<li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages<span id="messages"><?php if($notify->totalM > 0){echo '<span class="span-i">'.$notify->totalM.'</span>';} ?></span></li>
			</ul>
		</div><!-- nav left ends-->

		<div class="nav-right">
			<ul>
				<li>
					<input type="text" placeholder="Search" class="search"/>
					<i class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result">
					</div>
				</li>

				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo $user->profileImage;?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo $user->username;?>"><?php echo $user->username;?></a></li>
							<li><a href="settings/account">Settings</a></li>
							<li><a href="includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label class="addPostBtn">Post</label></li>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->

</div><!-- nav container ends -->

</div><!-- header wrapper end -->

<script type="text/javascript" src="assets/js/search.js"></script>
<script type="text/javascript" src="assets/js/hashtag.js"></script>
<script type="text/javascript" src="assets/js/repost.js"></script>

<!---Inner wrapper-->
<div class="inner-wrapper">
<div class="in-wrapper">
	<div class="in-full-wrap">
		<div class="in-left">
			<div class="in-left-wrap">
		<div class="info-box">
			<div class="info-inner">
				<div class="info-in-head">
					<!-- PROFILE-COVER-IMAGE -->
					<img src="<?php echo $user->profileCover;?>"/>
				</div><!-- info in head end -->
				<div class="info-in-body">
					<div class="in-b-box">
						<div class="in-b-img">
						<!-- PROFILE-IMAGE -->
							<img src="<?php echo $user->profileImage;?>"/>
						</div>
					</div><!--  in b box end-->
					<div class="info-body-name">
						<div class="in-b-name">
							<div><a href="<?php echo $user->username;?>"><?php echo $user->screenName;?></a></div>
							<span><small><a href="<?php echo $user->username;?>">@<?php echo $user->username;?></a></small></span>
						</div><!-- in b name end-->
					</div><!-- info body name end-->
				</div><!-- info in body end-->
				<div class="info-in-footer">
					<div class="number-wrapper">
						<div class="num-box">
							<div class="num-head">
								POSTS
							</div>
							<div class="num-body">
								<?php $getFromP->countPosts($user_id); ?>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWING
							</div>
							<div class="num-body">
								<span class="count-following"><?php echo $user->following;?></span>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWERS
							</div>
							<div class="num-body">
								<span class="count-followers"><?php echo $user->followers;?></span>
							</div>
						</div>
					</div><!-- mumber wrapper-->
				</div><!-- info in footer -->
			</div><!-- info inner end -->
		</div><!-- info box end-->

	<!--==TRENDS==-->
 	 <?php $getFromP->trends(); ?>
 	<!--==TRENDS==-->

	</div><!-- in left wrap-->
		</div><!-- in left end-->
		<div class="in-center">
			<div class="in-center-wrap">
				<!--POST WRAPPER-->
				<div class="post-wrap">
					<div class="post-inner">
						 <div class="post-h-left">
						 	<div class="post-h-img">
						 	<!-- PROFILE-IMAGE -->
						 		<img src="<?php echo $user->profileImage;?>"/>
						 	</div>
						 </div>
						 <div class="post-body">
						 <form method="post" enctype="multipart/form-data">
							<textarea class="status" name="status" placeholder="Type Something here!" rows="4" cols="50"></textarea>
 						 	<div class="hash-box">
						 		<ul>
  						 		</ul>
						 	</div>
 						 </div>
						 <div class="post-footer">
						 	<div class="t-fo-left">
						 		<ul>
						 			<input type="file" name="file" id="file"/>
						 			<li><label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
						 			<span class="post-error"><?php if(isset($error)){echo $error;}else if(isset($imageError)){echo $imageError;} ?></span>
						 			</li>
						 		</ul>
						 	</div>
						 	<div class="t-fo-right">
						 		<span id="count">140</span>
						 		<input type="submit" name="post" value="post"/>
				 		</form>
						 	</div>
						 </div>
					</div>
				</div><!--POST WRAP END-->


				<!--Post SHOW WRAPPER-->
				 <div class="posts">
 				  	<?php $getFromP->posts($user_id,10); ?>
 				 </div>
 				<!--POSTS SHOW WRAPPER-->

		    	<div class="loading-div">
		    		<img id="loader" src="assets/images/loading.svg" style="display: none;"/>
		    	</div>
				<div class="popupPost"></div>
				<!--Post END WRAPER-->

			<script type="text/javascript" src="assets/js/like.js"></script>
			<script type="text/javascript" src="assets/js/repost.js"></script>
			<script type="text/javascript" src="assets/js/popupposts.js"></script>
			<script type="text/javascript" src="assets/js/delete.js"></script>
			<script type="text/javascript" src="assets/js/comment.js"></script>
			<script type="text/javascript" src="assets/js/popupForm.js"></script>
			<script type="text/javascript" src="assets/js/fetch.js"></script>
			<script type="text/javascript" src="assets/js/follow.js"></script>
			<script type="text/javascript" src="assets/js/messages.js"></script>
			<script type="text/javascript" src="assets/js/postMessage.js"></script>
			<script type="text/javascript" src="assets/js/notification.js"></script>

			</div><!-- in left wrap-->
		</div><!-- in center end -->

		<div class="in-right">
			<div class="in-right-wrap">

		 	<!--Who To Follow-->
		      <?php $getFromF->whoToFollow($user_id, $user_id); ?>
      		<!--Who To Follow-->

 			</div><!-- in left wrap-->

		</div><!-- in right end -->
		<script type="text/javascript" src="assets/js/follow.js"></script>
	</div><!--in full wrap end-->

</div><!-- in wrappper ends-->
</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->
</body>

</html>