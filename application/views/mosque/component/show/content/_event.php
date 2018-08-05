<?php $user = $this->session->userdata('userbapekis');?>


<div class="row">
	<div class="col-md-8">
		<div class="menu_section_title" style="text-align: left">
			<div>LATEST EVENT</div>
		</div>
		<div>
			<?php if(isset($latest_events))foreach($latest_events as $lat){{?>
				<div class="broventh_card" style="padding: 20px;">
					<div class="news_title">
                        <h3 class="news_title"><a target="_blank" href="<?=base_url()?>calendar/show/<?=$lat['event']->id?>"><?=$lat['event']->title?></a></h3>
                        <div style="margin-top: 5px;" class="helper_text">
							<span class="glyphicon glyphicon-map-marker"></span> <?=$lat['event']->location?>
							<span class="glyphicon glyphicon-time" style="margin-left: 10px;"></span>
							<?=date("j M y",strtotime($lat['event']->start))?>
							<?=(date("Y-m-d",strtotime($lat['event']->start)) != date("Y-m-d",strtotime($lat['event']->end)) || !$lat['event']->end) ? " - ".date("j M y",strtotime($lat['event']->end)) : ""?>
						</div>
                    </div>
                    <div style="margin:20px 0 20px 0;"><p><?php echo $lat['event']->description?></p></div>
                    <div id="lightgallery">
                        <?php foreach($lat['photos'] as $files){?>
                            <div style="width:14%; height:80px; overflow:hidden; float:left; padding:2px;">
                                <a class="item" href="<?php echo base_url()?><?php echo $files->full_url?>" >
                                    <img style="height:100%;" src="<?=base_url().get_thumbnail_src($files->full_url)?>">
                                </a>
                            </div>
                        <?php }?>
                    </div><div style="clear:both"></div>
				</div>
			<?php }}?>
		</div>
	</div>
	<div class="col-md-4">
		<div class="menu_section_title">
			<div>UPCOMING EVENT</div>
		</div>
		<div>
			<?php foreach($upcoming_events as $up){?>
				<div class="broventh_card_square"  style="padding: 0px; background-color: <?=array_color_new(2)?>; ">
					<div class="row">
						<div class="col-xs-3" style="color:white; padding: 20px 20px 20px 20px; text-align: center">
							<h3><?=date("j",strtotime($up->start))?></h3>
							<h5 style="margin-top: 5px;"><?=date("M",strtotime($up->start))?></h5>
						</div>
						<div class="col-xs-9" style="padding: 20px 15px 22px 10px; background-color: white; min-height: 100%;">
							<h4 class="news_title"><?=$up->title?></h4>
							<div style="margin-top: 10px;" class="helper_text">
								<span class="glyphicon glyphicon-map-marker"></span> <?=$up->location?>
							</div>
						</div>
					</div>
					
				</div>
			<?php }?>
		</div>
	</div>
</div>