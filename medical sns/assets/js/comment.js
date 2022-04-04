$(function(){
	$(document).on('click', '#postComment', function(){
		var comment = $('#commentField').val();
		var post_id = $('#commentField').data('post');

		if (comment != "") {
			$.post('http://localhost/medical%20sns/core/ajax/comment.php', {comment:comment, post_id:post_id}, function(data){
				$('#comments').html(data);
				$('#commentField').val("");
			});
		}
	});
});