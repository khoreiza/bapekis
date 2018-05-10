<?php $photo_folder = "assets/uploads/calendar/documentation/";?>
<div class="broventh_submenu_div" style="margin-top: 30px;">
    <div class="broventh_submenu_title no_border">
        <div>
            <div>
                <span class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;"><span class="glyphicon glyphicon-picture"></span></span>
                Latest Event
            </div>
        </div>
    </div>
    <div class="broventh_submenu_body">
        <?php foreach($latest_events as $row){?>
			<div class="broventh_card">
				<a onclick="show_calendar_detail(<?php echo $row['cal']->id?>)">
					<div style="">
						<div style="margin-bottom:10px; font-size:16px">
							<h5 class="news_title"><?= get_long_text_real($row['cal']->title,80)?></h5>
						</div>
					</div>
					<div style="padding-bottom:10px; margin-bottom:5px;">
						<?php $i=0; foreach($row['file'] as $file){?>
							<div style="width:25%; height:40px; overflow:hidden; float:left; padding:2px;">
								<img style="width:100%;" src="<?php echo base_url().$photo_folder?><?php echo $file->ownership_id."/thumb/".$file->file_name?>_thumbnail.jpg">
							</div>
						<?php $i++; if($i>3){break;}}?><div style="clear:both"></div>
					</div>
					<div class="right_text third_font" style="font-size:10px" class="helper-text"><?php echo date('j M y', strtotime($row['cal']->start))?></div>
				</a>
			</div>
		<?php }?>
    </div>
</div>
        