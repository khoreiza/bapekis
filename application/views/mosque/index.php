<?php $user = $this->session->userdata('userbapekis'); ?>
<div class="container_broventh container_broventh_small">
    <div>
        <div class="row">
            <div class="col-md-8">
                <h2 class="page_title">Mosque Management Page</h2>
                <p class="broventh_page_description">
                    Today <?=date('l, j M y')?>.
                </p>
            </div>
            <div class="col-md-4 right_text">
                <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                    <a onclick="show_add_mosque_form()" style="margin-right: 10px;" class="btn btn-broventh btn-first">
                        <span class="glyphicon glyphicon-blackboard" style="margin-right: 8px;"></span> Add New Mosque</a>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 column" style="padding-right: 20px;">
            <div class="broventh_submenu_div" style="margin-top: 0px;">
                <div class="broventh_submenu_title no_border">
                   
                    <div class="row">
                        <div class="col-xs-7">
                            <select class="selectpicker" onchange="change_group_room()" id="group_req">
                                <?php foreach($list_of_groups as $group){?>
                                    <option value="<?=$group->val?>" <?=(strtoupper($user['group']) == strtoupper($group->val)) ? "selected" : ""?>><?=$group->val?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-xs-5 right_text">
                            <div class="input-group" style="float: right; width: 100%; max-width: 200px">
                                <input class="form-control-minimalist" value="<?=date('j M y')?>" id="meeting_date" onchange="change_date_for_room()">
                                <div class="input-group-addon addon-minimalist"><span class="glyphicon glyphicon-calendar"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="broventh_submenu_body">
                    <div id="list_of_mosque_index">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 column" id="list_of_requests" style="padding-left: 20px;">
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/mosque.js"></script>
<script type="text/javascript">
    $('#meeting_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'd M yy'
    });
    change_mosque_data();

</script>