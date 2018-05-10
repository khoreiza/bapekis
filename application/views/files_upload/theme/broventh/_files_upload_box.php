<?php $user = $this->session->userdata('userbapekis');?>
<div class="broventh_submenu_div" style="margin-top: 0px;">
    <?php if(!isset($no_title_section)){?>
    <div class="broventh_submenu_title no_border">
        <div>
            <span class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;"><span class="glyphicon glyphicon-folder-open"></span></span>
            Files Upload
        </div>
    </div>
    <?php }?>
    <div class="broventh_submenu_body">
        <?=$list_files_view?>
    </div>
</div>


<!--<div class="flat_box" style="margin-top: 300px;">
    <div class="flat_box_header">
        <div class="fbh_logo"><span class="glyphicon glyphicon-file"></span></div>
        <div class="fbh_title">Files Upload</div>
        
        <?php if(!is_array($submodul)){?>
        	<div class="fbh_add">
        		<a onclick="show_form_files('<?php echo $modul?>','<?php echo $submodul?>','','<?=(isset($ownership_id)) ? $ownership_id : 0?>');"><span class="glyphicon glyphicon-plus"></span></a>
        	</div>
        <?php }?>
        
        <div style="clear: both"></div>
    </div>
    <div class="flat_box_content" style="padding: 0 10px 0 10px">
    	<div id="list_files_view_div">
    		<?=$list_files_view?>
    	</div>
    </div>
</div>-->