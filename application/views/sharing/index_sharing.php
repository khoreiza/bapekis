<style>
    .bulet_bulet{
        height:110px;
    }
    .circle_outer{
        border:1px solid #c3c3c3;
        border-radius:100px;
        height:60px; width:60px;
        margin:0 auto;
        overflow: hidden;
    }
    h4{margin:0px;}
</style>

<?php 
	$user = $this->session->userdata('userbapekis'); $user_disp="";
?>


<div class="container_broventh container_broventh_small">
    <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #e2e2e2">
        <h1 class="center_text front_title">CBIC Internal Sharing Page</h1>
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-8" style="padding-top: 15px;">
                <a style="margin-right: 5px;" onclick="show_sharing_form('','internal');" class="btn btn-broventh btn-circle btn-first"><span class="glyphicon glyphicon-pencil"></span></a> <span>Add New Sharing</span>
                <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                <a style="margin: 0 5px 0 20px;" class="btn btn-broventh btn-first btn-circle" onclick="show_category_form('','mysharing')">
                    <span class="glyphicon glyphicon-tasks"></span></a> <span>Add New Category</span>
                <?php }?>
            </div>
            <div class="col-md-4 right_text">
                <div class="input-group" style="width: 100%;">
                    <input class="form-control-minimalist with_addon" placeholder="Search Sharing" id="search_value" onkeyup="search_sharing(event)" placeholder="Search">
                    <div class="input-group-addon addon-minimalist">
                        <a style="color:white" onclick="toggle_visibility('legal_operating_filter')"><span class="glyphicon glyphicon-search"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 20px;">
        <div id="list_of_sharing"></div>
    </div>
    <div id="category_view" style="border-bottom: 1px solid #f2f2f2; padding-bottom: 40px; margin-bottom: 20px;">
        <div class="center_text">
            <div style="margin: 20px 0 0px 0;">
                <span style="font-size: 22px; padding:10px 20px 5px 20px; border-bottom:3px solid <?=array_color_new(10);?>; color:<?=array_color_new(10);?>">CATEGORIES</span>
            </div>
        </div>
        <div class="row" style="width: 100%; max-width: 760px; margin:0 auto; margin-top: 40px;">
            <?php foreach($categories as $category){ if($category->category){?>
                <div class="col-md-3" style="height: 190px; padding: 0;">
                    <div>
                        <div style="width: 100%; height: 190px; overflow: hidden; padding: 0px; background-color: #e2e2e2">
                            <img id="<?=$category->id?>_banner_category" style="width: 100%;" src="<?=base_url().$category->full_url?>">
                        </div>
                        <div style="margin-top: -40px;">
                            <div style="background-color: black; height: 40px; position: relative; z-index: 100; opacity: 0.6"></div>
                            <h4 style="padding: 10px 10px 10px 10px; margin-top: -35px; position: relative; z-index: 102">
                                <a style="color: white" onclick="show_category_sharings('<?=$category->category?>','first')"><?=$category->category?></a>
                            </h4>
                        </div>
                        <script type="text/javascript">
                            adjust_img_size('<?=$category->id?>_banner_category');
                        </script>
                    </div>
                </div>
            <?php }}?>
        </div>
        <div id="loading_category" class="center_text"></div>
    </div>
    <div id="content_of_sharings">

    </div>
    <?php if($num_sharings >= count($sharings)){?>
        <div class="center_text" id="end_of_sharings" style="margin-top: 20px;">
            <div class="center_text"><a class="btn btn-broventh btn-fifth" onclick="load_more_sharings()">LOAD MORE</a></div>
            <div id="loading"></div>
        </div>
    <?php }?>
</div>
<script>
    $(document).ready(function() {
        $("#lightgallery").lightGallery({
            selector: '.item'
        });
        load_more_sharings('first_time');
    });
    function show_sharing_form(id){
        $(".loading_panel").show();
        $.ajax({
            type: "GET",
            url: config.base+"sharing/show_sharing_form",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    //$('#modal_finder').html(resp.html);
                    //$('#sharing_form_Modal').modal('show');
                    show_popup_modal(resp.html);
                    $(".loading_panel").hide();
                }else{}
            }
        });
    }


    function load_more_sharings(type){
        if(type == "first_time"){
            $('#list_of_sharing').html('');
            $('#content_of_sharings').html('');
        }

        var next_member = $('.mysharing_member').length;
        if(next_member != <?=$num_sharings?>){
            $('#loading').html("<img src='"+config.base+"assets/img/loader_images/Preloader_3.gif' />");
            $.ajax({
                type: "GET",
                url: config.base+"sharing/reload_next_sharings",
                data: {offset: next_member, type: type},
                dataType: 'json',
                cache: false,
                success: function(resp){
                    if(resp.status==1){
                        if(type == "first_time"){
                            $('#list_of_sharing').html(resp.html);
                            load_more_sharings();
                        }
                        else{
                            if(type == "refresh"){
                                $('#content_of_sharings').html(resp.html);
                            }else{
                                $('#content_of_sharings').append(resp.html);
                            }
                        }
                    }
                    if($('.mysharing_member').length == <?=$num_sharings?> || resp.status==0){
                        $('#end_of_sharings').html('');
                    }
                    $('#loading').html('');
                }
            });
        }
    }


    function show_category_sharings(category,type){
        if(type == "first"){
            var next_member = 0;
        }
        $('#loading_category').html("<img src='"+config.base+"assets/img/loader_images/Preloader_8.gif' />");
        $.ajax({
            type: "GET",
            url: config.base+"mysharing/reload_category_sharings",
            data: {offset: next_member, category: category},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                   $('#content_of_sharings').html(resp.html);
                }
                if($('.mysharing_member').length == <?=$num_sharings?> || resp.status==0){
                    $('#end_of_sharings').html('');
                }
                $('#loading_category').html('');
                
                
            }
        });
    }
     
	
    function search_sharing(e,event,hash){
        var search = $( "#search_value" ).val();
        //$('#search_result').html(key_in);
        if((e.keyCode === 13 || event == "click")){
            $("#loading_panel").show();
            $.ajax({
                type: "GET",
                url: config.base+"mysharing/filter_search_content",
                data: {search:search},
                dataType: 'json',
                cache: false,
                success: function(resp){
                    if(resp.status==1){
                        $('#list_of_sharing').html(resp.html);
                        $("#loading_panel").hide();
                    }else{}
                }
            });
        }
    }
    
  function show_detail(id){
        $.ajax({
            type: "GET",
            url: config.base+"mysharing/show_detail",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    show_popup_modal(resp.html);
                }else{}
            }
        });
    }

    function delete_mysharing(id,type){
        $.confirm({
            title: 'Apa anda yakin?',
            content: '',
            confirmButton: 'Ya',
            confirm: function(){  
                $.ajax({
                    type: "GET",
                    url: config.base+"mysharing/delete_mysharing",
                    data: {id:id, type:type},
                    dataType: 'json',
                    cache: false,
                    success: function(resp){
                        console.log(resp);
                        if(resp.status==true){
                            $('#mysharing_'+id).animate({'opacity':'toggle'});
                            load_more_sharings('first_time');
                            //location.reload(config.base+"mysharing/index");
                        }else{
                            console.log('action after failed');
                        }
                    }
                });
            },
        });
    }
</script>