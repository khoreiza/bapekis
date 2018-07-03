<?php
    $user = $this->session->userdata('userbapekis');
?>
<form class="form-horizontal form-borventh" 
      action="<?= base_url().'meeting/store_mom'?>" 
      method ="post" id="form_mom" role="form" enctype="multipart/form-data" style="padding: 10px;">

    <input name="meeting_id" id="meeting_id" type="hidden" value="<?=$meeting_id?>">
    <input name="id" id="id" type="hidden" value="<?=(isset($mom) && $mom->id) ? $mom->id : ''?>">
    <input name="status" id="status" type="hidden" value="<?=(isset($mom) && $mom->status) ? $mom->status : ''?>">
    <div class="form_group_part_div" id="form_group_part_div_1" style="display: block;">
        <div class="form_group_part_title">Minutes of Meeting</div>
        <div class="form-group row">
            <div class="col-sm-2"><label class="control-label">Title</label></div>
            <div class="col-sm-10">
                <input type="text" class="form-control-minimalist" placeholder="Title" name="title" value="<?=isset($mom) ? $mom->title : ""?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2"><label class="control-label">Background</label></div>
            <div class="col-sm-10">
                <textarea placeholder="Background" class="form-control-minimalist" name="background" id="background"><?=isset($mom->background) ? $mom->background : ""?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2"><label class="control-label">Pembahasan</label></div>
            <div class="col-sm-10">
                <textarea placeholder="Content" class="form-control-minimalist" name="content" id="content"><?=isset($mom->content) ? $mom->content : ""?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2"><label class="control-label">Kesimpulan</label></div>
            <div class="col-sm-10">
                <textarea placeholder="Content" class="form-control-minimalist" name="result" id="result"><?=isset($mom->result) ? $mom->result : ""?></textarea>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <label class="col-sm-2 control-label input-md">Attachment</label>
            <div class="col-sm-10">
                <input type="file" name="attachment[]" id="attachment" multiple class="btn btn-default">
                <?php if(isset($attachment)){?>
                <div style="margin-top:20px; max-width:80%">
                    <?php foreach($attachment as $file){?>
                        <div class="file_<?php echo $file->id?>">
                            <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
                                <span><img style="height:18px" src="<?=get_ext_office($file->ext)?>"></span>
                                <a href="<?php echo base_url()?><?php echo $file->full_url;?>"><?= $file->title?></a>
                            </div>
                            <div style="float:right; padding-right:10px;">
                                <?php if(($user['id'] == $file->user_id) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                    <a onclick="delete_files_upload(<?php echo $file->id?>,'file_form')">
                                        <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                    </a>
                                <?php }?>
                            </div><div style="clear:both"></div>
                        </div>
                    <?php }?>
                </div>
                <?php }?>
            </div>
        </div>
        <hr>
        <input type="hidden" value="<?=(($parent_activity) && $parent_activity->parent_id) ? $parent_activity->parent_id : '' ?>" name="mom_parent_activity_id">
        <input type="hidden" value="<?=(($parent_activity) && $parent_activity->act_step_id) ? $parent_activity->act_step_id : '' ?>" name="mom_activity_id">
        <div class="form-group row">
            <h4>PARENT ACTIVITY</h4><br/>
            <div style="margin-bottom: 30px;" class="helper_text">
                <select class="selectpicker" id="parent_act" name="parent_act" data-live-search="true" data-dropup-auto="false" data-width="100%">
                    <option value="0" selected>--No Action--</option>
                    <?php if($list_activities){ foreach($list_activities as $act){ ?>
                        <option <?php 
                        if($parent_activity && $parent_activity->parent_id){
                            if($act->act_step_id==$parent_activity->parent_id){echo 'selected';} 
                            else{ echo '';} 
                        }else{echo '';} ?> value="<?=$act->act_step_id?>"> <?=$act->full_name.' - '.$act->activity?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div style="margin-bottom: 30px;" class="helper_text">
                <div class="pull-right">
                    <a onclick="add_sub_activity()" class="btn btn-brobot btn-gray btn-sm">+ ACTIVITY</a>
                </div>
                <h4>ACTIVITIES</h4>
                <br/>
                <div id="sub_activity_list" style="padding: 0 10px 0 10px">
                    <?php if(isset($sub_activity_list)) { foreach($sub_activity_list as $sub){?>
                        <div id="sub_sub_activity_list_<?=$sub->act_step_id?>" class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control-minimalist" id="activity_sub" name="activity_sub[]" placeholder="Activity" value="<?=$sub->activity?>" >
                                </div>
                                <a class="pull-right" onclick="delete_activity_step(<?=$sub->act_step_id?>)">
                                    <span class="glyphicon glyphicon-trash delete_color"></span>
                                </a>
                            </div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-sm-3">
                                    <select class="selectpicker" id="user_pic_sub" name="user_pic_sub[]" data-live-search="true" data-dropup-auto="false" data-width="100%">
                                        <?php if($pic){foreach($pic as $k=>$v){?>
                                                <option <?=($sub->user_pic == $v["id"] ? "selected" : "")?> value="<?php echo $v["id"]?>"><?php echo $v["full_name"]?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                                <div class="col-sm-2" style="">
                                    <input type="text" class="form-control-minimalist deadline_sub" id="deadline_sub" name="deadline_sub[]" placeholder="Deadline" value="<?=date('j M y',strtotime($sub->deadline))?>">
                                </div>
                                <div class="col-sm-2">
                                    <select class="selectpicker form-control" name="status_sub[]" data-width="100%">
                                        <option <?=$sub->status=='Not Started' ? 'selected' : '' ?>  value="Not Started">Not Started</option>
                                        <option <?=$sub->status=='On Progress' ? 'selected' : '' ?> value="On Progress">On Progress</option>
                                        <option <?=$sub->status=='Delay' ? 'selected' : '' ?> value="Delay">Delay</option>
                                        <option <?=$sub->status=='Done' ? 'selected' : '' ?> value="Done">Done</option>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <input value="<?=$sub->progress?>" type="text" class="form-control-minimalist" id="tenor" name="progress_sub[]" placeholder="Progress">
                                </div>
                                <input value="<?=$sub->act_step_id?>" type="hidden" name="sub_activity_id[]">
                                <input value="<?=$sub->progress_id?>" type="hidden" name="progress_sub_id[]">
                            </div>
                        </div><hr>
                    <?php } } ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3">
                <h4>APPROVED BY</h4>
            </div>
            <div class="col-sm-3">
                <select class="selectpicker" id="approved_by" name="approved_by" data-live-search="true" data-dropup-auto="false" data-width="100%">
                    <?php if($pic){foreach($pic as $k=>$v){?>
                            <option <?= (isset($mom) && $mom->approved_by && $mom->approved_by == $v["id"]) ? "selected" : "" ?> value="<?php echo $v["id"]?>"><?php echo $v["full_name"]?></option>
                    <?php }}?>
                </select>
            </div>
        </div>
        <div class="right_text">
            <a style="margin-right: 10px;" class="btn btn-broventh btn-fourth" onclick="submit_mom('draft')">Save Draft</a>
            <a style="margin-right: 10px;" class="btn btn-broventh btn-first" onclick="submit_mom('final')">Submit</a>
            <a class="btn btn-broventh btn-third" href="<?=base_url().'meeting/agenda/'.$meeting_id?>">Close</a>
        </div>
    </div>
</form>

<script>
function add_sub_activity(){
    $("#sub_activity_list").prepend('<div class="form-group">'
                                    +'<div class="row">'
                                        +'<div class="col-sm-6">'
                                            +'<input type="text" class="form-control" id="activity_sub" name="activity_sub[]" placeholder="Activity">'
                                        +'</div>'
                                        +'<a class="pull-right" onclick="delete_activity_step(0,this)">'
                                            +'<span class="glyphicon glyphicon-trash delete_color"></span>'
                                        +'</a>'
                                    +'</div>'
                                    +'<div class="row" style="margin-top:10px;">'
                                        +'<div class="col-sm-3">'
                                            +'<select class="selectpicker" id="user_pic_sub" name="user_pic_sub[]" data-live-search="true" data-dropup-auto="false" data-width="100%">'
                                                +'<?php if($pic){foreach($pic as $k=>$v){?>'
                                                        +'<option <?=($user["id"] == $v["id"] ? "selected" : "")?> value="<?php echo $v["id"]?>"><?php echo $v["full_name"]?></option>'
                                                +'<?php }}?>'
                                            +'</select>'
                                        +'</div>'
                                        +'<div class="col-sm-2" style="">'
                                            +'<input type="text" class="form-control-minimalist deadline_sub" id="deadline_sub" name="deadline_sub[]" placeholder="Deadline">'
                                        +'</div>'
                                        +'<div class="col-sm-2">'
                                            +'<select class="selectpicker form-control" name="status_sub[]" data-width="100%">'
                                                +'<option value="Not Started">-- Status --</option>'
                                                +'<option value="Not Started">Not Started</option>'
                                                +'<option value="On Progress">On Progress</option>'
                                                +'<option value="Delay">Delay</option>'
                                                +'<option value="Done">Done</option>'
                                            +'</select>'
                                        +'</div>'
                                        +'<div class="col-sm-5">'
                                            +'<input type="text" class="form-control" id="tenor" name="progress_sub[]" placeholder="Progress">'
                                        +'</div>'
                                        +'<input type="hidden" name="sub_activity_id[]">'
                                        +'<input type="hidden" name="progress_sub_id[]">'
                                    +'</div>'
                                +"</div><hr>");
    $('.selectpicker').selectpicker('refresh');
    $(".deadline_sub").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'd M yy',
        dateFormat:"mm/dd/yy"
    });
}
$('.selectpicker').selectpicker('refresh');
actived_summernote('background');
actived_summernote('content');
actived_summernote('result');
$(".deadline_sub").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'd M yy',
    dateFormat:"mm/dd/yy"
});
$('input[type=file]').bootstrapFileInput();

</script>