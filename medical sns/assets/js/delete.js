$(function(){
	$(document).on('click', '.deletePost', function(){
		var post_id = $(this).data('post');
		$.post('http://localhost/medical%20sns/core/ajax/deletePost.php', {showPopup:post_id}, function(data){
			$('.popupPost').html(data);
			$('.close-repost-popup,.cancel-it').click(function(){
				$('.repost-popup').hide();
			});
			});

			$(document).on('click', '.delete-it', function(){
				$.post('http://localhost/medical%20sns/core/ajax/deletePost.php', {deletePost:post_id}, function(){
					$('.repost-popup').hide();
					location.reload();
			});
		});

	});

	$(document).on('click', '.deleteComment', function(){
		var commentID = $(this).data('comment');
		var post_id = $(this).data('post');

		$.post('http://localhost/medical%20sns/core/ajax/deleteComment.php', {deleteComment:commentID}, function(){
			$.post('http://localhost/medical%20sns/core/ajax/popupposts.php', {showpopup:post_id}, function(data){
				$('.popupPost').html(data);
				$('.post-show-popup-box-cut').click(function(){
					$('.post-show-popup-wrap').hide();
				});
			});
		});
	});
});