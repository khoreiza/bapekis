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
        <div class="col-md-8" style="padding-right: 40px;">
            <a href="<?=base_url()?>data" style="font-size: 12px;"><span class="glyphicon glyphicon-menu-left"></span> MENU PAGE</a>
            
            <div class="row" style="padding-right: 20px; margin-top: 20px;">
                <div class="col-xs-9 col-md-9">
                    <h3 style="margin-bottom: 5px;" class="page_title">Category Management Page</h3>
                    <p class="broventh_page_description">Page for manage CBIC cateogry database</p>
                </div>
                <div class="col-xs-3 right_text">
                    <a onclick="show_category_form()" class="btn btn-broventh btn-circle btn-first"><span class="glyphicon glyphicon-plus"></span></a>
                    <div style="margin-top: 10px;">
                        <h5>Today's Date: <?=date("j M y")?></h5>
                    </div>
                </div>
            </div>
            <div class="">
                <div id="user_form_div"></div>
                <div id="user_list_div" style="padding: 20px 0px;">
                    <table class="table table-striped" id="table_id">
                        <thead>
                            <tr><th>No</th><th>Category</th><th>Menu</th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($categories as $category){?>
                            <tr id="category_<?= $category->id?>">
                                <td><?php echo $i;?></td>
                                <td>
                                    <div><a onclick="get_category_detail(<?=$category->id?>)"><?=$category->category;?></a></div>
                                    <div><?=$category->description?></div>
                                </td>
                                <td>
                                    <?=get_long_text(str_replace("_", " ", $category->menu),100)?>
                                    <?=($category->submodul) ? " - ".$category->submodul : ""?>        
                                </td>
                                <td style="font-size: 12px; width: 30px;">
                                    <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                        <a onclick="show_category_form(<?=$category->id?>,'<?=$category->menu?>','<?=$category->submodul?>')" class="edit_color"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a class="delete_color" onclick="delete_category(<?=$category->id?>,'<?=$category->menu?>')"><span class="glyphicon glyphicon-trash"></span></a>
                                    <?php }?>
                                </td>
                            </tr>
                            
                            <?php $i++; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="margin-top: 20px;" id="category_detail_div">
            
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

    function get_category_detail(id){
        $(".loading_panel").show();
        $.ajax({
            type: "GET",
            url: config.base+"data/get_category_detail",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $(".loading_panel").hide();
                    $("#category_detail_div").html(resp.html);
                }else{}
            }
        });
    }

    function delete_category(id, menu){
        $.confirm({
            title: 'Apa anda yakin?',
            content: '',
            confirmButton: 'Ya',
            confirm: function(){  
              $.ajax({
                type: "GET",
                url: config.base+"category/delete_category",
                data: {id:id, menu:menu},
                dataType: 'json',
                cache: false,
                success: function(resp){
                  console.log(resp);
                  if(resp.status==true){
                    $('#category_'+id).animate({'opacity':'toggle'});
                  }else{
                      console.log('action after failed');
                  }
                }
              });
            },
        });
    }
</script>