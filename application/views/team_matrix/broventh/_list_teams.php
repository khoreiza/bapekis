<?php $user = $this->session->userdata('userdb');?>

<div style="margin-top: 20px;">
    <?php if(isset($teams)){?>
        <div class="section_border_separation_no_border">
            <div>
                <div class="row">
                    <?php foreach($teams as $team){?>
                            <div class="col-md-4 col-sm-6" style="margin-bottom: 10px;" id="team_matrix_div_<?=$team->team_id?>">
                                <div class="photo_frame_circle" style="height: 55px; width:55px;">
                                    <a onclick="show_user_detail(<?=$team->id?>)"><?=employee_photo($team)?></a>
                                </div>
                                <div class="center_text" style="margin-top: 5px">
                                    <h5 style="height: 13px; font-size: 12px; overflow: hidden;"><?php long_text($team->full_name,30)?></h5>
                                    <div class="delete_button" style="font-size: 10px; display: none; padding-top: 2px;">
                                        <h6><a class="delete_color news_title" onclick="delete_team_matrix(<?=$team->team_id?>)">Delete</a></h6>
                                    </div>

                                </div>
                            </div>
                    <?php }?>
                </div>
            </div>
        </div>
    <?php }else{?>
    	<div>
    		<h4 class="helper_text center_text">No Team</h4>
    	</div>
    <?php }?>
</div>