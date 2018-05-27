<?php 
	$user = $this->session->userdata('userdb'); $user_disp="";
    $arr_menu_icon = array('risk_documentation');
    $this_menu = isset($category) ? $category->menu : $menu;
?>

<div style="margin-top:20px;">
	<div style="margin-top:0px;">
        <form 
            class="form-horizontal" 
            action="<?=base_url()."category/store/"?><?=(isset($category)) ? $category->id : '';?>"
            method ="post" id="formnew" role="form" enctype="multipart/form-data">
            
            <input type="hidden" name="menu" value="<?=$menu?>">
            <input type="hidden" name="submodul" value="<?=$submodul?>">

            <div class="form_group_part_description">Category, Description, Menu, Sub Modul</div>
            <div class="form_group_part_title">Category Form Information</div>

            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-1">
                    <input type="text" class="form-control-minimalist" id="category" name="category" placeholder="Category" value="<?=isset($category) ? $category->category : ""?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-1">
                    <textarea class="form-control-minimalist" name="description" placeholder="Description"><?=isset($category) ? $category->description : ""?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-5 col-sm-offset-1">
                    <input type="text" class="form-control-minimalist" id="menu" name="menu" placeholder="Menu" value="<?=isset($category) ? $category->menu : $menu?>">
                </div>
                <div class="col-sm-5">
                    <input type="text" class="form-control-minimalist" id="submodul" name="submodul" placeholder="Sub Modul" value="<?=isset($category) ? $category->submodul : $submodul?>">
                </div>
            </div>   
            
            <?php if(in_array($this_menu, $arr_menu_icon)){?>
            <div class="form-group row">
                <div class="col-sm-5 col-sm-offset-1">
                    <select data-live-search="true" class="selectpicker" name="icon" data-width="100%" id="icon_image" title="--Select Icon--" onchange="show_icon_preview()">
                        <?php foreach($icons as $icon){?>
                            <option value="<?=$icon->icon_filename?>"><?=$icon->icon_name?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-sm-5">
                    <div id="icon_preview" style="width:50px; margin:0 auto;">
                    </div>
                </div>
            </div>
            <?php }?>

            <div class="center_text button_form_submit">
                <hr>
                <button class="btn btn-broventh btn-circle btn-first btn-lg" type="submit"><span class="glyphicon glyphicon-save"></span></button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function show_icon_preview(){
        var icon_image = $("#icon_image").val();
        $("#icon_preview").html('<img style="width:100%" src="'+config.base+'/assets/img/icon/'+icon_image+'">');
    }
</script>