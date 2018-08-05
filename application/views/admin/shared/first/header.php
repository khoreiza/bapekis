<link rel="stylesheet" href="<?=base_url()?>assets/css/shared.css">
<?php 
	$contr = $this->uri->segment(1);
	$func = $this->uri->segment(2);
	$user = $this->session->userdata('userbapekis'); 

	echo $this->load->view('admin/shared/first/component/header/_css','',TRUE);
?>


<div class="navbar-top" style="">
	<div class="row" style="width:100%; max-width: 1500px; margin:0 auto; padding:0px 5px 0px 5px; ">
		<div class="col-md-9 col-sm-8 col-xs-10">
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-3 center_text" style=" margin: 0px 0px 0px 0px;">
					<div style="height: 75px; float: left; width: 100px;">
						<a onclick="openNav()" data-target="#submenuModal">
							<!--<span style="font-size:32px;">CBIC</span>-->
							<div><img style="padding-top:0px; height:75px; max-width: 120px;" src="<?=base_url()?>assets/img/logo-color.png"></img></div>
							<!--<span style="font-size:12px;" class="glyphicon glyphicon-menu-down"></span>-->
						</a>
					</div>
					<div class="small_to_show" style="float: left; width: 70px; height: 60px; padding-left: 10px;">
					</div>
					<div style="clear: both"></div>
				</div>
				<div class="col-md-9 col-sm-6 col-xs-9" style="padding:0px 5px 0px 5px; margin-top: 0px;">
					<div class="input-group right_text" style="float:left; width:100%; max-width: 490px; border-right: 1px solid #e2e2e2; border-left: 1px solid #e2e2e2;">
						<span class="input-group-btn cbic_search_box_addon" id="basic-addon2">
							<span class="glyphicon glyphicon-search" aria-hidden="true" style="font-size:16px !important; color:#828282"></span>
						</span>
						<input onkeyup="search_cbic(event)" id="search_cbic_header" type="text" class="form-control cbic_search_box" placeholder="Search" aria-describedby="basic-addon2" style="height:75px; width:100%;">
					</div><div style="clear:both;"></div>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-4 col-xs-2" style="padding:15px 10px 4px 10px;">
			
			<div style="padding-top: 5px;">
				
				<div style="float:right">
					<button style="margin-top:0px; padding-top:0px;" class="btn btn-link btn-xs dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<div style="height:40px; width:40px; border-radius:40px; overflow:hidden; float:left; border:1px solid #e3e3e3">
							<?=my_photo($user)?>
						</div>
						<div style="clear:both"></div>
					</button>
					<ul id="user_menu_dropdown" class="dropdown-menu pull-right" aria-labelledby="dropdownMenu2">
						<li role="presentation" style="padding:5px 0 5px;">
							<a role="menuitem" tabindex="-1" href="<?php echo base_url()?>admin" style="color:#189cb8;">
								<img style="height:18px; margin-right:10px;" src="<?php echo icon_url('timeline - office.png')?>"> Home
							</a>
						</li>
						<li role="presentation" style="padding:5px 0 5px;">
							<a role="menuitem" tabindex="-1" href="<?php echo base_url()?>mypage" style="color:#189cb8;">
								<img style="height:18px; margin-right:10px;" src="<?php echo icon_url('form - office.png')?>"> My Page
							</a>
						</li>
						<li role="presentation" style="padding:5px 0 5px;">
							<a role="menuitem" tabindex="-1" onclick="show_external_link()" style="color:#189cb8;">
								<img style="height:18px; margin-right:10px;" src="<?php echo icon_url('open browser - office.png')?>"> External Link
							</a>
						</li>
						<li class="divider"></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>feedback" style="color:#189cb8;">
							<span style="margin-right:5px;" class="glyphicon glyphicon-comment" aria-hidden="true"></span> Feedback
						</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>user/change_password" style="color:#189cb8;">
							<span style="margin-right:5px;" class="glyphicon glyphicon-lock" aria-hidden="true"></span> Change Password
						</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>account/logout" style="color:#189cb8;">
							<span style="margin-right:5px;" class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout
						</a></li>
						<?php if(is_user_role($user,"POLICY ADMINISTRATOR") || is_user_role($user,"PERFORMANCE ADMINISTRATOR") || is_user_role($user,"LOG VIEWER")){?>
						<li class="divider"></li>
							<?php if(is_user_role($user,"PERFORMANCE ADMINISTRATOR")){?>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>admin/form_input_file" style="color:#189cb8;">
									<span style="margin-right:5px;" class="glyphicon glyphicon-file" aria-hidden="true"></span> Input File
								</a></li>
							<?php }?>
							<?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>login_photo" style="color:#189cb8;">
								<span style="margin-right:5px;" class="glyphicon glyphicon-star" aria-hidden="true"></span> Login Photo
							</a></li>
							<?php }?>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>user/management" style="color:#189cb8;">
								<span style="margin-right:5px;" class="glyphicon glyphicon-user" aria-hidden="true"></span> User Management
							</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url()?>log_activity" style="color:#189cb8;">
								<span style="margin-right:5px;" class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> User Log
							</a></li>
						<?php }?>
					</ul>
				</div>
				<div class="user_icon_submenu small_to_show" style="float:right; margin: 5px 16px 0; width:130px; max-width: 100%;">
					<div class="row center_text">
						<div class="col-xs-4 submenu_left_not_show submenu_user_notif">
						</div>
						<div class="col-xs-4 submenu_left_not_show submenu_user_notif">
							<div class="border_icon_submenu">
								<a onclick="show_external_link()"><span class="glyphicon glyphicon glyphicon-th" style=""></span></a>
							</div>
						</div>
						<div class="col-xs-4 submenu_left_not_show submenu_user_notif">
							<div class="border_icon_submenu">
								<a href="<?php echo base_url()?>admin"><span class="glyphicon glyphicon-home" style=""></span></a>
							</div>
						</div>
					</div>
				</div>
			</div><div style="clear:both;"></div>
		</div>
	</div>
	
</div>

<div class="second_head">
	<div id="loading_panel" class="center_text loading_panel" style="display:none; padding:5px; z-index:99999999999999 !important; position:fixed; width:100%; background-color:white; margin-top:10%">
		<?php $rand_num = rand(1,7);?>
		<img src="<?=base_url()?>assets/img/loader_images/Preloader_<?=$rand_num?>.gif">
		<div>Loading Data . . .</div>
	</div>
</div>

<?php if(isset($second_header)){echo $second_header;}?>
<script>
	/*$(window).load(function(){
	  $("#header_sticky").sticky({ topSpacing: 0 });
	});*/

	function pop_over_menu(menu,title){
        $('a.notification').webuiPopover('show');
        var num_is_unread = parseInt($('.number_of_notif').text()); 
        if(num_is_unread>0){
        	read_notif();
        }   
    }

	function menu_choice(choice){
		$.ajax({
			type: "GET",
			url: config.base+"home/menu_choice",
			data: {choice:choice},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					bootbox.dialog({
						backdrop: true,
						title: resp.title,
						message: resp.message,
  						
					});
				}else{}
			}
		});
	}
	function search_cbic(e,event,hash){
		var search = $( "#search_cbic_header" ).val();
		//$('#search_result').html(key_in);
		//if(hash && !search){search = hash.split("#")[1];}
		if((search && (e.keyCode === 13 || event == "click"))){
			//alert(search);
			$.ajax({
				type: "POST",
				url: config.base+"search/show_search_result",
				data: {search:search},
				dataType: 'json',
				cache: false,
				success: function(resp){
					if(resp.status==1){
						$('.second_head').html('');
						$('#body-container').html(resp.html);
						//location.hash = search;
					}else{}
				}
			});
		}else{
			//location.reload();
		}
	}
	function change_search_input_type(){
		if($('#sign_search_input').hasClass('glyphicon-calendar')){
			$('#sign_search_input').removeClass('glyphicon-calendar');
			$('#sign_search_input').addClass('glyphicon-font');
			$('#search_cbic_header').datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true,
				todayHighlight: true,

			});
		}else{
			$('#sign_search_input').addClass('glyphicon-calendar');
			$('#sign_search_input').removeClass('glyphicon-font');
			$('#search_cbic_header').datepicker("remove");
		}
	}
</script>