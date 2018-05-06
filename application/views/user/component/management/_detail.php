<style>
	.chartdiv_detail_prod{
        width:100%; height: 150px;
    }

    .broventh_submenu_gray{
    	margin: 20px 0 0 0;
    	border:1px solid <?=array_color(10)?>;
    }
    .broventh_submenu_gray_header{
    	border-bottom:1px solid <?=array_color(10)?>; padding: 10px 20px 10px 20px; background-color: #fafafa;
    }
    .training_info .form-control{font-size: 12px;}
</style>

<div>
	<div class="broventh_sidebar" style="padding-left: 10px;">
        <div class="square_box" style="margin-top: 20px; padding: 0 0 10px 0;">
            <div class="square_box_body">
			    <div class="center_text" style="margin-top: 10px;">
			    	<div class="photo_frame_circle" style="height: 60px; width:60px;">
				        <?=employee_photo($profile)?>
				    </div>
			    	<div style="margin-top: 20px;">
			    		<h4><?=$profile->full_name?></h4>
						<h5 style="margin: 5px 0 5px 0;">
							<?= $profile->jabatan; ?>
						</h5>
						<h5 style="margin: 5px 0 15px 0;">
							<?=($profile->nik) ? "Nip. ".$profile->nik : ""?>
						</h5>
						<h6>
							<?=($profile->directorate) ? get_long_text($profile->directorate,100).dot_devider() : "";?>
							<?=($profile->group) ? get_long_text($profile->group,100).dot_devider() : "";?>
							<?=($profile->department) ? get_long_text($profile->department,100) : ""?>

						</h6>
					</div>
					<div style="margin-top: 20px; font-size: 12px; overflow: hidden;">
						<div>
							<span class="glyphicon glyphicon-time" style="margin-right: 5px;"></span>
							<?php echo date('Y')-date_format(date_create($profile->dob),"Y"); ?> th, birthday <?php echo date_format(date_create($profile->dob),"j M y"); ?>
						</div>
						
						<div>
							<span class="glyphicon glyphicon-phone" style="margin-right: 5px;"></span>
							<?=($profile->phone_number) ? $profile->phone_number : ""?>
							
						</div>
						
						<div>
							<span class="glyphicon glyphicon-envelope" style="margin-right: 5px;"></span>
							<a mailto="<?=$profile->email?>"><?=long_text_real($profile->email,100)?></a>
						</div>
					</div>
					<div>
						<hr>
						<div>
							<a onclick="change_user_status(<?= "'".$profile->status."',".$profile->id;?>)" id="btn_status_account_<?=$profile->id?>" class="btn btn-broventh btn-<?=($profile->status == 'active') ? 'fourth' : 'fifth'?>"><?=($profile->status == "active") ? "Disable" : "Enable"?></a>
							<a id="btn_reset_user" class="btn btn-broventh btn-second" onclick="reset_password('<?=$profile->username?>')">Reset Pass</a>
						</div>
					</div>
			    </div>
			</div>
		</div>
	</div>
</div>
           
<script>
	$(document).ready(function () {         
        //$('.column').theiaStickySidebar({additionalMarginTop: 76});
        $('#table_list_training').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                //'pageLength',
                //'excelHtml5',
            ],
            pageLength:5,
            pagingType:'simple',
        } );
    });
</script>