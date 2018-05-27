<?php 
	$user = $this->session->userdata('userbapekis');
?>
<style type="text/css">
    .menu_cbic_div{
        padding: 0 8px 0 8px;
    }
    .menu_cbic_div .broventh_card{
        border-top: 5px solid; margin-bottom: 15px;
    }
    .menu_card{
        padding-right: 10px;
    }
    .menu_card img{
        height: 42px;
    }
    .menu_card h6{
        margin-top: 10px; height: 40px;
    }
    .menu_card .news_title{
        height: 16px; overflow: hidden;
    }
</style>
<div id="" class="container_broventh container_broventh_small">
    <div class="row">
    	<div>
            <h2 class="page_title">BAPEKIS Admin Page</h2>
            <p class="broventh_page_description">Page to manage Bapekis data. This page is for Bapekis Administator only.</p>
        </div>
        <div class="col-md-8">
            <div class="broventh_submenu_div" style="margin-top: 0px;">
                <div class="broventh_submenu_title no_border">
                    <div class="row">
                        <div class="col-md-7">
                            <span class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;"><span class="glyphicon glyphicon-tasks"></span></span>
                            List of Menu
                        </div>
                        <div class="col-md-5 right_text">
                            <div class="input-group" style="width: 100%;">
                                <input class="form-control-minimalist with_addon" value="" id="search_filter" onchange="filter_project_list()" placeholder="Search Data">
                                <div class="input-group-addon addon-minimalist"><span class="glyphicon glyphicon-search"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="broventh_submenu_body" id="" style="margin-top: 40px;">
                    <div class="row">
                        <div class="col-md-4 menu_cbic_div">
                            <div class="broventh_card" style="border-top-color:<?=array_color_new(3)?>">
                                <div class="row menu_card">
                                    <div class="col-xs-3 center_text">
                                        <img src="<?=base_url()?>assets/img/icon/new contact - office.png">
                                    </div>
                                    <div class="col-xs-9">
                                        <h5 class="news_title"><a href="<?=base_url()?>user/management">User Data Management</a></h5>
                                        <h6>Manage profile information for BAPEKIS user</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 menu_cbic_div">
                            <div class="broventh_card" style="border-top-color:<?=array_color_new(1)?>">
                                <div class="row menu_card">
                                    <div class="col-xs-3 center_text">
                                        <img src="<?=base_url()?>assets/img/icon/web design - office.png">
                                    </div>
                                    <div class="col-xs-9">
                                        <h5 class="news_title"><a href="<?=base_url()?>sharing">Sharing Management</a></h5>
                                        <h6>Manage Sharing Data</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 menu_cbic_div">
                            <div class="broventh_card" style="border-top-color:<?=array_color_new(5)?>">
                                <div class="row menu_card">
                                    <div class="col-xs-3 center_text">
                                        <img src="<?=base_url()?>assets/img/icon/calendar - office.png">
                                    </div>
                                    <div class="col-xs-9">
                                        <h5 class="news_title"><a href="<?=base_url()?>calendar">Event Management</a></h5>
                                        <h6>Data parser and uploader menu for CBIC</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 menu_cbic_div">
                            <div class="broventh_card" style="border-top-color:<?=array_color_new(7)?>">
                                <div class="row menu_card">
                                    <div class="col-xs-3 center_text">
                                        <img src="<?=base_url()?>assets/img/icon/web design - office.png">
                                    </div>
                                    <div class="col-xs-9">
                                        <h5 class="news_title"><a href="<?=base_url()?>category">Category Management</a></h5>
                                        <h6>Manage Category for Sharing</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 menu_cbic_div">
                            <div class="broventh_card" style="border-top-color:<?=array_color_new(11)?>">
                                <div class="row menu_card">
                                    <div class="col-xs-3 center_text">
                                        <img src="<?=base_url()?>assets/img/icon/bar - office.png">
                                    </div>
                                    <div class="col-xs-9">
                                        <h5 class="news_title"><a href="<?=base_url()?>category">Financial Management</a></h5>
                                        <h6>Manage Category Data</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 menu_cbic_div">
                            <div class="broventh_card" style="border-top-color:<?=array_color_new(9)?>">
                                <div class="row menu_card">
                                    <div class="col-xs-3 center_text">
                                        <img src="<?=base_url()?>assets/img/icon/images - office.png">
                                    </div>
                                    <div class="col-xs-9">
                                        <h5 class="news_title"><a href="<?=base_url()?>data/tutorial">Banner Picture</a></h5>
                                        <h6>Manage Page & Tutorial Data</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>