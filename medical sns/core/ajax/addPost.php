<?php
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
	if(isset($_POST) && !empty($_POST)){
		$status = $getFromU->checkInput($_POST['status']);
		$user_id = $_SESSION['user_id'];
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
			$result['success'] = "Your post is saved!";
			echo json_encode($result);

		}else{
			$error= "Type or chose an image to post";
		}

		if(isset($error)){
			$result['error'] = $error;
			echo json_encode($result);
		}
	}
?>