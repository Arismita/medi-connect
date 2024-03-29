<?php
	if(isset($_GET['username']) === true && empty($_GET['username']) === false){
		include 'core/init.php';
		$username = $getFromU->checkInput($_GET['username']);
		$profileId = $getFromU->userIdByUsername($username);
		$profileData = $getFromU->userData($profileId);
		$user_id = $_SESSION['user_id'];
		$user = $getFromU->userData($user_id);
		$notify = $getFromM->getNotificationCount($user_id);

		if($getFromU->loggedIn() === false){
			header('Location: '.BASE_URL.'index.php');
		}

		if(!$profileData){
			header('Location: '.BASE_URL.'index.php');
		}
	}else{
		header('Location: '.BASE_URL.'index.php');
	}
?>

<!doctype html>
<html>
	<head>
		<title>Accounts Followed By <?php echo $profileData->screenName.'(@'.$profileData->username.')';?></title>
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
	<!-- whoToFollow -->
	<?php $getFromF->whoToFollow($user_id, $user_id); ?>
	
	<!-- Trends -->
	<?php $getFromP->trends(); ?>
</div>

	 </div>
	<!--PROFILE INFO INNER END-->

	</div>
	<!--PROFILE INFO WRAPPER END-->

	<div class="popupPost"></div>
	</div>
	<!-- in left wrap-->
</div>
<!-- in left end-->
		<!--FOLLOWING OR FOLLOWER FULL WRAPPER-->
		<div class="wrapper-following">
			<div class="wrap-follow-inner">
               <?php $getFromF->followingList($profileId, $user_id, $profileData->user_id); ?> 
			</div>
		<!-- wrap follo inner end-->
		</div>
		<script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/follow.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/repost.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupposts.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/messages.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>



		<!--FOLLOWING OR FOLLOWER FULL WRAPPER END-->	
	</div><!--in full wrap end-->
</div>
<!-- in wrappper ends-->
</div><!-- ends wrapper -->
</body>

</html>