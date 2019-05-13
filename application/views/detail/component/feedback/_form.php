<div class="row">
    <div class="col-md-6" style="margin-bottom: 40px;">
        <div>
            <h4>Contact Us:</h4>
            <h2 style="margin-top: 5px;">Ramadhan 1440 H</h2>
        </div>
        <div style="margin: 40px 0 40px 0;">
            <h4>Direktorat Special Asset Management</h4>
        </div>
        <div>
            <h4>PIC: Alfin Abrar</h4>
            <h4>Email: alfin.abrar@bankmandiri.co.id</h4>
        </div>
    </div>
    <div class="col-md-6">
        <div class="broventh_card" style="padding-right: 40px;">
            <form class="form-horizontal form-borventh" 
              action="<?=base_url()?>feedback/submit/" 
              method ="post" id="form_feedback" role="form" enctype="multipart/form-data" style="padding: 10px;">
                <div class="form_group_part_div" id="form_group_part_div_1" style="display: block;">
                    <div>
                        <div class="form_group_part_title">Form Feedback</div>
                        <div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <select class="form-control-minimalist" name="kind">
                                        <option value="Menu Takjil">Menu Takjil</option>
                                        <option value="Nasi Box">Nasi Box</option>
                                        <option value="Ramadhan Event">Ramadhan Event</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <?php if(isset($mysharing)){
                                        if($mysharing['mysharing']->date != "0000-00-00") $date = date('j M Y',strtotime($mysharing['mysharing']->date));
                                        else $date = date('j M Y',strtotime($mysharing['mysharing']->created_at));
                                    }else{
                                        $date = date('j M Y');
                                    }?>
                                    <input type="text" class="form-control-minimalist date" name="date" placeholder="Date" value="<?=$date?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control-minimalist" name="name" placeholder="Name" value="<?php if(isset($mysharing)){echo $mysharing['mysharing']->title;}?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control-minimalist" name="unit" placeholder="Unit Kerja" value="<?php if(isset($mysharing)){echo $mysharing['mysharing']->title;}?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control-minimalist" id="email" name="email" placeholder="Email" value="<?php if(isset($mysharing)){echo $mysharing['mysharing']->title;}?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea onfocus="actived_summernote('description');" type="text" class="form-control-minimalist" name="comment" id="description" placeholder="Feedback"><?php if(isset($mysharing)){echo $mysharing['mysharing']->description;}?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_text">
                        <div style="margin-top: 20px" id="form_button">
                            <button class="btn btn-broventh btn-first" type="button" onclick="submit_feedback(this)"><span class="glyphicon glyphicon-save"></span> Submit</button>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('.date').datepicker({
        format: 'dd M yyyy',
        autoclose: true,
        todayHighlight: true,

    });

    function submit_feedback(){    
        $("#form_feedback").ajaxForm({ 
            dataType: 'json',
            success: function(resp){
                $(".modal .loading_panel").hide();
                if (resp.status){
                    
                    $('#popup_Modal').modal('hide');
                    //load_more_sharings('first_time');
                    alert('Submit Telah Sukses');

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
</script>