 <!--=============================== Banner ==========================-->
<?=$banner?>
<!-- /.banner -->

<div class="content_bapekis">
	<div class="component_part">
		<div class="component_part_content">
			<div class="row">
				<div class="col-md-6">
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
				<div class="col-md-6">
					
				</div>
			</div>











			<div class="row" style="margin-top: 400px;">
				<div class="col-md-1">
					<img src="<?=base_url()?>assets/img/general/Logo people.png" style="height:80px;">
				</div>
				<div class="col-md-11">
					<div class="part_title">STRUKTUR ORGANISASI</div>
					<div class="part_description">
						<?php /*<div style="margin-top: 20px;">
							<img src="<?=base_url()?>assets/img/general/SO.png" style="width:100%;">
						</div>*/ ?>

						<div class="" style="margin-top: 40px;">
			                <div class="broventh_submenu_title no_border">
			                </div>
			                <div class="broventh_submenu_body">
			                    <div id="list_of_member">
			                        <div id="ceo" style="padding: 0 40px 0 40px">
			                            <div class="row">
			                                <div class="col-md-3">
			                                    <div class="photo_frame_circle" style="width: 180px; height: 180px; margin: 0px 10px 0 0px; float: left;">
			                                        <?=employee_photo($members[0])?>
			                                    </div>
			                                </div>
			                                <div class="col-md-9">
			                                    <h4><?=$members[0]->jabatan?></h4>
			                                    <h2 class="news_title" style="margin:5px 0 25px 0"><?=$members[0]->full_name?></h2>
			                                    <h4><?=$members[0]->description?></h4>
			                                </div>
			                            </div>
			                        </div>
			                        <div style="margin-top: 40px;">
			                            <div class="row">
			                                        <?php unset($members[0]); $prev_group=""; foreach($members as $member){?>
			                                            <?php if($prev_group != $member->group){?>
			                                                <?php if($prev_group){?>
			                                                        </div>
			                                                    </div>
			                                                <?php }?>
			                                            <div class="col-md-6">
			                                                
			                                                <div class="row">
			                                            <?php }?>
			                                                    <div class="col-xs-6" style="margin: 20px 0 40px 0;">
			                                                        <div class="center_text">
			                                                            <div class="photo_frame_circle" style="width: 140px; height: 140px; margin:0 auto; margin-bottom: 10px;">
			                                                                <?=employee_photo($member)?>
			                                                            </div>
			                                                            <div style="text-align: center;">
			                                                                <h4 class="news_title"><?=$member->full_name?></h4>
			                                                                <h5 style="margin-top: 5px;"><?=$member->jabatan?></h5>
			                                                                <h5 style="margin-top: 5px; height: 20px;"><?=($prev_group != $member->group) ? get_long_text($member->group,100) : ''?></h5>
			                                                            </div>
			                                                        </div>
			                                                    </div>
			                                        <?php $prev_group = $member->group;}?>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>