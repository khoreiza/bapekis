<?php
    $arr_segment_allowed = get_arr_segment_ap();
?>
<form class="form-horizontal" 
      action="<?=base_url()?>team_matrix/store_team" 
      method ="post" id="form_team_matrix" role="form" enctype="multipart/form-data" style="padding: 10px;">
    
    <input type="hidden" name="ownership_id" value="<?=$ownership_id?>">
    <input type="hidden" name="ownership_category" value="<?=$category?>">
    <input type="hidden" name="ownership_modul" value="<?=$modul?>">
    <input type="hidden" name="ownership_sub_modul" value="<?=$sub_modul?>">
    <div class="form-group row">
        <label class="col-sm-2 control-label">User</label>
        <div class="col-sm-8">
            <select class="selectpicker form-control" name="user_id" data-live-search="true">
                <option value=""> -- Not Selected -- </option>
                <?php foreach($users as $user){?>
                	<option <?=(isset($team_matrix)) ? "selected" : ""?> value="<?=$user->id?>"><?=$user->full_name?></option>
                <?php }?>
            </select>
        </div>
    </div><hr>
    <div class="center_text">
        <button class="btn btn-broventh btn-circle btn-first btn-lg" type="button" onclick="submit_team_matrix(this)"><span class="glyphicon glyphicon-save"></span></button>
    </div>
</form>

<script>
    function submit_team_matrix(){    
        $('#form_message').html('Saving your data...');
        $("#form_team_matrix").ajaxForm({ 
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
                    
                    $('#team_matrix_list_view').html(resp.list_teams_view);
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
</script>