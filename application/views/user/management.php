<style type="text/css">
    .status_account_user{
        color:<?=array_color_new(5)?>;
    }
    .status_account_user.active{
        color:<?=array_color_new(0)?>;
    }
</style>
<?php $user = $this->session->userdata('userbapekis');?>
<div class="container_broventh container_broventh_small">
    <div class="row" style="padding:0 20px;">
        <div class="col-md-9" style="padding-right: 40px;">
            <a href="<?=base_url()?>admin" style="font-size: 12px;"><span class="glyphicon glyphicon-menu-left"></span> MENU PAGE</a>
            
            <div class="row" style="padding-right: 20px; margin-top: 20px;">
                <div class="col-xs-10 col-md-10">
                    <h3 style="margin-top: 0px;" class="page_title">User Data Management</h3>
                    <p class="broventh_page_description">Management profile information for CBIC user</p>
                </div>
                <div class="col-xs-2 right_text">
                    <a onclick="show_user_form()" class="btn btn-broventh btn-circle btn-first"><span class="glyphicon glyphicon-plus"></span></a>
                </div>
            </div>
            <div class="">
                <div id="user_form_div"></div>
                <div id="user_list_div" style="padding: 20px 0px;">
                    <table class="table table-striped" id="table_id">
                        <thead style="font-size: 12px;">
                            <tr><th>No</th><th>PP</th><th>Nama</th><th>Direktorat</th><th>Status</th><th>NDA</th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($users as $luser){?>
                            <tr id="usersu_<?php echo $luser->id?>">
                                <td><?php echo $i;?></td>
                                <td>
                                    <div class="photo_frame_circle" style="height: 30px; width:30px;">
                                        <?=employee_photo_thumb($luser)?>
                                    </div>
                                </td>
                                <td>
                                    <a onclick="show_user_data_detail(<?=$luser->id?>)"><?php echo $luser->full_name;?></a>
                                    <div style="font-size: 10px;">
                                        <?= $luser->position.dot_devider().$luser->nik;?>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo get_long_text($luser->directorate,200);?></h5>
                                    <div style="font-size: 10px;" title="<?= get_long_text($luser->group,200).dot_devider().get_long_text($luser->department,200);?>">
                                        <?= first_letter_text(get_long_text($luser->group,200),30)
                                        .dot_devider().
                                        first_letter_text(get_long_text($luser->department,200),30);?>
                                    </div>
                                </td>
                                <td style="font-size: 12px;">
                                    <div class="status_account_user <?=($luser->status == "active") ? 'active' : '' ?>" id="status_account_<?=$luser->id?>"><?= get_long_text($luser->status,20);?></div>
                                </td>
                                <td style="font-size: 12px;">
                                    <div style="color: <?=($luser->is_NDA) ? array_color_new(2) : '#c2c2c2' ?>"><?=($luser->is_NDA) ? "Signed" : "Not Yet";?></div>
                                </td>
                                <td style="font-size: 12px;">
                                    <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                        <a onclick="show_user_form(<?=$luser->id?>)" class="edit_color"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a class="delete_color" onclick="delete_user(<?php echo "'".$luser->id."'";?>)"><span class="glyphicon glyphicon-trash"></span></a>
                                    <?php }?>
                                </td>

                            </tr>
                            
                            <?php $i++; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="margin-top: 20px;" id="user_detail_div">
            
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/data.js"></script>
<script>
    $(document).ready(function () {         
        $('#table_id').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
            ]
        } );
    });


</script>