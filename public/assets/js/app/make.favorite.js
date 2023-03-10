/*
  */

$(document).ready(function () {
	
	/* Save the Post */
	$('.make-favorite').click(function () {
		savePost(this);
	});
	
	/* Save the Search */
	$('#saveSearch').click(function () {
		saveSearch(this);
	});
	
});

/**
 * Save Ad
 * @param elmt
 * @returns {boolean}
 */
function savePost(elmt) {
	var postId = $(elmt).attr('id');
	
	let url = siteUrl + '/ajax/save/post';
	
	$.ajax({
		method: 'POST',
		url: url,
		data: {
			'postId': postId,
			'_token': $('input[name=_token]').val()
		}
	}).done(function (data) {
		if (typeof data.logged == "undefined") {
			return false;
		}
		
		/* Guest Users - Need to Log In */
		if (data.logged == 0) {
			$('#quickLogin').modal();
			return false;
		}
		
		/* Logged Users - Notification */
		if (data.status == 1) {
			if ($(elmt).hasClass('btn')) {
				$('#' + data.postId).removeClass('btn-default').addClass('btn-success');
			} else {
				$(elmt).html('<i class="fa fa-heart tooltipHere" data-toggle="tooltip" data-original-title="' + lang.labelSavePostRemove + '"></i>');
			}
			alert(lang.confirmationSavePost);
		} else {
			if ($(elmt).hasClass('btn')) {
				$('#' + data.postId).removeClass('btn-success').addClass('btn-default');
			} else {
				$(elmt).html('<i class="far fa-heart tooltipHere" data-toggle="tooltip" data-original-title="' + lang.labelSavePostSave + '"></i>');
			}
			alert(lang.confirmationRemoveSavePost);
		}
		
		return false;
	});
	
	return false;
}

/**
 * Save Search
 * @param elmt
 * @returns {boolean}
 */
function saveSearch(elmt) {
	var searchUrl = $(elmt).attr('name');
	var countPosts = $(elmt).attr('count');
	
	let url = siteUrl + '/ajax/save/search';
	
	$.ajax({
		method: 'POST',
		url: url,
		data: {
			'url': searchUrl,
			'countPosts': countPosts,
			'_token': $('input[name=_token]').val()
		}
	}).done(function (data) {
		if (typeof data.logged == "undefined") {
			return false;
		}
		
		/* Guest Users - Need to Log In */
        if (data.logged == 0) {
			$('#quickLogin').modal();
			return false;
		}
		
		/* Logged Users - Notification */
		if (data.status == 1) {
			alert(lang.confirmationSaveSearch);
		} else {
			alert(lang.confirmationRemoveSaveSearch);
		}
		
		return false;
	});
	
	return false;
}