<?php
	include 'core/init.php';
?>


<html>
	<head>
		<title>MediConnect</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
		<link rel="stylesheet" href="assets/css/style-complete.css"/>
	</head>
	<!--Helvetica Neue-->
<body>
<div class="front-img">
	<img src="assets/images/background.jpg"></img>
</div>

<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">

	<div class="nav-container">
		<!-- Nav -->
		<div class="nav">

			<div class="nav-left">
				<ul>
					<li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Home</a></li>
					<li><a href="#">About</a></li>
				</ul>
			</div><!-- nav left ends-->

			<div class="nav-right">
				<ul>
					<li><a href="#">Language</a></li>
				</ul>
			</div><!-- nav right ends-->

		</div><!-- nav ends -->

	</div><!-- nav container ends -->

</div><!-- header wrapper end -->

<!---Inner wrapper-->
<div class="inner-wrapper">
	<!-- main container -->
	<div class="main-container">
		<!-- content left-->
		<div class="content-left">
			<h1 style="color:black">Welcome to MediConnect!</h1>

			<br/>
			<p style="color:black">A place to connect with various people - get guidance from renowned doctors, and get to interact with people with the same mindset as you, from around the world. This will help you create a medical network of your own and share your thoughts and problems with the world!</p>
		</div><!-- content left ends -->

		<!-- content right ends -->
		<div class="content-right">
			<!-- Log In Section -->
			<div class="login-wrapper">
			  <?php include 'includes/login.php'; ?>
			</div><!-- log in wrapper end -->

			<!-- SignUp Section -->
			<div class="signup-wrapper">
			   <?php include 'includes/signup.php'; ?>
			</div>
			<!-- SIGN UP wrapper end -->

		</div><!-- content right ends -->

	</div><!-- main container end -->

</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->
</body>
</html>
