<?php $user = $this->session->userdata('userbapekis');?>

<div class="form-signin" style="padding: 0 20px 0 20px;">	      
    
    <form class="form-horizontal" 
          action="mosque/store_mosque/<?=(isset($mosque) ? $mosque->id : '')?>"
          method ="post" id="form_input_mosque" role="form" enctype="multipart/form-data">
        
        <div class="form-group row">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-minimalist" id="name" name="name" placeholder="" value="<?php if(isset($mosque)){echo $mosque->name;}?>">
            </div>
        </div>
        <?php /*<div class="form-group row">
            <label class="col-sm-2 control-label">Capacity</label>
            <div class="col-sm-9">
                <div class="input-group">
                <input type="number" class="form-control-minimalist" id="capacity" name="capacity" placeholder="" value="<?php if(isset($mosque)){echo $mosque->capacity;}?>">
                <div class="input-group-addon">People</div>
                </div>
            </div>
        </div>*/ ?>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Region</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-minimalist" id="region" name="region" placeholder="" value="<?php if(isset($mosque)){echo $mosque->region;}?>">
                <?php /*<select class="selectpicker form-control" name="pic_group">
                    <?php for($i=1;$i<=7;$i++){?>
                        <option value="Corporate Banking <?=$i?>">Corporate Banking <?=$i?></option>
                    <?php }?>
                    <option value="Corporate Banking Solution">Corporate Banking Solution</option>
                    <option value="Others">Others</option>
                </select>*/ ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Alamat</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-minimalist" id="location" name="location" value="<?php if(isset($mosque)){echo $mosque->location;}?>">
            </div>
        </div>
        <?php /*<div class="form-group row">
            <label class="col-sm-2 control-label">Facility</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-minimalist" id="facility" name="facility" value="<?php if(isset($mosque)){echo $mosque->facility;}?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Approval by</label>
            <div class="col-sm-9">
                <select class="selectpicker form-control" data-live-search="true" multiple data-actions-box='true' name="need_request[]">
                    <?php foreach($users as $user){?>
                        <option value="<?=$user->id?>"><?=$user->full_name?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
                <div class="checkbox">
                  <label><input type="checkbox" value="1" name="use_together" <?=(isset($mosque) && $mosque->use_together) ? 'checked' : ''?>>Use Together</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="checkbox">
                  <label><input type="checkbox" value="1" name="is_exclusive" <?=(isset($mosque) && $mosque->is_exclusive) ? 'checked' : ''?>>Is Exclusive</label>
                </div>
            </div>
        </div> */ ?>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-9">
                <textarea onfocus="actived_summernote('note');" class="form-control-minimalist" id="note" name="note" placeholder="Mosque Description"><?php if(isset($mosque)){echo $mosque->note;}?></textarea>
            </div>
        </div><hr>
        <div class="form-group row">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-9">
                <div style="margin-bottom: 20px;">
                    <label class="btn btn-brobot btn-gray btn-file">
                        Choose Photo <input type="file" name="photo" style="display: none;" id="imgInp">
                    </label>
                </div>
                <div style="width:100%; max-width:600px; height:100%; max-height: 600px; overflow: hidden; border-radius: 10px;" id="div_preview_image">
                    <img style="width:100%;" src="<?=base_url()?>assets/img/general/photo_empty.png" id="preview_image">
                </div>
            </div>
        </div>
        <div class="center_text">
            <hr>
            <div style="margin-top: 20px" class="center_text" id="form_message">
               
            </div>
            <div style="margin-top: 20px" class="center_text" id="form_button">
                <button class="btn btn-broventh btn-circle btn-first btn-lg" type="submit" ><span class="glyphicon glyphicon-save"></span></button>
                <div style="margin-top: 20px" class="center_text">Ready to save</div>
            </div>
        </div>
    </form>
</div>
                
<script>
    
    <?php if(isset($mosque) && $mosque->note){?>
        $('#note').summernote();
    <?php }?>
    
    /******************* Preview Image *****************/
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview_image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    });
</script>