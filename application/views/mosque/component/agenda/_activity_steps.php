<?php $user = $this->session->userdata('userbapekis'); ?>

<div>
    <?php if(isset($list_activity_steps)){?>    
    <div class="broventh_submenu_div" style="margin-top: 0px;">
        <div class="broventh_submenu_title no_border">
            <div class="row">
                <div class="col-md-12">
                    <span class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;"><span class="glyphicon glyphicon-list"></span></span>
                    Follow Up Action
                </div>
            </div>
        </div>
        <div class="broventh_submenu_body">
            <div class="broventh_card">
                <table class="table table-striped">
                    <thead>
                        <th>PIC</th>
                        <th>Activity</th>
                        <th>Deadline</th>
                    </thead>
                    <tbody>
                        <?php foreach($list_activity_steps as $k => $las){ ?>
                            <tr>
                                <td><a onclick="show_user_detail(<?=$las->user_id?>)"><?=$las->full_name?></a></td>
                                <td><?=$las->activity?></td>
                                <td><?=date("d-M-Y", strtotime($las->deadline))?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php }?>
</div>