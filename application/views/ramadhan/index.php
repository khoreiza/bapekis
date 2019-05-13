<style type="text/css">
	.no_banner_page{
		padding-top: 130px;
	}
	.title_sub_content .col-md-2{
		max-width: 67.5px;
	}
</style>

<!--=============================== Banner ==========================-->
<?=$banner?>
<!-- /.banner -->

<div class="content_bapekis no_banner_page">
	<div class="component_part">
		<div class="component_part_content">
			<div class="row">
				<div class="col-md-6" style="margin-bottom: 20px">
					<?=$prayer_schedule_view?>
				</div>
				<div class="col-md-6" style="margin-bottom: 20px">
					<div style="text-align: right;">
						<select class="" onchange="get_mosque_show_data()" id="mosque_id">
							<?php foreach($mosques as $mosque){?>
								<option value="<?=$mosque->id?>"><?=$mosque->name?></option>
							<?php }?>
						</select>
					</div>
					<div id="mosque_info_div"></div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-6 col-md-push-6 broventh_right_content">
					<div id="mosque_content_div">
					</div>
					<div id="event_section_div">
						<?=$event_view?>
					</div>
				</div>

				<div class="col-md-6 col-md-pull-6 broventh_left_content">
					<div style="margin-top: 60px;">
						<div class="title_sub_content">
							<div class="row">
								<div class="col-md-2 col-xs-3">
									<img src="<?=base_url()?>assets/img/submenu/quran-rehal.png" style="height:40px;">
								</div>
								<div class="col-md-10 col-xs-9">
									<div class="part_subtitle">Hadist & Ayat Al Qur'an</div>
									<div class="part_description"></div>
								</div>
							</div>
						</div>
						<div class="body_sub_content">
							<?php foreach($hadists as $hadist){?>
								<div>
									<h4 class="news_title"><?=$hadist->title?></h4>
									<div class="right_text" style="margin-top: 20px; font-size: 26px;">
										<p><font face="Arial"><?=$hadist->arabic?></font></p>
									</div>
									<h5>
										<?=$hadist->meaning?>
									</h5>
									<div class="right_text helper_text" style="margin-top: 15px;">
										<h6><?=$hadist->source?></h6>
									</div>
								</div>
								<hr>
							<?php }?>
						</div>
					</div>

					<div style="margin-top: 60px;">
						<div class="title_sub_content">
							<div class="row">
								<div class="col-md-2 col-xs-3">
									<img src="<?=base_url()?>assets/img/submenu/raya-rosary.png" style="height:40px;">
								</div>
								<div class="col-md-10 col-xs-9">
									<div class="part_subtitle">Pernik Ramadhan</div>
									<div class="part_description"></div>
								</div>
							</div>
						</div>
						<div class="body_sub_content">
							<?php foreach($sharings as $sharing){?>
								<div id="mysharing_<?=$sharing->mysharing_id?>" class="col-md-4">
									<div class="">
										<div class="mysharing_member">
						                    <div style="height: 199px; overflow: hidden; ">
						                        
						                        <div style="height: 170px; overflow: hidden;">
						                            <?php if($sharing->full_url){?>
						                                <div style="width: 100%; height: 105px; overflow: hidden; padding: 0px; margin-top: -10p">
						                                    <img id="<?=$sharing->id?>_banner_sharing" style="width: 100%;" src="<?=base_url().$sharing->full_url?>">
						                                </div>
						                            <?php }?>
						                            <div style="margin-top: 10px;">
						                                <div class="helper_text right_text" style="font-size: 10px;"><?=date('j M y', strtotime($sharing->date))?></div>
						                                <?php if($sharing->full_url){?>
						                                    <a onclick="open_detail_content('sharing',<?=$sharing->mysharing_id?>);">
						                                    	<h5 class="news_title" style="margin-top: 5px;"><?= get_long_text_real($sharing->title,106)?></h5>
						                                    </a>
						                                <?php }else{?>
						                                    <h3 class="news_title" style="margin-top: 10px;"><a onclick="show_mysharing_detail(<?php echo $sharing->mysharing_id?>);"><?= get_long_text_real($sharing->title,120)?></a></h3>
						                                    <div style="margin-top: 10px">
						                                        <?php echo long_text_real(strip_tags($sharing->description),180)?>
						                                    </div>
						                                <?php }?>
						                            </div>
						                        </div>
						                    </div>
						                </div>
									</div>
								</div>
							<?php }?>
						</div>
					</div>
				</div>

				
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	get_mosque_show_data();


	function love_takjil(takjil_id){
		$.ajax({
	        type: "GET",
	        url: config.base+"Ramadhan/love_takjil",
	        data: {takjil_id: takjil_id},
	        dataType: 'json',
	        cache: false,
	        success: function(resp){
	            if(resp.status==1){
	                $("#love_is_in_the_air_"+takjil_id).html("<span class='glyphicon glyphicon-heart love-love-takjil' style='color:#c94964''></span>");
	            }else{}
	        }
	    });
	}
	

	function get_mosque_show_data(){
	    var mosque_id = $("#mosque_id").val();

	    $("#loading_panel").show();
	    $.ajax({
	        type: "GET",
	        url: config.base+"Ramadhan/get_mosque_data",
	        data: {mosque_id: mosque_id},
	        dataType: 'json',
	        cache: false,
	        success: function(resp){
	            if(resp.status==1){
	                $("#mosque_content_div").html(resp.mosque_content);
	                $("#mosque_info_div").html(resp.mosque_info);
	                $("#loading_panel").hide();
	            }else{}
	        }
	    });
	}
</script>