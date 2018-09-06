if (!window.external) {
	window.external = {};
}
if (!window.external.db) {
	window.external.db = {};
}

var weburl = 'http://localhost/music/';


// function log(text) {
// 	if (!console) return;
// 	var date = new Date();
// 	var time = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
// 	time += ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
// 	time += '.' + date.getMilliseconds();
// 	console.log(time + ' ' + text + ' ' + location.href);
// }

// function WebAppDatabase(sql, argv, callback, options) {
//     if (typeof(sql) == 'object') {
//         argv = sql.argv;
//         callback = sql.callback;
//         options = sql.options;
//         sql = sql.sql;
//     }
//     if (!options) options = {};
//     var database = options.database || 'WebAppDatabase';
//     var db = window.external.db[database];
//     if (!db) {
//         var version = options.version || '1.0';
//         var description = options.description || 'Offline data storage';
//         var estimatedSize = options.estimatedSize || (5*1024*1024);
//         try {
//             db = openDatabase(database, version, description, estimatedSize);
//             window.external.db[database] = db;
//         } catch (e) {
//             log('WebAppDatabase[' + e + ']');
//             if (callback) callback(false, e);
//             return false;
//         }
//     }
//     if (!db) { return false; }
//     log('WebAppDatabase[' + database + ']');
//     if (sql) { 
//         db.transaction(function(t) {
//             log('WebAppDatabase[' + sql + ']');
//             t.executeSql(sql, argv, function(t, data) {
//                 log('WebAppDatabase[ok ' + data.rows.length + ']');
//                 if (callback) callback(true, data, t);
//                 delete db;
//                 delete window.external.db[database];
//                 //window.external.db[database] = db = null;
//             }, function(t, error) {
//                 log('WebAppDatabase[err:' + error.code  + ' ' + error.message + ']');
//                 if (callback) callback(false, error, t);
//                 delete db;
//                 delete window.external.db[database];
//                 //window.external.db[database] = db = null;
//             });
//         });
//     } else {
//         delete db;
//         delete window.external.db[database];
//         //window.external.db[database] = db = null;
//         return false;
//     }
//     return true;
// }


// function WebAppLocalStorage(key, val) {
//     if (typeof(key) == 'object') {
//         val = key.val;
//         key = key.key;
//     }
//     if (!window.localStorage) return;
//     if (!key) return;
//     if (typeof(val) == 'undefined' || typeof(val) == 'function')    {
//         var result = localStorage.getItem(key);
//         if (val) { val(result); }
//         return result;
//     } else {
//         var result = localStorage.getItem(key);
//         localStorage.setItem(key, val);
//     }
//     var event = document.createEvent("Event"); 
//     event.initEvent("localstorage", true, true);
//     event.key = key;
//     event.newValue = val;
//     event.oldValue = result;
//     event.url = location.href;
//     event.storageArea = 'local';
//     document.dispatchEvent(event);
// }

// function WebAppSessionStorage(key, val) {
//     if (typeof(key) == 'object') {
//         val = key.val;
//         key = key.key;
//     }
//     if (!window.sessionStorage) return;
//     if (!key) return;
//     if (typeof(val) == 'undefined' || typeof(val) == 'function')    {
//         result = sessionStorage.getItem(key);
//         if (val) { val(result); }
//         return result;
//     } else {
//         sessionStorage.setItem(key, val);
//     }
// }

// //delete local storage
// function delLocalStorage(key) {
//     if (!window.external) window.external = {};
//     if (window.localStorage) {
//         if (key) {
//             localStorage.removeItem(key);
//             log('delete localStorage ' + key +'OK');
//             console.log('delete localStorage ' + key +'OK');
//         }
//     }
// }

// //clear local storage
// function clearLocalStorage() {
//     if (!window.external) window.external = {};
//     if (window.localStorage) {
//             localStorage.clear();
//             log('clear localStorage OK');
//             console.log('clear localStorage OK');
//     }
// }

// function createSonglistDatabase(userid, callback, ingore){
// 	if (ingore) {
// 		if(callback)
// 			callback({}, "ok");
// 		return; 
// 	}
// 	var sql = "CREATE TABLE IF NOT EXISTS songlist (trackid TEXT, url TEXT, userid INTEGER, title TEXT)";
// 	var argv = [];
// 	WebAppDatabase(sql, argv, function(result, data) {
// 		if (!result) return;
// 	});
// 	//callback({}, "ok"); //
// }

// function checkSonginlist(userid, trackid, callback){
// 	//createSonglistDatabase(userid);
// 	if (!userid || !trackid) {return};
// 	var sql = "select * from songlist where trackid=? AND userid=?";
// 	var argv = [trackid, userid];
// 	WebAppDatabase(sql, argv, function(result, data) {
// 		if (callback) {
// 			if (result && data.rows.length > 0) {
// 				callback(result ? data.rows.item(0) : 0);
// 			} else {
// 				callback(0);
// 			}
			
// 		}
// 	});
// }

// function getSongList(userid, callback, ingore){
// 	if (ingore) {
// 		if(callback)
// 			callback({}, "ok");
// 		return; 
// 	}
	
// 	createSonglistDatabase(userid);
// 	var sql = "select * from songlist where userid=?";
// 	var argv = [userid];
// 	WebAppDatabase(sql, argv, function(result, data) {
// 		if (!result) return;
// 		// var list = '';
// 		// for (var i = 0; i < data.rows.length; i++) {
// 		// 	var row = data.rows.item(i);
// 		// 	var num = i+1;
// 		// 	list += 
// 		// 		'{"trackid":"'+row['trackid']+
// 		// 		'","url":'+row['url']+
// 		// 		',"userid":'+row['userid']+'}';
// 		// 	if(num < data.rows.length){list += ',';}
// 		// }
// 		if (callback) callback(result, data);
// 	});
// }

// function addToSonglist(track, userid, callback){
// 	createSonglistDatabase(userid);
	
// 	var sql = "insert into `songlist`(trackid, url, userid, title) values (?,?,?,?)";
// 	var argv = [track.trackid, track.url, userid, track.title];
// 	WebAppDatabase(sql, argv, function(result, data) {
// 		if (!result) return;
// 		if (callback) {
// 			if (callback) callback(result, data);
// 		}
// 	});
// }

// function delSongFromlist(userid, trackid, callback){
// 	if (!userid && !trackid) return;
// 	createSonglistDatabase(userid);
// 	var sql = "delete from `songlist` where userid=? AND trackid=?";
// 	var argv = [userid, trackid];
// 	// if(data.contentid && data.type){
// 	// 	sql += " and contentid=? and type=?";
// 	// 	var argv = [phone.imei, data.contentid, data.type];
// 	// }
// 	WebAppDatabase(sql, argv, function(result, data) {
// 		if (!result) return;
// 		if (callback) callback(result, data);
// 	});
// }

// function clearListDB(callback){
//     var sql = "DELETE FROM `songlist` WHERE 1=1";
//     var argv =[];
//     WebAppDatabase(sql, argv, function(result, data) {
//         if (!result) return;
//         if (callback) callback(result, data);
//     });
// }


// // // // // // // // // // // // // // // // // // // 
function playASong(b){
    var url = b.attr('href');
    var title = b.attr('title');
    var trackid = b.attr('data-trackid');
    var html = '';
    $('.sm2-playlist-bd').prepend('<li><div class="sm2-row"><div class="sm2-col sm2-wide"><a href="'+url+'">'+title+'</a></div><div class="sm2-col"><a href="#null" title="remove this song from list" class="remove" data-trackid="'+trackid+'"><span class="glyphicon glyphicon-remove"></span></a></div></div></li>');
    //$('.sm2-playlist-bd').empty().append(html+='<li><div class="sm2-row"><div class="sm2-col sm2-wide"><a href="'+url+'">'+title+'</a></div><div class="sm2-col"><a href="#null" title="remove this song from list" class="remove" data-trackid="'+trackid+'"><span class="glyphicon glyphicon-remove"></span></a></div></div></li>');
    // var menuopen = window.sm2BarPlayers[0].actions.menuOpen();
    // if (menuopen) {
    //     //window.sm2BarPlayers[0].actions.menu();
    //     $(".sm2-playlist-drawer").height(214);
    // }
    window.sm2BarPlayers[0].playlistController.refresh();
    //window.sm2BarPlayers[0].actions.play();
    window.sm2BarPlayers[0].playlistController.playItemByOffset();

}

/*
function addtolist(b){
	var userid = $('.userid').attr('userid');
	var trackid = b.attr('data-trackid');
    var url = b.attr('href');
    var title = b.attr('title');

    //insert into local web sql
    var track = {
    	trackid:trackid,
    	url:url,
    	title:title
    }

    checkSonginlist(userid, trackid, function(result, data){
        if (!result) {
            addToSonglist(track, userid, function(){
                //var html = $('.sm2-playlist-bd').html();
                //$('.sm2-playlist-bd').empty().append(html += '<li><div class="sm2-row"><div class="sm2-col sm2-wide"><a href="'+url+'">'+title+'</a></div><div class="sm2-col"><a href="#" title="remove this song from list" class="remove" data-trackid="'+track.trackid+'"><span class="glyphicon glyphicon-remove"></span></a></div></div></li>').show();
                $('.sm2-playlist-bd').append('<li><div class="sm2-row"><div class="sm2-col sm2-wide"><a href="'+url+'">'+title+'</a></div><div class="sm2-col"><a href="#" title="remove this song from list" class="remove" data-trackid="'+track.trackid+'"><span class="glyphicon glyphicon-remove"></span></a></div></div></li>').show();
                window.sm2BarPlayers[0].playlistController.refresh();
                var menuopen = window.sm2BarPlayers[0].actions.menuOpen();
                if (menuopen) {
                    window.sm2BarPlayers[0].actions.menu();
                    window.sm2BarPlayers[0].actions.menu();
                }
            });
            
        }
    });   
}



function clearList(){
    clearListDB(function(result, data){
        if (!result) {return};
        $('.sm2-playlist-bd').empty();
        window.sm2BarPlayers[0].playlistController.refresh();
        var menuopen = window.sm2BarPlayers[0].actions.menuOpen();
        if (menuopen) {
            window.sm2BarPlayers[0].actions.menu();
        }

        console.log(result, data);
    })
}

function songListInit(){
    var userid = $('.userid').attr('userid');
    getSongList(userid, function(result, data){
        if (result) {
            var list = '';
            for (var i = 0; i < data.rows.length; i++) {
                var row = data.rows.item(i);
                var num = i+1;
                var url = 
                list += 
                    '<li><div class="sm2-row"><div class="sm2-col sm2-wide"><a href="'+row['url']+'" data-trackid="'+row['trackid']+'">'+row['title']+'</a></div><div class="sm2-col"><a href="#songsremove" title="remove this song from list" class="remove" data-trackid="'+row['trackid']+'"><span class="glyphicon glyphicon-remove"></span></a></div></div></li>'
            }
            $(list).appendTo($('.sm2-playlist-bd'));
        }
        
    });
}
*/
function removeFromList(b){
    // var userid = $('.userid').attr('userid');
    // var trackid = b.attr('data-trackid');
    
    // delSongFromlist(userid, trackid, function(result, data){
    //     if (result && data.rowsAffected > 0) {
    //         b.closest('li').remove();
    //         window.sm2BarPlayers[0].playlistController.refresh();
    //     }
    // });

    b.closest('li').remove();
    window.sm2BarPlayers[0].playlistController.refresh();
    
}
$(document).on('click', '.songplaybtn', function(event) {
    playASong($(this));
    return false;
});

// $(document).on('click', '.addtolist', function(event) {
//     addtolist($(this));
//     return false;
// });

$(document).on('click', '.sm2-playlist-bd a.remove', function(event) {
    removeFromList($(this));
    return false;
});

$(document).on('click', '.sm2-icon-clearlist', function(event) {
    if (confirm("Do you really want to clear this list?")) {
        clearList();
    } else {
        return false;
    }
});

$(document).ready(function(){
	//songListInit();
});