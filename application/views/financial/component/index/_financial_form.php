<?php $user = $this->session->userdata('userbapekis');?>

<div class="form-signin" style="padding: 0 20px 0 20px;">	      
    
    <form class="form-horizontal" action="<?=base_url()?>financial/store/<?=(isset($cashflow)) ? $cashflow->id : '';?>" method ="post" id="form_input_fin" role="form" enctype="multipart/form-data">

        <input type="hidden" name="mosque_id" value="<?=$mosque_id?>">
        <div class="form-group row">
            <label class="col-sm-2 control-label">Type</label>
            <div class="col-sm-5">
                <select class="selectpicker form-control" name="type">
                    <option value="Outcome" <?=(isset($cashflow) && $cashflow->type == 'Outcome') ? 'selected' : '';?>>Outcome</option>
                    <option value="Income" <?=(isset($cashflow) && $cashflow->type == 'Income') ? 'selected' : '';?>>Income</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Date</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-minimalist date" placeholder="Transaction Date" name="date" value="<?=(isset($cashflow) && $cashflow->date != '0000-00-00') ? date('j M Y',strtotime($cashflow->date)) : date('j M y')?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Amount</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-minimalist" id="amount" name="amount" placeholder="Transaction Amount" value="<?php if(isset($cashflow)){echo $cashflow->amount;}?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Item</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-minimalist" id="purpose" name="purpose" placeholder="Transaction Item" value="<?php if(isset($cashflow)){echo $cashflow->purpose;}?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-9">
                <textarea onfocus="actived_summernote('description');" class="form-control-minimalist" id="description" name="description" placeholder="Transaction Description"><?php if(isset($cashflow)){echo $cashflow->description;}?></textarea>
            </div>
        </div><hr>
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
    
    $('#amount').priceFormat({
        prefix: '',
        centsLimit: 0
    });
    $('input[type=file]').bootstrapFileInput();
    $(".date").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'd M yy',
        dateFormat:"mm/dd/yy"
    });


    <?php if(isset($cashflow) && $cashflow->description){?>
        $('#description').summernote();
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