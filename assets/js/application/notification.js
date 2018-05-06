// *** comment *** //
function notify_comment(kind, ownership_type, ownership_modul, ownership_submodul, ownership_id, message, url, position, position_name){
	var tkind = kind;
	var townership_type = ownership_type;
	var townership_modul = ownership_modul;
	var townership_submodul = ownership_submodul;
	var townership_date = '';
	var townership_id = ownership_id;
	var tmessage = message;
	var turl = url;
	if(tkind=='date'){
		townership_date = ownership_id;
		townership_id = 0;
	}else if(tkind=='modul'){
		townership_modul = ownership_id;
		townership_id = 0;
	}else{
		townership_id = ownership_id;
	}

	if(ownership_modul!==null && ownership_modul!=''){
		townership_modul = ownership_modul;
	}
	if(ownership_submodul!==null && ownership_submodul!=''){
		townership_submodul = ownership_submodul;
	}

	var comment_type = 'general';

	if(townership_type=='activity_steps' || townership_type=='account_planning'){
		comment_type = townership_type;
	}

	var data = {
		type : 'comment',
		comment_type: comment_type,
		modul : townership_type, // padanan modul -- ownership type
		modul_id : townership_modul, // padanan modul_id -- ownership modul
		submodul : townership_submodul, // padanan submodul_id --  
		submodul_id : townership_id,
		modul_date : townership_date,
		message : message,
		url : url,
		position: position,
		position_name: position_name
	};
	
	socket.emit('notif',data);
}

// *** General notification by user_list *** //
function notify_by_user(type, message, url, list_user){
	/**
	* type 		: MANDATORY, general (classification of notification except comment or chat e.g page, article, etc)
	* message 	: MANDATORY, template message will be viewed by user, this following pattern will be replaced by its relevant value
	*	-from- 		=> notified_by 
	*	-modul-		=> ownership_modul
	*	-submodul-	=> ownership_submodul
	*	-time-		=> created date
	*	e.g : Anda mendapatkan permintaan -modul- dengan spesifikasi -submodul- dari -from- pada -time-
	*	appeared notif : Anda mendapatkan permintaan GS dengan spesifikasi permohonan uang dp dari Antonius Kunta pada 10 September 2017 09:00
	* url 		: MANDATORY, once notified user click this notif, webpage will redirect to this url, otherwise no further action will be triggered
	* user		: MANDATORY, it may consist of list ([nik1,nik2,nik3]) or single user (nik1)
	*/
	var data = {
		type : type,
		message : message,
		url : url,
		list_user: list_user
	};
	console.log(data);
	socket.emit('notif',data);
}


// *** General notification by user_list *** //
function notify(type, message, url, position, position_name, jabatan, list_user){
	/**
	* type 		: MANDATORY, general (classification of notification except comment or chat e.g page, article, etc)
	* message 	: MANDATORY, template message will be viewed by user, this following pattern will be replaced by its relevant value
	*	-from- 		=> notified_by 
	*	-modul-		=> ownership_modul
	*	-submodul-	=> ownership_submodul
	*	-time-		=> created date
	*	e.g : Anda mendapatkan permintaan -modul- dengan spesifikasi -submodul- dari -from- pada -time-
	*	appeared notif : Anda mendapatkan permintaan GS dengan spesifikasi permohonan uang dp dari Antonius Kunta pada 10 September 2017 09:00
	* url 		: MANDATORY, once notified user click this notif, webpage will redirect to this url, otherwise no further action will be triggered
	* user		: MANDATORY, it may consist of list ([nik1,nik2,nik3]) or single user (nik1)
	*/
	var data = {
		type : type,
		message : message,
		position: position,
		position_name : position_name,
		jabatan : jabatan,
		url : url,
		list_user: list_user
	};
	
	socket.emit('notif',data);
}


function parse_notification(data){
	var html = ''; var num_is_unread = 0; var url = '#'; var onclick = 'return false'; var is_read = '';
	if(data.length>0){
		$.each( data, function( key, val ) {
			if(data[key].notify_by=='activity_steps'){
				data[key].profile_picture_by = data[key].notify_by;
			}
			if(data[key].is_read==0){
				num_is_unread = num_is_unread + 1;
				is_read = 'notif unread';
			}else{
				is_read = 'notif read';
			}
			if(data[key].url!='' && data[key].url!==null){
				url = data[key].url;
			}
	        html = html + 
	        '<div onclick="redirect_notif(this)" class="'+is_read+'" id="'+data[key].random_code+'" style="margin:-9px 0 -9px 0">' +
				'<input id="url_'+data[key].random_code+'" type="hidden" value="'+data[key].url+'" />'+
				'<div>' +
					'<div class="row notification_active" style="padding: 15px 5px 10px 5px; margin: 0 -12px 0px -12px; border-bottom: 1px solid #e2e2e2;">' +
						'<div class="col-sm-2">' +
							'<div class="photo_frame_circle" style="width: 35px; height: 35px;">'+
								my_photo(data[key].profile_picture_by, data[key].notify_by) +
							'</div>' +
						'</div>' +
						'<div class="col-sm-10" style="font-size: 12px;">'+
							data[key].message.replace('-time-',moment.tz(data[key].date_created,'Asia/Jakarta').format('DD MMM hh:mm A'))+
						'</div>' +
					'</div>' +
				'</div>' +
			'</div>'
	    });
	}
	$('.number_of_notif').html(num_is_unread);
	$('.webui-popover-content').html(html);

	var settings = {
            title:'Your Notification',
            content:html,
            trigger:'manual',
            width:'400px',
            closeable:true,
            animation:'pop',
            dismissible:true,
            placement: 'bottom-left'
        }
    $('a.notification').webuiPopover(settings);
    //$('a.notification').webuiPopover('show'); 
}

function parse_notif(data){
	//console.log(data);
	var html = ''; var num_is_unread = parseInt($('.number_of_notif').text()); var url = '#'; var onclick = 'return false'; var is_read = '';
	if(data!=null && data!='' && typeof data !== 'undefined'){
		if(data.is_read==0){
			num_is_unread = num_is_unread + 1;
			is_read = 'notif unread';
		}else{
			is_read = 'notif read';
		}
		if(data.url!='' && data.url!==null){
			url = data.url;
		}
		if(data.notify_by=='activity_steps'){
			data.profile_picture_by = data.notify_by;
		}
        html = html + 
        '<div onclick="redirect_notif(this)" class="'+is_read+'" id="'+data.random_code+'" style="margin:-9px 0 -9px 0">' +
			'<input id="url_'+data.random_code+'" type="hidden" value="'+data.url+'" />'+
			'<div>' +
				'<div class="row notification_active" style="padding: 15px 5px 10px 5px; margin: 0 -12px 0px -12px; border-bottom: 1px solid #e2e2e2;">' +
					'<div class="col-sm-2">' +
						'<div class="photo_frame_circle" style="width: 35px; height: 35px;">'+
							my_photo(data.profile_picture_by, data.notify_by) +
						'</div>' +
					'</div>' +
					'<div class="col-sm-10" style="font-size: 12px;">'+
						data.message.replace('-time-',moment.tz(data.date_created,'Asia/Jakarta').format('DD MMM hh:mm A'))+
					'</div>' +
				'</div>' +
			'</div>' +
		'</div>';
		$('.number_of_notif').html(num_is_unread);
		$('.webui-popover-content').prepend(html);
		$('a.notification').webuiPopover('show'); 
	}
}

function read_notif(){
	socket.emit('update_notif');
}

function redirect_notif(element){
	window.location = config.base + $('#url_'+element.id).val();
}


function update_notif(data){
	var num_is_unread = parseInt($('.number_of_notif').text()); 
	$('#'+data.random_code).removeClass('unread').addClass('read');
	$('.number_of_notif').html(num_is_unread-1);
}

function update_all_notif(data){
	$('.notif').removeClass('unread').addClass('read');
	$('.number_of_notif').html(0);
}