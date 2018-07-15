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
    .news_modul{
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
</style>

<?php 
	$user = $this->session->userdata('userbapekis');
?>


<div class="container_broventh container_broventh_small">
    <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #e2e2e2">
        <a href="<?=base_url()?>admin" style="font-size: 12px;"><span class="glyphicon glyphicon-menu-left"></span> ADMIN PAGE</a>
        <h1 class="center_text front_title" style="margin-top: 10px">Bapekis Sharing Management</h1>
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-8" style="padding-top: 15px;">
                <a style="margin-right: 5px;" onclick="show_sharing_form();" class="btn btn-broventh btn-circle btn-first"><span class="glyphicon glyphicon-pencil"></span></a> <span>Add New Sharing</span>
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
    <div class="row">
        <div class="col-md-9 column" style="padding-right: 20px;">
            <div id="category_title_div" style="display: none; margin-bottom: 20px;">
                <div class="right_text"><a href="<?=base_url().$this->uri->uri_string()?>" class="btn btn-circle btn-third btn-broventh">X</a></div>
                <h2 id="category_title" class="center_text news_title" style=""></h2>
            </div>
            <div id="loading_sign" class="center_text"></div>
            
            <div id="list_news_section">
                <div id="list_sharings_div">
                    <?php /*$list_news_view*/ ?>
                </div>
                <?php if($num_sharings >= count($sharings)){?>
                    <div class="center_text" id="end_of_sharings" style="margin-top: 20px;">
                        <div class="center_text"><a class="btn btn-broventh btn-fifth" onclick="load_more_sharings()">LOAD MORE</a></div>
                        <div id="loading"></div>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="col-md-3 column">
            <div class="broventh_card">
                <h4 class="news_title center_text">Sharing Category</h4>
                <div style="margin-top: 20px">
                    <?php foreach($categories as $categ){if($categ->count){?>
                        <a onclick="show_market_category_news(<?=$categ->category_id?>,'<?=$categ->category?>','')">
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-xs-10"><?=($categ->category) ? $categ->category : "Others"?></div>
                                <div class="col-xs-2 right_text">(<?=$categ->count?>)</div>
                            </div>
                        </a>
                    <?php }}?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#lightgallery").lightGallery({
            selector: '.item'
        });
        load_more_sharings('first_time');
    });

    function load_more_sharings(type){

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
                            $('#list_sharings_div').html(resp.html);
                            //load_more_sharings();
                        }
                        else{
                            $('#list_sharings_div').append(resp.html);
                            /*
                            if(type == "refresh"){
                                $('#content_of_sharings').html(resp.html);
                            }else{
                                $('#content_of_sharings').append(resp.html);
                            }*/
                        }
                        //$('#list_sharings_div').append(resp.html);
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
                    url: config.base+"sharing/delete_mysharing",
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