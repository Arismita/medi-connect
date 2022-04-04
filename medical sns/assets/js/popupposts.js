$(function(){
	$(document).on('click', '.t-show-popup', function(){
		var post_id = $(this).data('post');
		$.post('http://localhost/medical%20sns/core/ajax/popupposts.php', {showpopup:post_id}, function(data){
			$('.popupPost').html(data);
			$('.post-show-popup-box-cut').click(function(){
				$('.post-show-popup-wrap').hide();
			});
		});
	});

	$(document).on('click', '.imagePopup', function(e){
		e.stopPropagation();
		var post_id = $(this).data('post');
		$.post('http://localhost/medical%20sns/core/ajax/imagePopup.php', {showImage:post_id}, function(data){
			$('.popupPost').html(data);
			$('.close-imagePopup').click(function(){
				$('.img-popup').hide();
			});
		});
	});
});