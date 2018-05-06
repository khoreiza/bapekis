<?php 
	$user = $this->session->userdata('userbapekis'); $user_disp="";
?>

<form class="form-horizontal form-borventh" 
  action="<?=base_url()?>sharing/submit/<?=(isset($mysharing) && $mysharing['mysharing']->id) ? $mysharing['mysharing']->id : ''?>" 
  method ="post" id="form_mysharing" role="form" enctype="multipart/form-data" style="padding: 10px;">


    <div class="form_group_part_div" id="form_group_part_div_1" style="display: block;">
        <div>
            <div class="form_group_part_description">Title, Category, Date, Sharing Content, and Photo Banner</div>
            <div class="form_group_part_title">Sharing Information</div>
            <div>
                <div class="form-group row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <input type="text" class="form-control-minimalist" id="title" name="title" placeholder="Title" value="<?php if(isset($mysharing)){echo $mysharing['mysharing']->title;}?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 col-sm-offset-1">
                        <select class="selectpicker" name="category_id" data-width="100%">
                            <option value="0">Uncategorized</option>
                            <?php foreach($categories as $categ){?>
                                <option value="<?=$categ->id?>" <?=(isset($mysharing) && $mysharing['mysharing']->category_id == $categ->id) ? "selected" : ""; ?>><?=$categ->category?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <?php if(isset($mysharing)){
                            if($mysharing['mysharing']->date != "0000-00-00") $date = date('j M y',strtotime($mysharing['mysharing']->date));
                            else $date = date('j M y',strtotime($mysharing['mysharing']->created_at));
                        }else{
                            $date = date('j M y');
                        }?>
                        <input type="text" class="form-control-minimalist date" name="date" placeholder="Date" value="<?=$date?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 col-sm-offset-1">
                    <textarea onfocus="actived_summernote('description');" type="text" class="form-control-minimalist" name="description" id="description" placeholder="Sharing Content"><?php if(isset($mysharing)){echo $mysharing['mysharing']->description;}?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-1">
                        <input type="file" name="img" id="img" class="btn btn-default">
                        <p class="help-block helper_text" style="margin-bottom: 0px; font-size: 12px;">Photo Banner for your sharing</p>
                        <?php if(isset($photo) && $photo){?>
                            <div style="margin-top: 10px;" class="file_<?php echo $photo->id?>">
                            <span><img style="height:100px" src="<?php echo base_url().$photo->full_url?>"></span>
                            <?php if(($user['id'] == $photo->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                            <a onclick="delete_files_upload(<?php echo $photo->id?>,'file_form')">
                                <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                            </a>
                            <?php }?>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div><hr>
        <div>
            <div class="form_group_part_description">Attachment Files, Photo Gallery</div>
            <div class="form_group_part_title">Sharing Attachment</div>

            <div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label input-md">Attachment</label>
                    <div class="col-sm-10">
                        <input type="file" name="attachment[]" id="attachment" multiple class="btn btn-default">
                        <?php if(isset($mysharing['attachment'])){?>
                        <div style="margin-top:20px; max-width:80%">
                            <?php foreach($mysharing['attachment'] as $file){?>
                                <div class="file_<?php echo $file->id?>">
                                    <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
                                        <span><img style="height:18px" src="<?=get_ext_office($file->ext)?>"></span>
                                        <a href="<?php echo base_url()?><?php echo $file->full_url;?>"><?= $file->title?></a>
                                    </div>
                                    <div style="float:right; padding-right:10px;">
                                        <?php if(($user['id'] == $file->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
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
                <div class="form-group row">
                    <label class="col-sm-2 control-label input-md">Photo Gallery</label>
                    <div class="col-sm-10">
                        <input type="file" name="photo[]" id="photo" multiple class="btn btn-default">
                        <?php if(isset($mysharing['img'])){?>
                        <div style="margin-top:20px; max-width:80%">
                            <?php foreach($mysharing['img'] as $file){?>
                                <div class="file_<?php echo $file->id?>">
                                    <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
                                        <span><img style="height:18px" src="<?php echo base_url().$file->full_url ?>"></span>
                                        <?php echo $file->title?>
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
            </div>
        </div>
        <div class="center_text">
            <hr>
            <div style="margin-top: 20px" class="center_text" id="form_message">
               
            </div>
            <div style="margin-top: 20px" class="center_text" id="form_button">
                <button class="btn btn-broventh btn-circle btn-first btn-lg" type="button" onclick="submit_sharing(this)"><span class="glyphicon glyphicon-save"></span></button>
                <div style="margin-top: 20px" class="center_text">Ready to save</div>
            </div>
        </div>
    </div>
</form>

<script>

    function submit_sharing(){    
        $('#form_message').html('Saving your data...');
        $("#form_mysharing").ajaxForm({ 
            dataType: 'json',
            /*beforeSerialize: function(form, options) {
                var real_amount = $('.amount').unmask();
                $(".amount").val(real_amount);
            },*/
            success: function(resp){
                $(".modal .loading_panel").hide();
                if (resp.status){
                    //  !! tolong diadjust message, url, list_user nya
                    //notify_by_user('sharing','message nya apa', get_relative_url(window.location.href), $('#user_allowed').val());
                    $('#popup_Modal').modal('hide');
                    load_more_sharings('first_time');
                    //window.location.reload();
                    /*if (window.location.pathname.toLowerCase().startsWith("/cbic/legal/advis_detail")) {
                        window.location.reload();
                    } else {
                        //get_list_advis();
                        window.location = config.base+"legal/show/"+resp.id_advis;
                    }*/

                }
                else {
                    $(".error_submit").html(resp.message).removeClass("hidden").focus();
                    $("#form_advis .btn-link-primary-cbic").removeAttr('disabled');
                }
            },
            error: function() {
                $(".modal .loading_panel").hide();
            }
        }).submit();
    }

    function delete_mysharing(id){
        $.confirm({
    		title: 'Apa anda yakin?',
    		content: '',
    		confirmButton: 'Ya',
    		confirm: function(){  
    		  $.ajax({
    			type: "GET",
    			url: config.base+"mysharing/delete_mysharing",
    			data: {id:id},
    			dataType: 'json',
    			cache: false,
    			success: function(resp){
    			  console.log(resp);
    			  if(resp.status==true){
                    $('#mysharing_'+id).animate({'opacity':'toggle'});
    			  }else{
    				  console.log('action after failed');
    			  }
    			}
    		  });
    		},
    	});
      }
        
    $(document).ready(function () {	
        $('input[type=file]').bootstrapFileInput();
        
        $(".selectpicker").selectpicker('refresh');
        $(".date").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'd M yy',
            dateFormat:"mm/dd/yy"
        });
    });
    <?php if(isset($mysharing)){?>
    	$('#description').summernote();
    <?php }?>
</script>