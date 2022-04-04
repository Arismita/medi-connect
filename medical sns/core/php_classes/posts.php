<?php 
class Posts extends User{

	function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function posts($user_id, $num){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts`LEFT JOIN `users` ON `postBy` = `user_id` WHERE `postBy` = :user_id AND `repostID` = '0' OR `postBy` = `user_id` AND `repostBy` != :user_id AND `postBy` IN(SELECT `receiver` FROM `follow` WHERE `sender` = :user_id) ORDER BY `postID` DESC LIMIT :num");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindParam(":num", $num, PDO::PARAM_INT);
		$stmt->execute();
		$posts = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach ($posts as $post) {

			$likes = $this->likes($user_id, $post->postID);

			//echo $likes['likeOn'];
			if(is_bool($likes)){
				$likes = array();
				$likes['likeOn'] = -1;
			}

			$repost = $this->checkRepost($post->postID, $user_id);
			if(is_bool($repost)){
				$repost = array();
				$repost['repostID'] = -1;
				$repost['postID'] = -1;
				$repost['postedOn'] = -1;
			}
			$user = $this->userData($post->repostBy);

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
										<span>'.$this->timeAgo($repost['postedOn']).'</span>
									</div>
									<div class="t-h-c-dis">
										'.$this->getPostLinks($post->repostMsg).'
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
												<span>'.$this->timeAgo($post->postedOn).'</span>
											</div>
											<div class="repost-t-s-b-inner-right-text">		
												'.$this->getPostLinks($post->status).'
											</div>
										</div>
									</div>
								</div>
							</div> 
							</div>' : '
						
						<div class="t-show-popup" data-post="'.$post->postID.'">
							<div class="t-show-head">
								<div class="t-show-img">
									<img src="'.$post->profileImage.'"/>
								</div>
								<div class="t-s-head-content">
									<div class="t-h-c-name">
										<span><a href="'.$post->username.'">'.$post->screenName.'</a></span>
										<span>@'.$post->username.'</span>
										<span>'.$this->timeAgo($post->postedOn).'</span>
									</div>
									<div class="t-h-c-dis">
										'.$this->getPostLinks($post->status).'
									</div>
								</div>
							</div> '.
							((!empty($post->postimage)) ? 
							 '<!--post show head end-->
							<div class="t-show-body">
							  <div class="t-s-b-inner">
							   <div class="t-s-b-inner-in">
							     <img src="'.$post->postimage.'" class="imagePopup" data-post= "'.$post->postID.'"/>
							   </div>
							  </div>
							</div>
							<!--post show body end-->
							' : '' ).'
						

						 </div> ' ).'
						<div class="t-show-footer">
							<div class="t-s-f-right">
								<ul>
									<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>
									<li>'.(($post->postID === $repost['repostID']) ? '<button class="reposted" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="repostsCount">'.$post->repostCount.'</span></button>' : '<button class="repost" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="repostsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>' ).'</li>
									<li>'.(($likes['likeOn'] === $post->postID) ? '<button class="unlike-btn" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a><span class="likesCounter">'.$post->likesCount.'</span></button>' : '<button class="like-btn" data-post="'.$post->postID.'" data-user="'.$post->postBy.'"><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>').'</li>
										'.(($post->postBy === $user_id)? '
										<li>
										<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
										<ul>
										  <li><label class="deletePost" data-post="'.$post->postID.'">Delete Post</label></li>
										</ul>
									</li>' : '').'
								</ul>
							</div>
						</div>
					</div>
					</div>
					</div>';
		}
	}

	public function getUserPosts($user_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `postBy`= `user_id` WHERE `postBy` = :user_id AND `repostID` = '0' OR `repostBy` =:user_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function addLike($user_id, $post_id, $get_id){
		$stmt = $this->pdo->prepare("UPDATE `posts` SET `likesCount` = `likesCount` +1 WHERE `postID` = :post_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();

		$this->create('likes', array('likeBy' => $user_id, 'likeOn' => $post_id));
		if($get_id != $user_id){
			$xyz= new Message($this->pdo);
			$xyz->sendNotification($get_id, $user_id, $post_id, 'like');
		}
	}

	public function unlike($user_id, $post_id, $get_id){
		$stmt = $this->pdo->prepare("UPDATE `posts` SET `likesCount` = `likesCount` -1 WHERE `postID` = :post_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id AND `likeOn` = :post_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();
	}


	public function likes($user_id, $post_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `likes` WHERE `likeBy` = :user_id AND `likeOn` = :post_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();

		return  $stmt->fetch(PDO::FETCH_ASSOC);

	}

	public function getTrendByHash($hashtag){
		$stmt= $this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag LIMIT 5");
		$stmt->bindValue(':hashtag', $hashtag.'%');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function getMention($mention){
		$stmt= $this->pdo->prepare("SELECT `user_id`, `username`, `screenName`, `profileImage` FROM `users` WHERE `username` LIKE :mention OR `screenName`LIKE :mention LIMIT 5");
		$stmt->bindValue(':mention', $mention.'%');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function addTrend($hashtag){
		preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $matches);
		if($matches){
			$result = array_values($matches[1]);
		}

		$sql = "INSERT INTO `trends` (`hashtag`,`createdOn`) VALUES(:hashtag, CURRENT_TIMESTAMP)";

		foreach ($result as $trend) {
			if($stmt = $this->pdo->prepare($sql)){
				$stmt->execute(array(':hashtag'=> $trend));
			}
		}
	}

	public function addMention($status, $user_id, $post_id){
		preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $matches);
		if($matches){
			$result = array_values($matches[1]);
		}

		$sql = "SELECT * FROM `users` WHERE `username` = :mention";

		foreach ($result as $trend) {
			if($stmt = $this->pdo->prepare($sql)){
				$stmt->execute(array(':mention'=> $trend));
				$data = $stmt->fetch(PDO::FETCH_OBJ);

				if($data->user_id != $user_id){
				$xyz= new Message($this->pdo);
				$xyz->sendNotification($data->user_id, $user_id, $post_id, 'mention');
				}
			}
		}
		
	}

	public static function getPostLinks($post){
		$post = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href= '$0' target='_blink'>$0</a>", $post);
		$post = preg_replace("/#([\w]+)/", "<a href= '".BASE_URL."hashtag/$1'>$0</a>", $post);
		$post = preg_replace("/@([\w]+)/", "<a href= '".BASE_URL."$1'>$0</a>", $post);
		return $post;
	}

	public function getPopupPost($post_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts`,`users` WHERE `postID` = :post_id AND `postBy` = `user_id`");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();
		return  $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function repost($post_id, $user_id, $get_id, $comment){
		$stmt = $this->pdo->prepare("UPDATE `posts` SET `repostCount`= `repostCount` +1 WHERE `postID`= :post_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $this->pdo->prepare("INSERT INTO `posts` (`status`, `postBy`, `postimage`, `repostID`, `repostBy`, `postedOn`, `likesCount`, `repostCount`, `repostMsg`) SELECT `status`, `postBy`, `postimage`, `postID`, :user_id, `postedOn`, `likesCount`, `repostCount`, :repostMsg FROM `posts` WHERE `postID` = :post_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindParam(":repostMsg", $comment, PDO::PARAM_STR);
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();
		$xyz= new Message($this->pdo);
		$xyz->sendNotification($get_id, $user_id, $post_id, 'repost');

	}

	public function checkRepost($post_id, $user_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts` WHERE `repostID` = :post_id AND `repostBy` = :user_id OR `postID` = :post_id AND `repostBy` = :user_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return  $stmt->fetch(PDO::FETCH_ASSOC);

	}

	public function comments($post_id){
		$stmt  = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_id` WHERE `commentOn` = :post_id");
		$stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
		$stmt->execute();
		return  $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function countPosts($user_id){
		$stmt  = $this->pdo->prepare("SELECT COUNT(`postID`) AS `totalPosts` FROM `posts` WHERE `postBy` = :user_id AND `repostID` = '0' OR `repostBy` = :user_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_OBJ);
		echo $count->totalPosts;
	}

	public function countLikes($user_id){
		$stmt  = $this->pdo->prepare("SELECT COUNT(`likeId`) AS `totalLikes` FROM `likes` WHERE `likeBy` = :user_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_OBJ);
		echo $count->totalLikes;
	}

	public function trends(){
		$stmt = $this->pdo->prepare("SELECT *, COUNT(`postID`) AS `postsCount` FROM `trends` INNER JOIN `posts` ON `status` LIKE CONCAT('%#',`hashtag`,'%') OR `repostMsg` LIKE CONCAT('%#',`hashtag`,'%') GROUP BY `hashtag` ORDER BY `postID`");
		$stmt->execute();
		$trends = $stmt->fetchAll(PDO::FETCH_OBJ);

		echo '<div class="trend-wrapper"><div class="trend-inner"><div class="trend-title"><h3> Happening Now</h3></div><!-- trend title end-->';


		foreach ($trends as $trend) {
			echo '
			<div class="trend-body">
				<div class="trend-body-content">
					<div class="trend-link">
						<a href="'.BASE_URL.'hashtag/'.$trend->hashtag.'">#'.$trend->hashtag.'</a>
					</div>
					<div class="trend-postss">
						'.$trend->postsCount.' <span>posts</span>
					</div>
				</div>
			</div>
			';
		}

		echo '</div></div>';
	}

	public function getPostsByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `postBy` = `user_id` WHERE `status` LIKE :hashtag OR `repostMsg` LIKE :hashtag");
		$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function getUsersByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT DISTINCT * FROM `posts` INNER JOIN `users` ON `postBy` = `user_id` WHERE `status` LIKE :hashtag OR `repostMsg` LIKE :hashtag GROUP BY `user_id`");
		$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
}
?>