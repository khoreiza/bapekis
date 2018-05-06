<?php
    $user = $this->session->userdata('userbapekis');
    $arr_position = array("DIRECTOR","GROUP HEAD","DEPARTMENT HEAD","TEAM LEADER","OFFICER","PELAKSANA","SEKRETARIS");
?>
<div>
    <a class="btn btn-broventh btn-circle btn-third" onclick="close_form_user()">X</a>
    <div>
        <div class="form_group_part_div" style="display: block;">
            <div class="form_group_part_title">Photo Profile</div>
            <div class="form-group row">
                <div class="center_text">
                    <div style="margin-bottom: 20px;">
                        <label class="btn btn-brobot btn-gray btn-file" style="margin-right: 5px;">
                            Choose Photo <input type="file" name="photo" style="display: none;" id="imgInp">
                        </label>
                        <label class="btn btn-brobot btn-gray btn-file">
                            Edit Photo <input type="button" onclick="crop_pp()" name="photo" style="display: none;" id="">
                        </label>
                    </div>
                    <div id="this_pp">
                        <div style="width:200px; height: 200px; border-radius: 10px; margin:0 auto; margin-top: 20px; margin-bottom: 20px;" id="div_preview_image">
                            <?php if(isset($profile)){?>
                                <img style="height:100%;" src="<?=get_employee_photo($profile);?>" id="preview_image">
                            <?php }else{?>
                                <img style="height:100%;" src="<?=base_url()?>assets/img/general/profile.gif" id="preview_image">
                            <?php }?>
                        </div>
                    </div>
                    <button class="btn btn-brobot btn-tosca" style="margin-top: 20px; display: none;" onclick="get_data()" id="crop_image_btn">Crop Image</button>
                </div>
            </div>
        </div>
    </div><hr>
    <form class="form-horizontal form-borventh" 
          action="<?=base_url()?>data/store_user/<?=(isset($profile) && $profile->id) ? $profile->id : ''?>" 
          method ="post" id="form_input_room" role="form" enctype="multipart/form-data" style="padding: 10px;">

        <input type="hidden" id="pp_not_file" name="pp_not_file" value="">
        <div class="form_group_part_div" style="display: block;">
            <div class="form_group_part_description">Name, DOB, Gender</div>
            <div class="form_group_part_title">General Information</div>
            <div class="form-group row">
                <div class="col-sm-7">
                    <input type="text" class="form-control-minimalist" id="full_name" name="full_name" placeholder="Full Name" value="<?=(isset($profile) && $profile->full_name) ? $profile->full_name : ""; ?>">
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control-minimalist date" name="dob" id="dob" placeholder="Date of Birth" value="<?=(isset($profile) && $profile->dob && $profile->dob != "0000-00-00") ? date("j M Y",strtotime($profile->dob)) : "";?>">
                </div>
                <div class="col-sm-2">
                    <select class="selectpicker" name="gender" data-width="100%">
                        <option value="P" <?=(isset($profile) && $profile->gender == "P") ? "selected" : ""; ?>>Woman</option>
                        <option value="L" <?=(isset($profile) && $profile->gender == "L") ? "selected" : ""; ?>>Man</option>
                    </select>
                </div>
            </div>
        </div><hr>
        <div class="form_group_part_div" style="display: block;">
            <div class="form_group_part_description">Username and Password</div>
            <div class="form_group_part_title">User Information</div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <input type="text" class="form-control-minimalist" name="username" id="username" placeholder="Username" value="<?php if(isset($profile)){echo $profile->username;}?>">
                </div>
                <?php if(!isset($profile)){?>
                <div class="col-sm-4">
                    <input type="password" class="form-control-minimalist" id="password" name="password" placeholder="Password">
                </div>
                <div class="col-sm-4">
                    <input type="password" class="form-control-minimalist" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                </div>
                <?php }?>
                <div class="col-sm-3">
                    <select class="selectpicker" name="status" data-width="100%">
                        <option value="active" <?=(isset($profile) && $profile->status == "active") ? "selected" : ""; ?>>Active</option>
                        <option value="nonactive" <?=(isset($profile) && $profile->status == "nonactive") ? "selected" : ""; ?>>Unactive</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <select class="selectpicker" name="is_NDA" data-width="100%">
                        <option value="0" <?=(isset($profile) && $profile->is_NDA == "0") ? "selected" : ""; ?>>Has not signed the NDA</option>
                        <option value="1" <?=(isset($profile) && $profile->is_NDA == "1") ? "selected" : ""; ?>>Has signed the NDA</option>
                    </select>
                </div>
            </div>
        </div><hr>
        <div class="form_group_part_div" style="display: block;">
            <div class="form_group_part_description">NIP, Jabatan, Position</div>
            <div class="form_group_part_title">Employement Information</div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <input type="text" class="form-control-minimalist" name="nik" id="nik" placeholder="NIK" value="<?php if(isset($profile)){echo $profile->nik;}?>">
                </div>
                <div class="col-sm-5">
                    <input type="text" class="form-control-minimalist" name="jabatan" id="jabatan" placeholder="Jabatan" value="<?php if(isset($profile)){echo $profile->jabatan;}?>">
                </div>
                <div class="col-sm-4">
                    <select id="position" class="selectpicker" name="position" data-width="100%">
                        <?php foreach($arr_position as $position){?>
                            <option value="<?=$position?>" <?=(isset($profile) && $position == strtoupper($profile->position)) ? "selected" : "";?>><?=get_long_text($position,20)?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div><hr>
        <div class="form_group_part_div" style="display: block;">
            <div class="form_group_part_description">Directorate, Group, Department</div>
            <div class="form_group_part_title">Unit Information</div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <input type="text" class="form-control-minimalist" name="directorate" id="directorate" placeholder="Directorate" value="<?=(isset($profile))? get_long_text($profile->directorate,100) : "";?>" onfocus="auto_complete(this,'cbdirectorate')">
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control-minimalist" name="group" id="group" placeholder="Group" value="<?=(isset($profile))? get_long_text($profile->group,100) : "";?>" onfocus="auto_complete(this,'user_group')">
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control-minimalist" name="department" id="department" placeholder="Department" value="<?=(isset($profile))? get_long_text($profile->department,100) : "";?>" onfocus="auto_complete(this,'user_department')">
                </div>
            </div>
        </div><hr>
        <div class="form_group_part_div" style="display: block;">
            <div class="form_group_part_description">Email and Phone Number, IP Phone, Ext</div>
            <div class="form_group_part_title">Contact Information</div>
            <div class="form-group row">
                <div class="col-sm-5">
                    <input type="text" class="form-control-minimalist" id="email" name="email" placeholder="Email" value="<?=(isset($profile) && $profile->email) ? $profile->email : ""; ?>">
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control-minimalist" id="phone_number" name="phone_number" placeholder="Phone Number" value="<?=(isset($profile) && $profile->phone_number) ? $profile->phone_number : ""; ?>">
                </div>
            </div>
        </div><hr>
        
        <div class="form_group_part_div" style="display: block;">
            <div class="form_group_part_title">Role Information</div>
            <?php if(isset($profile)){$arr_role = explode(";",$profile->role);}?>
            <div class="col-sm-12" style="text-align:left">
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="MEGA ADMINISTRATOR" <?php if(isset($profile) && in_array("MEGA ADMINISTRATOR",$arr_role)){echo "checked";}?>> Mega Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="SYSTEM ADMINISTRATOR" <?php if(isset($profile) && in_array("SYSTEM ADMINISTRATOR",$arr_role)){echo "checked";}?>> System Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="ACCOUNT PLAN ADMINISTRATOR" <?php if(isset($profile) && in_array("ACCOUNT PLAN ADMINISTRATOR",$arr_role)){echo "checked";}?>> AP Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="POLICY ADMINISTRATOR" <?php if(isset($profile) && in_array("POLICY ADMINISTRATOR",$arr_role)){echo "checked";}?>> Policy Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="MARKET ADMINISTRATOR" <?php if(isset($profile) && in_array("MARKET ADMINISTRATOR",$arr_role)){echo "checked";}?>> Market Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="HR ADMINISTRATOR" <?php if(isset($profile) && in_array("HR ADMINISTRATOR",$arr_role)){echo "checked";}?>> HR Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="BIAYA ADMINISTRATOR" <?php if(isset($profile) && in_array("BIAYA ADMINISTRATOR",$arr_role)){echo "checked";}?>> Biaya Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="PERFORMANCE ADMINISTRATOR" <?php if(isset($profile) && in_array("PERFORMANCE ADMINISTRATOR",$arr_role)){echo "checked";}?>> Perf Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="EVENT ADMINISTRATOR" <?php if(isset($profile) && in_array("EVENT ADMINISTRATOR",$arr_role)){echo "checked";}?>> Event Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="RKK ADMINISTRATOR" <?php if(isset($profile) && in_array("RKK ADMINISTRATOR",$arr_role)){echo "checked";}?>> RKK Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="RKK MASTER ADMINISTRATOR" <?php if(isset($profile) && in_array("RKK MASTER ADMINISTRATOR",$arr_role)){echo "checked";}?>> RKK Master Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="RAKER ADMINISTRATOR" <?php if(isset($profile) && in_array("RAKER ADMINISTRATOR",$arr_role)){echo "checked";}?>> Raker Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="GENERAL VIEWER" <?php if(isset($profile) && in_array("GENERAL VIEWER",$arr_role)){echo "checked";}?>> General Viewer
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="PERFORMANCE VIEWER" <?php if(isset($profile) && in_array("PERFORMANCE VIEWER",$arr_role)){echo "checked";}?>> Performance Viewer
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="LOG VIEWER" <?php if(isset($profile) && in_array("LOG VIEWER",$arr_role)){echo "checked";}?>> Log Viewer
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="MARKET VIEWER" <?php if(isset($profile) && in_array("MARKET VIEWER",$arr_role)){echo "checked";}?>> Market Viewer
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="EDM ADMINISTRATOR" <?php if(isset($profile) && in_array("EDM ADMINISTRATOR",$arr_role)){echo "checked";}?>> EDM Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="SSF ADMINISTRATOR" <?php if(isset($profile) && in_array("SSF ADMINISTRATOR",$arr_role)){echo "checked";}?>> SSF Adm.
                </label>
                <label class="checkbox-inline">
                    <input name="role[]" type="checkbox" value="LEGAL ADMINISTRATOR" <?php if(isset($profile) && in_array("LEGAL ADMINISTRATOR",$arr_role)){echo "checked";}?>> Legal Adm.
                </label>
            </div><div style="clear:both"></div>
        </div><hr>
        <div class="center_text">
            <button class="btn btn-broventh btn-circle btn-first btn-lg" type="submit"><span class="glyphicon glyphicon-save"></span></button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        //fill_customer_options('customer');
        $(".selectpicker").selectpicker('refresh');
        $(".date").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'd M yyyy',
            dateFormat:"mm/dd/yy"
        });
        $('#project_value').priceFormat({
            prefix: '',
            centsLimit: 0
        });
    });
    function close_form_user(){
        $.confirm({
            title: 'Apa anda yakin?',
            content: '',
            confirmButton: 'Ya',
            confirm: function(){  
                $("#user_list_div").show();
                $("#user_form_div").html('');
                $("#user_detail_div").html('');
            },
        });
    }




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
        make_new_pp_div('');
        readURL(this);
        crop_pp();
    });

    function make_new_pp_div(src){
        $("#this_pp").html('<div style="width:200px; height: 200px; border-radius: 10px; margin:0 auto; margin-top: 20px; margin-bottom:20px;" id="div_preview_image">'
                +'<img style="width:100%;" src="'+src+'" id="preview_image">'
            +'</div>');
    }
    
    function crop_pp(){
        //$("#div_preview_image").show();
        //$("#dispaly_image").hide();
        $("#crop_image_btn").show();
        setTimeout(function(){$('#preview_image').croppie({
            viewport: {
                width: 120,
                height: 120
            }
        });}, 500);
    }

    function get_data(){
        //$("#dispaly_image").show();
        //
        $('#preview_image').croppie('result', {
            type: 'base64',
            size: 'original',
            quality: '0.5'
        }).then(function (resp) {
            make_new_pp_div(resp);
            $("#pp_not_file").val(resp);
            $("#crop_image_btn").hide();
        });
    }

</script>