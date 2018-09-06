// starts for the playlist 


function addPlaylist(trackid, playlist, callback)
{
	if (!trackid || !playlist ) { return }
	//var url = weburl+'site/setaction';
	var url = 'playlistaction';
	var data = {
		"trackid"	:trackid,
		"playlist"	:playlist,
	}
	$.ajax({
        type: "POST",
        url: url,
        data: data,
        success:function(resp){
            if (resp && resp != 0) {
                // console.log(resp);
                var items = $.parseJSON(resp);
                //console.log(items);
                if (callback) {
                	callback(items);
                }
            } else {
            }
        },
        error:function(){
            console.log("Failed request data from AJAX request");
        },
        dataType: "json"
    });
}

var trackid = 0;
var parentModal = [];

$(document).on('click', '.song2playlist', function(event) {
    var _this = $(this);
    var timestamp = new Date().getTime();
    trackid = _this.attr('data-trackid');
    var path = weburl+'playlist/list?'+timestamp;
    var frame = $('#playlist-frame');
        frame[0].src = path;

    $('#playlistModal').modal();
    return false;
});

$(document).on('click', '.addtoPlaylist', function(event) {
    var _this = $(this);
    trackid = _this.attr('data-trackid');
 	playlist = _this.attr('playlist-id');
 	addPlaylist(trackid, playlist, function(items){
 		// console.log(items);
 		if (items && items.code == 2) {

 			$('#ModalMessage').find('.heading').text('Warm Notice');
 			$('#ModalMessage').find('.modal-body p').text(items.message);
 			$('#ModalMessage').find('#modalbg').removeClass().addClass('modal-dialog modal-notify modal-warning');
 			$('#ModalMessage').find('.modal-body i').removeClass().addClass('fa fa-bell fa-4x mb-3 animated rotateIn');
 			$('#ModalMessage').find('.modal-footer').html('').html('<a type="button" class="btn btn-warning waves-effect" data-dismiss="modal">CLOSE</a>');
 			$('#ModalMessage').modal();

 			//_this.closest('tr').find('.saved_marks').empty().html('<span class="small">'+items.message+'</span> ');
 		} else if (items && items.code == 1) {

 			$('#ModalMessage').find('.heading').text('Success');
 			$('#ModalMessage').find('.modal-body p').text(items.message);
 			$('#ModalMessage').find('#modalbg').removeClass().addClass('modal-dialog modal-notify modal-success');
 			$('#ModalMessage').find('.modal-body i').removeClass().addClass('fa fa-check fa-4x mb-3 animated rotateIn');
 			$('#ModalMessage').find('.modal-footer').html('').html('<a type="button" class="btn btn-success waves-effect" data-dismiss="modal">CLOSE</a>');
 			$('#ModalMessage').modal();

 			//$('#centralModalSuccess').modal();
 			//_this.closest('tr').find('.saved_marks').empty().html('<i class="fas fa-heart red-text"></i>');
 		} else {

 			$('#ModalMessage').find('.heading').text('Failed');
 			$('#ModalMessage').find('.modal-body p').text(items.message);
 			$('#ModalMessage').find('#modalbg').removeClass().addClass('modal-dialog modal-notify modal-danger');
 			$('#ModalMessage').find('.modal-body i').removeClass().addClass('fa fa-times fa-4x mb-3 animated rotateIn');
 			$('#ModalMessage').find('.modal-footer').html('').html('<a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</a>');
 			$('#ModalMessage').modal();


 			//$('#centralModalDanger').modal();
 			//_this.closest('tr').find('.saved_marks').empty().html(items.message);
 		}
 	});
    return false;
});


$("#playlistModal").on('shown.bs.modal', function(){
    $('#playlist-frame').contents().find('td a').attr('data-trackid', trackid);
});

$('#ModalMessage').on('show.bs.modal', function (e) {
    //alert('modal show');
    //$("#playlistModal").modal('hide');
    // var modal = $(this);
    // modal.find('.heading').text('xxxx');
});



function loadPlaylist() {
	var items = [];
	var elem = $("#user_playlist");
	var cont = $("#playlist_list");
	var url = weburl + 'playlist/getuserplaylist';
	var data = '{}';

	$.ajax({
        type: "POST",
        url: url,
        data: data,
        success:function(resp){
            if (resp && resp != 0) {
                // console.log(resp);
                var items = $.parseJSON(resp);
                //console.log(items);
                // if (callback) {
                // 	callback(items);
                // }
                //var html = '<li>'+items.name+'</li>';
                html = "";
                for(i = 0;i < items.length;i++){
                    var item = items[i];
                    html += '<li id="list-' + item.id+'"><a href="#'+item.id+'" title="'+item.name+'" class="loadSongs" playlist="'+item.id+'">' + item.name +'</a></li>';
                }
                //console.log(html);
                $("#user_playlist").show();
                $(".spinner").hide();
                $("#playlist_list").html(html);

            } else {
            }
        },
        error:function(){
            console.log("Failed request data from AJAX request");
        },
        dataType: "text"
    });
}

$(document).on('click', '.loadSongs', function(event) {

	$('.sm2-playlist-wrapper .sm2-playlist-bd').html('').html('<div class="spinner"></div>');
	var _this = $(this);
	var playlist = _this.attr('playlist');
	var url = weburl + 'playlist/getsongs';
	var data = {"playlist":playlist};

	$.ajax({
        type: "POST",
        url: url,
        data: data,
        success:function(resp){
            if (resp && resp != 0) {
                // console.log(resp);
                var items = $.parseJSON(resp);
                html = "";
                for (var key in items){
				    if (items.hasOwnProperty(key)) {
				         html += '<li id="list-' + items[key]['id']+'"><a href="'+key+'" title="'+items[key]['name']+'" class="" data-trackid="'+items[key]['id']+'">' + items[key]['name'] +'</a></li>';
				    }
				}

                $("#user_playlist").show();
                $(".spinner").hide();
                $(".sm2-playlist-bd").empty().html(html);
                window.sm2BarPlayers[0].playlistController.refresh();
                if (window.sm2BarPlayers[0].playlistController.getItem()) {
                	window.sm2BarPlayers[0].playlistController.playItemByOffset();	
                }
                var menuopen = window.sm2BarPlayers[0].actions.menuOpen();
				if (menuopen) {
                    window.sm2BarPlayers[0].actions.menu();
                    window.sm2BarPlayers[0].actions.menu();
					// $(".sm2-playlist-drawer").height(214);
					//var height = window.sm2BarPlayers[0].dom.playlistContainer.scrollHeight;
					// window.sm2BarPlayers[0].dom.playlistContainer.offsetHeight = $('.sm2-playlist-bd li').height() * $('.sm2-playlist-bd li').length;
				}

            } else {
            	$(".sm2-playlist-bd").html('There is no songs in this list. Please add songs first. <a href="'+weburl+'starter">Go to Library. </a>');
            	//window.sm2BarPlayers[0].pause();
            }
        },
        error:function(){
            console.log("Failed request data from AJAX request");
        },
        dataType: "text"
    });

});


// $(document).on('click', '.trigger', function(event) {
// 	loadPlaylist();
// });
// (function(window) {
// 	loadPlaylist();
// });
// end playlist js