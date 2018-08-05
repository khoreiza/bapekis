<?php $user = $this->session->userdata('userbapekis');?>
<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:100%; max-width: 900px;">
        <div class="modal-content">
           <div class="modal-body">
               <div>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
                <div class="pop_up_content_brobot">
                <div class="row" style=" margin-bottom:20px; padding-bottom: 5px; border-bottom: 1px solid #c3c3c3">
                    <div class="col-sm-2" style="height: 40px; overflow: hidden;">
                        <img class="right_text" style="height: 80px;" src="<?=base_url()?>assets/img/general/brobot-owl.png">
                    </div>
                    <div class="col-sm-10 right_text" style="margin-top: 15px;">
                        <h3><?php long_text($modul,100); echo " "; long_text($submodul,100)?> Files</h3>
                        <?php if(isset($popup_subtitle)){?><h4 class="third_font"><?=$popup_subtitle?></h4><?php }?>
                    </div>
                </div>
                <div id="loading_panel" class="center_text loading_panel" style="display:none; padding:5px; width:100%; background-color:white;">
                        <?php $rand_num = rand(1,7);?>
                        <img src="<?=base_url()?>assets/img/loader_images/Preloader_<?=$rand_num?>.gif">
                        <div>Loading Data . . .</div>
                    </div>
                <div>
                    <div>
                        
                        <div style="margin-top:20px;">
                            <table class="table display" id="table_id" style="">
                                <thead>
                                    <tr class="second_font">
                                        <th style="width: 40px;">No</th>            
                                        <th>File Name</th>
                                        <th>Upload Date</th>
                                        
                                        <?php if($modul == "account plan"){?>
                                            <th>Segment</th>
                                        <?php }?>
                                        
                                        <th style="width: 40px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;
                                    foreach($files as $row){
                                    ?>
                                    <tr class="file_<?php echo $row->id?>">
                                        <td><?php echo $i?></td>
                                        <td title="<?php echo $row->title?>">
                                            <div>
                                                <span><img style="height:18px" src="<?php echo base_url()?>assets/img/icon/<?php echo get_file_ext_office($row->ext)?>"></span>

                                                <?php if($row->full_url){?>
                                                    <a target="_blank" href="<?php echo base_url()?><?php echo $row->full_url;?>">
                                                <?php }else{ ?>
                                                   <a target="_blank" href="<?php echo base_url()?>assets/uploads/<?=$modul?>/publications/<?php echo $row->file_name;?>">
                                                <?php } ?>
                                                    <?php echo long_text_real($row->title,60)?>
                                                </a>
                                            </div>
                                            <?php if($row->description){?>
                                                <div style="font-size: 12px; margin-top: 5px;"><?php long_text_real(strip_tags($row->description),120)?></div>
                                            <?php }?>
                                        </td>
                                        <td class="center_text"><?=date("j M y",strtotime($row->created_at))?></td>

                                        <?php if($modul == "account plan"){?>
                                            <td><?php
                                                $segment_write = "";
                                                $segments = explode(";", $row->segment_allowed);
                                                unset($segments[count($segments)-1]);
                                                foreach($segments as $segment){
                                                    $segment_write .= ucwords($segment);
                                                    if($segment != end($segments) && $segment) $segment_write .= ", ";
                                                }
                                                echo $segment_write;
                                            ?></td>
                                        <?php }?>

                                        <td class="right_text">
                                            <?php if(($user['id'] == $row->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                                <a onclick="show_form_files('<?php echo $modul?>','<?php echo $submodul?>','<?php echo $row->id?>');">
                                                    <span class="glyphicon glyphicon-pencil" style="color:#f0ad4e"></span>
                                                </a>
                                            <?php }?>
                                            <?php if(($user['id'] == $row->created_by) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                                <a onclick="delete_files_upload(<?php echo $row->id?>)">
                                                    <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
                                                </a>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(function () {
		$(document).ready(function () {			
			
			$('#table_id').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'pageLength'
                ]
            });
		})
	})
</script>