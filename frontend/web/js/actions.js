function actions(id, cate, action, callback)
{
	if (!id || !cate || !action) { return }
	//var url = weburl+'site/setaction';
	var url = 'setaction';
	var data = {
		"sourceid"	:id,
		"cate"		:cate,
		"action"	:action,
	}
	$.ajax({
        type: "POST",
        url: url,
        data: data,
        success:function(resp){
            if (resp && resp != 0) {
                console.log(resp);
                var items = $.parseJSON(resp);
                //console.log(items);
                if (callback) {
                	callback(items);
                }
                //return items;
            } else {
                //$("#messages-machine_id").html("<option value=>There is no machines in this room.</option>");
            }
        },
        error:function(){
            console.log("Failed request data from AJAX request");
        },
        dataType: "text"
    });
}

function handleMessage(id, action, callback)
{
	if (!id || !action) { return }
	var url = 'handlemessage';
	var data = {
		"msgid"		:id,
		"action"	:action,
	}
	$.ajax({
        type: "POST",
        url: url,
        data: data,
        success:function(resp){
            if (resp && resp != 0) {
                //console.log(resp);
                var items = $.parseJSON(resp);
                //console.log(items);
                if (callback) {
                	callback(items);
                }
                //return items;
            } else {
                //$("#messages-machine_id").html("<option value=>There is no machines in this room.</option>");
            }
        },
        error:function(){
            console.log("Failed request data from AJAX request");
        },
        dataType: "text"
    });
}

function longPoll () {
    var _count = $('#msgli').attr('count');
    var _csrf = $('input[name=_csrf-frontend]').val();
    var url = 'http://localhost/music/site/getnewmsgcount'
    var data = {
		"count"			:_count,
		'_csrf-frontend':_csrf
	}

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        //async:true,
        success:function(resp){
            if (resp && resp != 0) {
            	
            	$('#msgli').attr('count', resp);
            	$('#msgli').text(resp);
            	$('#msgli').addClass('animated bounce infinite');
			    longPoll();
            } else {
                //$("#messages-machine_id").html("<option value=>There is no machines in this room.</option>");
            }
        },
        error:function(){
            console.log("Failed request data from AJAX request");
        },
        dataType: "json"
    });

}


$(document).ready(function(){

	$(document).on('click', '.like', function(event) {
		var _this = $(this);
		var id = _this.attr('source-id') || 0;
		var cate = _this.attr('cate') || 'album';
		var action = 'like';
		var num = parseInt(_this.find('.count').text());
		actions(id, cate, action, function(result){
			if (result && result.active ==1) {
				num = num + 1;
				_this.find('.count').text(num);
				_this.removeClass('btn-default').addClass('btn-info');
			} else {
				num = num - 1;
				if (num < 0) { num = 0 };
				_this.find('.count').text(num);
				_this.removeClass('btn-info').addClass('btn-default');
			}
		});
	});

	$(document).on('click', '.follow', function(event) {
		var _this = $(this);
		var id = _this.attr('artist-id') || 0;
		var cate ='artist';
		var action = 'follow';
		var followers = parseInt(_this.find('.followers').text());
		var num = parseInt(_this.find('.count').text());
		actions(id, cate, action, function(result){
			if (result && result.active) {
				num = num + 1;
				//_this.attr('followers', num);
				_this.find('.count').text(num);
				_this.removeClass('btn-default').addClass('btn-info');
			} else {
				num = num - 1;
				//_this.attr('followers', num);
				if (num < 0) { num = 0 };
				_this.find('.count').text(num);
				_this.removeClass('btn-info').addClass('btn-default');
			}
		});
	});

	$(document).on('click', '.like_song', function(event) {
		var _this = $(this);
		var id = _this.attr('track-id') || 0;
		var cate ='track';
		var action = 'like';
		var num = parseInt(_this.find('.likesong_count').text()) || 0;
		actions(id, cate, action, function(result){
			if (result && result.active ==1) {
				num = num + 1;
				_this.find('.likesong_count').text(num);
				_this.addClass('text-info');
			} else {
				num = num - 1;
				_this.find('.likesong_count').text(num);
				_this.removeClass('text-info');
			}
		});
	});

	$(document).on('click', '.readMessage', function(event) {
		var _this = $(this);
		var id = _this.attr('msgid') || 0;
		var action = 'read';
		handleMessage(id, action, function(result){
			if (result && result) {
				_this.closest('.media-body').find('.badge').remove();
			} else {
				
			}
		});
	});

	$(document).on('click', '.removeMessage', function(event) {
		var _this = $(this);
		var id = _this.attr('msgid') || 0;
		var action = 'remove';
		handleMessage(id, action, function(result){
			if (result && result) {
				_this.closest('.media').remove();
			} else {
				
			}
		});
	});


	$(document).on('click', '.loadnumber', function(event) {
		event.preventDefault();
		longPoll();
	});


	$('.loadnumber').trigger('click');



});



