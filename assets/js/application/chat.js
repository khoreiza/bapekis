function draw_whoisonline(data){
	var items = "";
	console.log(data);
	if(data!==null && data!=undefined){
		$.each( data.list_user, function( key, val ) {
	        if(val.nik!=vuser.nik){
	            items = items + '<input type="hidden" id="div_'+val.nik+'" value="'+val.nik+'" >';
	        }
	    });
	}
	$("#div_list_of_user_online").html(items);
}
function handle_list_whoisonline(data){
	var items = "";
    $.each( data.list_user, function( key, val ) {
        if(val.nik!=vuser.nik){
            items = items + '<div id="'+ val.nik +'" class="row request_conversation" style="margin-bottom: 20px;">' +
				                '<div class="col-xs-2">' +
				                    '<div class="photo_frame_circle" style="width: 25px; height: 25px; margin-top: 5px;">' +
				                        my_photo(val.profile_picture, val.nik) +
				                    '</div>' +
				                '</div>' + 
				                '<div class="col-xs-10">' +
				                    '<a>' +
				                        '<h5 class="news_title">'+val.full_name+'</h5>' +
				                        '<h6 class="third_font">' +
				                            val.jabatan +
				                        '</h6>' +
				                    '</a>' +
				                '</div>' +
				           '</div>';
        }
    });
	$("#box_list_of_user_online").html(items);
	refresh_online();
}

function handle_whoisonline(list_nik){
	//console.log('handle who is online');
	var retrievedObject = localStorage.getItem('whoisonline');
	$.each( list_nik, function( key, val ) {
        if(val!=vuser.nik){
        	var ro =  JSON.parse(retrievedObject);
			var res = filterJsonObject(ro, val);
			if(res.length==1){
				res = res[0];
				var item = '<div id="'+ res.nik +'" class="row request_conversation" style="margin-bottom: 20px;">' +
			                '<div class="col-xs-2">' +
			                    '<div class="photo_frame_circle" style="width: 25px; height: 25px; margin-top: 5px;">' +
			                        my_photo(res.profile_picture, res.nik) +
			                    '</div>' +
			                '</div>' + 
			                '<div class="col-xs-10">' +
			                    '<a>' +
			                        '<h5 class="news_title">'+res.full_name+'</h5>' +
			                        '<h6 class="third_font">' +
			                            res.jabatan +
			                        '</h6>' +
			                    '</a>' +
			                '</div>' +
			           '</div>';
			    var prev_nik = $( $('#div_'+res.nik).prev() ).val();
			    var next_nik = $( $('#div_'+res.nik).next() ).val();
			    //console.log(prev_nik); console.log(next_nik);
			    if( prev_nik!==undefined ){
			    	//console.log('prev nik');
			    	$('#'+prev_nik).after(item);
			    }else{
			    	//console.log('next nik');
			    	$('#'+next_nik).before(item);
			    }
			}
            
        }    
    });
    refresh_online();
}


function handle_whoisoffline(list_nik){
	//console.log('handle who is offline');
	$.each( list_nik, function( key, val ) {
        if(val!=vuser.nik){
        	//console.log(val);
            $('#'+val).remove();
        }    
    });
    refresh_online();
}


function calculate_online_user(data){
	var num_online = data.n;
	if(num_online==1){
        $("#length_user_online").html('No Online User');    
    }else if(num_online==2){
        $("#length_user_online").html('1 user online');
    }else{
    	num_online = num_online - 1;
        $("#length_user_online").html(''+num_online+' users online');
    }
}

function handle_conversation(data){
	if(jQuery.isEmptyObject(data)){
    }else{
        if($("#conversation_"+data.conv_id).length === 0){
            render_conversation(data);
        }
        render_messages(data);
    }
}

function handle_msg(data){
	console.log('handle msg'); console.log(data);
	if(jQuery.isEmptyObject(data)){
    }else{
        if($("#conversation_"+data.conv_id).length === 0){
            if(data.user_id == vuser.nik){
                vdata['tuser'] = data.user_id2;
            }else{
                vdata['tuser'] = data.user_id;
            }
            request_conversation(vdata);
        }else{
            render_message(data);
        }
    }
}

function request_conversation(data){
	socket.emit('request_conversation',data);
}

function refresh_online(){
	//console.log('funct refresh_online');
	$(document).ready(function() {
		$('.request_conversation').on('click', function(event) {
			vdata['tuser'] = this.id;
			console.log(vdata);
			request_conversation(vdata);
		});
	});
}

function render_conversation(data){
	var itr = parseInt($('#box_iteration').val()); // console.log(itr);
	var gap = itr * 20;
	if(itr>4){
		itr=0;
		gap=0;
	}else{
		itr=itr+1;
	}
	var box_conversation = 
	'<div style="right: '+gap+'%;" class="fixed_in_bottom chat_box_cbic" id="div_conv_'+itr+'">'+
	    '<div class="floating_footer_box_component" id="conversation_'+data.conv_id+'" >'+
	        '<input type="hidden" value=0 id="last_message_id_'+data.conv_id+'">'+
	        '<input type="hidden" value="'+data.tuser+'" id="to_message_'+data.conv_id+'">'+
        	'<div class="row box_header chat_header">' +
        		'<div class="col-md-10"><a onclick="toggle_visibility(\'body_chat_box_'+data.conv_id+'\')" class="news_title">'+data.tfull_name+'</a></div>'+
        		'<div class="col-md-2 right_text"><a href="#"><span class="glyphicon glyphicon-remove icon_close" id="chat_window_'+data.conv_id+'"></span></a></div>'+
        	'</div>'+
        	'<div class="body_chat_box" id="body_chat_box_'+data.conv_id+'">'+
        	'<div style="padding: 10px;" id="header_conversation_'+data.conv_id+'">' +
        		'<div class="row" style="padding-bottom: 10px;">' +
					'<div class="col-xs-3">' +
						'<div class="photo_frame_circle" style="width: 35px; height: 35px;">' +
							my_photo(data.tprofile_picture, data.tnik) +
						'</div>' +
					'</div>' +
					'<div class="col-xs-9">' +
						'<h4 class="news_title">'+data.tfull_name+'</h4>' +
						'<h6 class="third_font">'+data.tjabatan+'</h6>'+
					'</div>' +
				'</div>' +
        	'</div>'+
        	'<div class="chat_conversation_box" id="body_conversation_'+data.conv_id+'">' +
        	'</div>' +
        	'<div class="panel-footer">' +
                '<div class="input-group">' +
                    '<input id="message_'+data.conv_id+'" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />' +
                    '<span class="input-group-btn">' +
                    '<button class="btn btn-primary btn-sm" id="btn_message_'+data.conv_id+'">Send</button>' +
                    '</span>' +
                '</div>' +
            '</div>' +
	    '</div>' +
    '</div>';
	$('#person_chat_box').append(box_conversation);
	$(document).on('click', '#new_chat', function (e) {
	    var size = $( ".chat-window:last-child" ).css("margin-left");
	    size_total = parseInt(size) + 400;
	    alert(size_total);
	    var clone = $( "#conversation_"+data.conv_id).clone().appendTo( ".container" );
	    clone.css("margin-left", size_total);
	});
	$(document).on('click', '#chat_window_'+data.conv_id, function (e) {
	    $("#div_conv_"+itr).remove();
	    itr = itr - 1; $('#box_iteration').val(itr);
	});
	$("#btn_message_"+data.conv_id).click(function() {
	  	 send_message(data.conv_id);
	});
	$('#message_'+data.conv_id).keypress(function(e) {
	    if(e.which == 13) {
	        send_message(data.conv_id);
	    }	
	});
	$('#box_iteration').val(itr);
}

function render_messages(data){
	var message = '';
	if(data.num_of_msg>0){
		//$('#last_message_id_'+data.conv_id).val(data.messages[data.num_of_msg-1].id);
		$.each( data.messages, function( key, val ) {
            //items = items + "<div class='request_conversation'><a><h5 id="+val.nik+">"+val.full_name+"</h5></a></div>";
        	if(val.user_id == data.fuser){
        		// to
	        	message = message + 
	        	'<div class="chat_bubble">' +
					'<div class="chat_to">'+val.message+'</div>'+
					'<div style="clear:both"></div>' +
					'<div class="right_text"><time class="msg_time" datetime="'+val.date_created+'">'+moment.tz(val.date_created.toString(),'Asia/Jakarta').format('hh:mm A')+'</time></div>'+
				'</div>';
        	}else{
        		// from
	        	message = message + 
	        	'<div class="chat_bubble">' +
					'<div class="chat_from">'+val.message+'</div>'+
					'<div style="clear:both"></div>' +
					'<time class="msg_time" datetime="'+val.date_created+'">'+moment.tz(val.date_created.toString(),'Asia/Jakarta').format('hh:mm A')+'</time>'+
				'</div>';

        	}
        });		
	}
	$("#body_conversation_"+data.conv_id).html(message);
}

function send_message(conv_id){
	var msg = $('#message_'+conv_id).val();
	var tuser = $('#to_message_'+conv_id).val(); console.log('tuser'); console.log(tuser);
	var data = {};
	if(msg!='' && msg!==null){
		data['message'] = msg; data['conv_id'] = conv_id; data['tuser'] = tuser;
		socket.emit('message',data);
		$('#message_'+conv_id).val('');
	}
}

function render_message(data){
	var message = '';
	if(jQuery.isEmptyObject(data)){
	}else{
		if(data.user_id == vuser.nik){
        	message = message + 
        	'<div class="chat_bubble">' +
				'<div class="chat_to">'+data.message+'</div>'+
				'<div style="clear:both"></div>' +
				'<div class="right_text"><time class="msg_time" datetime="'+data.date_created+'">'+moment.tz(data.date_created.toString(),'Asia/Jakarta').format('hh:mm A')+'</time></div>'+
			'</div>';
    	}else{
			message = message + 
        	'<div class="chat_bubble">' +
				'<div class="chat_from">'+data.message+'</div>'+
				'<div style="clear:both"></div>' +
				'<time class="msg_time" datetime="'+data.date_created+'">'+moment.tz(data.date_created.toString(),'Asia/Jakarta').format('hh:mm A')+'</time>'+
			'</div>';
    	}
    	$("#body_conversation_"+data.conv_id).append(message);
	}
}

function socket_logout(){
	socket.emit('logout',vdata);
}


function get_diff(array1, array2){
	var difference = [];
	jQuery.grep(array2, function(el) {
	    if (jQuery.inArray(el, array1) == -1) difference.push(el);
	});
	return difference;
}

function get_online(p, n){
	return get_diff(p, n);
}

function get_offline(p, n){
	return get_diff(n, p);
}

function filterJsonObject(arr, searchKey) {
  return arr.filter(function(obj,idx) {
    return Object.keys(obj).some(function(key) {
        var lkey = obj[key].toLowerCase();
        return lkey.includes(searchKey.toLowerCase());
    })
  });
}

function search_whoisonline(value){
	if(value.length == 0){
   		$('.request_conversation').removeClass('hide');
   	}else{
		var retrievedObject = localStorage.getItem('whoisonline');
		if(retrievedObject!==null){
			var ro =  JSON.parse(retrievedObject);
			var res = filterJsonObject(ro, value);
			$('.request_conversation').addClass('hide');
			res.forEach(function(item){
				$('#'+item.nik).removeClass('hide');
			});
		}
	}
}