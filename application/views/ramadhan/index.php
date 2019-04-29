 <!--=============================== Banner ==========================-->
<?=$banner?>
<!-- /.banner -->

<div class="content_bapekis">
	<div class="component_part">
		<div class="component_part_content">
			<div class="row">
				<div class="col-md-5">
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
				<div class="col-md-7">
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