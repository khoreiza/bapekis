<style type="text/css">
	.no_banner_page{
		padding-top: 130px;
	}
</style>

<!--=============================== Banner ==========================-->
<?=$banner?>
<!-- /.banner -->

<div class="content_bapekis no_banner_page">
	<div class="component_part">
		<div class="component_part_content">
			<div class="row">
				<div class="col-md-6 broventh_left_content">
					<div style="height: 180px;">
					</div>

					<div style="margin-top: 60px;">
						<div class="sub_menu_title_div">
							<div class="row">
								<div class="col-md-2">
									<img src="<?=base_url()?>assets/img/general/book border.png" style="height:40px;">
								</div>
								<div class="col-md-10">
									<div class="part_subtitle">Hadist & Ayat Al Qur'an</div>
									<div class="part_description"></div>
								</div>
							</div>
						</div>
						<div class="sub_menu_body_div">
							<?php foreach($hadists as $hadist){?>
								<div>
									<?=$hadist->description?>
								</div>
								<hr>
							<?php }?>
						</div>
					</div>

					<div style="margin-top: 60px;">
						<div class="sub_menu_title_div">
							<div class="row">
								<div class="col-md-2">
									<img src="<?=base_url()?>assets/img/general/Logo ketupat.png" style="height:40px;">
								</div>
								<div class="col-md-10">
									<div class="part_subtitle">Pernik Ramadhan</div>
									<div class="part_description"></div>
								</div>
							</div>
						</div>
						<div class="sub_menu_body_div">
							<?php foreach($sharings as $sharing){?>
								<div id="mysharing_<?=$sharing->mysharing_id?>" class="col-md-4">
									<div class="">
										<div class="mysharing_member">
						                    <div style="height: 299px; overflow: hidden; ">
						                        
						                        <div style="height: 270px; overflow: hidden;">
						                            <?php if($sharing->full_url){?>
						                                <div style="width: 100%; height: 105px; overflow: hidden; padding: 0px; margin-top: -10p">
						                                    <img id="<?=$sharing->id?>_banner_sharing" style="height: 100%;" src="<?=base_url().$sharing->full_url?>">
						                                </div>
						                            <?php }?>
						                            <div style="margin-top: 10px;">
						                                <div class="helper_text right_text" style="font-size: 10px;"><?=date('j M y', strtotime($sharing->date))?></div>
						                                <?php if($sharing->full_url){?>
						                                    <h5 class="news_title" style="margin-top: 5px;"><a onclick="show_mysharing_detail(<?php echo $sharing->mysharing_id?>);"><?= get_long_text_real($sharing->title,106)?></a></h5>
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
				<div class="col-md-6 broventh_right_content">
					<div style="text-align: right;">
						<select class="" onchange="get_mosque_show_data()" id="mosque_id">
							<?php foreach($mosques as $mosque){?>
								<option value="<?=$mosque->id?>"><?=$mosque->name?></option>
							<?php }?>
						</select>
					</div>
					<div id="mosque_data_content_div">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	get_mosque_show_data();



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
	                $("#mosque_data_content_div").html(resp.mosque_content);
	                $("#loading_panel").hide();
	            }else{}
	        }
	    });
	}
</script>