<style type="text/css">
	.petugas_div{
		margin-top: 10px;
	}
</style>


<div style="margin-top: 20px;">
	<div class="row">
		<div class="col-md-7">
			<h3><?=$mosque->name?></h3>
			<h5 style="margin-top: 10px;"><?=$mosque->location?></h5>
		</div>
		<div class="col-md-5">
			<div style="">
				<img style="width: 100%;" src="<?=base_url().$mosque->full_url?>">
			</div>
		</div>
	</div>

	<div style="margin-top: 60px;">
		<div class="row">
			<div class="col-md-6">
				<div class="row title_sub_content">
					<div class="col-md-3">
						<img src="<?=base_url()?>assets/img/general/Logo people.png" style="height:40px;">
					</div>
					<div class="col-md-9">
						<div class="part_subtitle">Acara Hari Ini</div>
						<div class="part_description"></div>
					</div>
				</div>
				<div class="body_sub_content">
					<?php foreach($events as $event){?>
						<div class="broventh_card" style="height: 200px;">
							<h4 class="news_title"><?=strtoupper($event->category)?></h4>
							<div style="margin-top: 50px;">
								<?php if($event->penceramah){?>
									<div class="petugas_div">
										<h5>Penceramah:</h5>
										<h5><b><?=$event->penceramah?></b></h5>
									</div>
								<?php }?>
								<?php if($event->imam){?>
									<div class="petugas_div">
										<h5>Imam:</h5>
										<h5><b><?=$event->imam?></b></h5>
									</div>
								<?php }?>
								<?php if($event->muadzin){?>
									<div class="petugas_div">
										<h5>Muadzin:</h5>
										<h5><b><?=$event->muadzin?></b></h5>
									</div>
								<?php }?>
							</div>
						</div>
					<?php }?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row title_sub_content">
					<div class="col-md-3">
						<img src="<?=base_url()?>assets/img/general/book border.png" style="height:40px;">
					</div>
					<div class="col-md-9">
						<div class="part_subtitle">Menu Takjil</div>
						<div class="part_description"></div>
					</div>
				</div>
				<div class="body_sub_content">
					<?php foreach($takjils as $takjil){?>
						<div class="broventh_card" style="height: 200px;">
							<div style="height: 120px; overflow: hidden;">
								<img src="<?=base_url().$takjil->full_url?>" style="width: 100%;">
							</div>
							<div style="padding-top: 10px; text-align: center;">
								<h4 class="news_title center_text"><?=strtoupper($takjil->title)?></h4>
							</div>
							<div class="helper_text right_text" style="margin-top: 15px;">
								<h6><i>Klik love jika kamu suka takjilnya</i></h6>
							</div>
						</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>