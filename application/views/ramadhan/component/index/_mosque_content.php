<style type="text/css">
	.petugas_div{
		margin-top: 6px;
	}
	.love-love-takjil{
		font-size: 18px; margin-left: 5px;
	}
</style>


<div>
	<div style="margin-top: 60px;">
		<div class="row">
			<div class="col-md-6" style="margin-bottom: 20px">
				<div class="row title_sub_content">
					<div class="col-md-3  col-xs-3">
						<img src="<?=base_url()?>assets/img/submenu/islamic-pray.png" style="height:40px;">
					</div>
					<div class="col-md-9  col-xs-9">
						<div class="part_subtitle">Acara Hari Ini</div>
						<div class="part_description"></div>
					</div>
				</div>
				<div class="body_sub_content">
					<div class="slider_event">
						<div>
							<?php foreach($events as $event){?>
								<div class="broventh_card" style="height: 202px;">
									<h5 style="margin-top: 3px;" class="news_title"><?=strtoupper($event->category)?></h5>
									<div style="height: 100px; overflow: hidden; margin-top: 10px;">
										<img src="<?=base_url()?>assets/img/ramadhan/<?=$event->category?>.png" style="width: 100%;">
									</div>
									<div style="text-align: right;">
										<div class="petugas_div news_title">
											<h6><?=date("H:i", strtotime($event->start))." - ".date("H:i", strtotime($event->end))?></h6>
										</div>
										<?php if($event->penceramah){?>
											<div class="petugas_div">
												<h6>Penceramah:</h6>
												<h6 class="news_title"><b><?=$event->penceramah?></b></h6>
											</div>
										<?php }?>
										<?php if($event->imam){?>
											<div class="petugas_div">
												<h6>Imam:</h6>
												<h6 class="news_title"><b><?=$event->imam?></b></h6>
											</div>
										<?php }?>
									</div>
								</div>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6" style="margin-bottom: 20px">
				<div class="row title_sub_content">
					<div class="col-md-3 col-xs-3">
						<img src="<?=base_url()?>assets/img/submenu/islamic-ramadan.png" style="height:40px;">
					</div>
					<div class="col-md-9 col-xs-9">
						<div class="part_subtitle">Menu Takjil</div>
						<div class="part_description"></div>
					</div>
				</div>
				<div class="body_sub_content">
					<div class="slider_takjil">
						<div>
							<?php foreach($takjils as $takjil){?>
								<div class="broventh_card" style="height: 200px;">
									<div style="height: 120px; overflow: hidden;">
										<img src="<?=base_url().$takjil->full_url?>" style="width: 100%; margin-top: -50px;">
									</div>
									<div style="padding-top: 10px; text-align: center;">
										<a onclick="open_detail_content('sharing',<?=$takjil->id?>);">
											<h5 class="news_title center_text"><?=strtoupper($takjil->title)?></h5>
										</a>
									</div>
									<div class="helper_text right_text" style="margin-top: 5px;">
										<h6 style="font-size: 10px;">
											<span style=""><i>Klik love jika kamu suka takjilnya</i></span>
												
											<a onclick="open_feedback_form('')">
												<span style="color: #999" class="glyphicon glyphicon-comment love-love-takjil"></span>
											</a>
											<a onclick="love_takjil(<?=$takjil->id?>)" id="love_is_in_the_air_<?=$takjil->id?>">
												<span style="color: #999" class="glyphicon glyphicon-heart-empty love-love-takjil"></span>
											</a>

										</h6>
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
	// initialize the slider event
	$(".slider_event").diyslider({
	    width: "270px",
	    height: "200px",
	    animationEasing: "swing",
	});

	//$(".slider").diyslider("move", "forth");
	setInterval(function(){
	    $(".slider_event").diyslider("move", "forth");
	}, 5000);


	$(".slider_takjil").diyslider({
	    width: "270px",
	    height: "200px",
	    animationEasing: "linear",
	});

	//$(".slider").diyslider("move", "forth");
	setInterval(function(){
	    $(".slider_takjil").diyslider("move", "forth");
	}, 5000);
</script>