<style type="text/css">

	/************************************ CBIC NEW BROVENTH CSS HEADER ************************************/

	/********* FONT FAMILY *********/
	@font-face {
	  font-family: "fakt-light";
	  src: url('<?=base_url()?>assets/fonts/Fakt/FaktFlipboard-Light.woff');
	}

	@font-face {
	  font-family: "fakt-medium";
	  src: url('<?=base_url()?>assets/fonts/Fakt/FaktFlipboard-Medium.woff');
	}

	@font-face {
	  font-family: "fakt-normal";
	  src: url('<?=base_url()?>assets/fonts/Fakt/FaktFlipboard-Normal.woff');
	}

	@font-face {
	  font-family: "fakt-semibold";
	  src: url('<?=base_url()?>assets/fonts/Fakt/FaktFlipboard-SemiBold.woff');
	}

	@font-face {
	  font-family: "fakt-semicon";
	  src: url('<?=base_url()?>assets/fonts/Fakt/FaktFlipboard-SmCon.woff');
	}

	@font-face {
	  font-family: "atlas-light";
	  src: url('<?=base_url()?>assets/fonts/AtlasGrotesk/AtlasGrotesk-Light.woff2');
	}

	@font-face {
	  font-family: "atlas-medium";
	  src: url('<?=base_url()?>assets/fonts/AtlasGrotesk/AtlasGrotesk-Medium.woff2');
	}

	@font-face {
	  font-family: "atlas-reguler";
	  src: url('<?=base_url()?>assets/fonts/AtlasGrotesk/AtlasGrotesk-Regular.woff2');
	}

	label{
		font-weight: 200 !important;
	}

	.logo_company a:hover{
		text-decoration: none;
	}
	h1,h2,h3,h4,h5,h6{
		padding:0px;
		margin:0;
	}
	.navbar-top {
		padding:0 0px 0 0px;
		width: 100%;
		z-index: 1000;
		background-color: #ffffff;

		-webkit-box-shadow: 0 3px 5px rgba(57, 63, 72, 0.3);
  		-moz-box-shadow: 0 3px 5px rgba(57, 63, 72, 0.3);
  		box-shadow: 0 2px 5px rgba(124, 124, 131, 0.3);
	}
	


	#popup_cbic_menu{
		border:1px solid #dedede; 
		margin:0px 0 0 20px; 
		border-radius:5px; 
		width:840px;
	}

	/*CSS for new CBIC search Box*/
	.cbic_search_box{
		border-radius: 0 !important;
		border: 0px solid #ffffff;
		background-color: #fafafa;
		appearance: none;
	}
	.cbic_search_box_addon{
		background-color: #fafafa;
		padding: 15px 10px 15px 10px;
	}
	.cbic_search_box_addon .btn-default{
		border-color: #ffffff;
		border-left: 0px;
		border-radius: 0px;
	}
	/*CSS for new CBIC search Box*/


	/*CSS for new CBIC Icon Submenu*/	
	.user_icon_submenu .col-xs-4{
		padding: 0 8px 0 8px;
	}
	.border_icon_submenu{
		padding:5px; text-align: center;
		border-radius: 100px;
		font-size: 18px;
		height: 35px; width: 35px;
		background-color: #ffffff;
	}
	.border_icon_submenu:hover{
		color: #d2d2d2 !important;
	}
	.border_icon_submenu:hover a{
		color: <?=array_color_new(2)?>;
	}
	.border_icon_submenu a{
		color: <?=array_color_new(2)?>;
	}
	.border_icon_submenu a:hover{
		color: #d2d2d2;
	}
	

	/*CSS for new CBIC Menu Submenu*/
	.header_menu_group ul.cbic_submenu{
	    display: inline-flex;
	    list-style: none;
	    margin-bottom: 0px;
	}
	.header_menu_group li{
		padding: 0 15px 8px 15px;
	}
	.header_menu_group li a{
	    color: #999;
	    text-decoration: none;
	    padding: 5px 0px 0px 0px;
	    display: block;
	}

	.header_menu_group li a:hover {
		color: #222;
	}

	.header_menu_group li.active {
	 	color: white;
	    cursor: default;
	    background-color: <?=array_color_new(2)?>;
	}

	.header_menu_group li.active a{
		color: <?=array_color_new(2)?>;
	}

	#user_menu_dropdown{
	  	margin-top: -5px;
	}
	

	/*CSS for new CBIC Div sub menu*/
	@media (max-width: 1087px) {
	  .submenu_not_show {
	    display:none;
	  }
	  .clear_for_margin{
	  	margin-bottom: 10px;
	  }
	  #user_menu_dropdown{
	  	margin-top: 0px;
	  }
	}

	@media (max-width: 878px) {
	  .submenu_left_not_show {
	    display:none;
	  }
	  .submenu_user_notif{
	  	width: 50%;
	  }
	}

	/************************************ CBIC NEW BROVENTH CSS BODY ************************************/
	body{
		font-size:14px;
		background-color: #f1f5f7 !important;
		/*background-color: #e2e6e7 !important;*/
		font-family: "fakt-normal";
		color:#777;
	}
	body a{
		color: <?=array_color_new(2)?>;
	}
	body a:hover{
		color: <?=array_color_new(10)?>;
		text-decoration: none;
	}

	.container_broventh{
		margin:0 auto;
		margin-top: 0px;
		padding: 45px 40px 20px 40px;
		width:100%;
	}

	.container_broventh_small{
		max-width: 1550px;
	}

	.container_broventh .theme_color{
		color:<?=array_color_new(2)?>;
	}

	.container_broventh .body_color{
		color:#777;
	}

	.container_broventh .first_color{
		color:#137c93;
	}

	.container_broventh .second_color{
		color:<?=array_color_new(6)?>;
	}

	.container_broventh .third_color{
		color:#137c93;
	}

	.container_broventh .fourth_color{
		color:<?=array_color_new(4)?>;
	}
	.broventh_sidebar{
		padding-left: 40px;
	}

	/********** Div Custom Section ************/
	.hide_card{
		display: none;
	}
	.broventh_card{
		background-color: white;
		box-shadow: 0 4px 2px -3px #d2d2d2;
		padding: 10px;
		margin-bottom: 10px;
		border:1px solid #dfdfdf;
		border-bottom-color: #cfcfcf;
		overflow: hidden;
		border-radius: 5px;
	}

	.broventh_card_transparent{
		background-color: #fafafa;
		padding: 10px;
		margin-bottom: 10px;
		border:1px solid #dfdfdf;
		border-bottom-color: #cfcfcf;
		overflow: hidden;
		border-radius: 5px;
	}

	.broventh_card_transparent hr{
		border-top: 1px solid #e3e3e3 !important;
	}

	.broventh_card_square{
		background-color: white;
		box-shadow: 0 4px 2px -3px #d2d2d2;
		padding: 10px;
		margin-bottom: 10px;
		border:1px solid #dfdfdf;
		border-bottom-color: #cfcfcf;
		overflow: hidden;
	}


	.square_box{
		background-color: white;
		box-shadow: 1px 3px 5px #a2a2a2;
		padding: 0px;
		margin-bottom: 10px;
		border-top: 3px solid <?=array_color_new(2)?>;
		/*overflow: auto;*/
	}

	.square_box_title{
		padding:10px 20px 5px 20px;
		color:<?=array_color_new(10)?>; font-size: 22px;
		margin-bottom: 0px;
	}

	.square_box_title_add{
		float:left;
		
		padding: 12px 15px 8px 25px;
		margin:-32px -15px -8px;
		font-size: 16px;
	}

	.square_box_title_add a{color:#727272 !important;}

	.square_box_body{
		padding: 10px 15px 10px 15px;
	}


	.broventh_submenu_div{
		margin-top:20px; padding:10px 0px 10px 0;
	}

	.broventh_submenu_div.with_border{
		border-top:1px solid #e2e2e2;
		padding-top: 25px;
	}

	.broventh_submenu_title{
		color:<?=array_color_new(10)?>; font-size: 22px;
		padding-bottom:10px; margin-bottom: 20px; border-bottom:1px solid #e2e2e2;
	}

	.broventh_submenu_title.no_border{
		margin-bottom: 10px;
		border-bottom:0;
	}

	.broventh_submenu_title a{
		color:<?=array_color_new(10)?>;
	}

	.broventh_page_description{
		font-size: 16px;
		padding: 5px 0 10px 0;
		color:<?=array_color(9)?>;
		font-family: "fakt-normal";
	}

	.photo_frame_circle{
		overflow: hidden; margin:0 auto; border-radius: 160px;
	}

	.section_border_separation{
		padding-bottom: 15px;
		border-bottom: 1px solid #e2e2e2; margin-bottom: 10px;
	}

	.section_no_border_separation{
		padding-bottom: 15px;
		margin-bottom: 10px;
	}




	/******* MENU BAR ********/
    .broventh_card.menu_bar_nav{
    	margin:0px !important;
    	padding: 0px;

    }

    .menu_bar_header_nav{
    	margin-top: 0px; margin-bottom: 0px; padding-top: 0px;
    }

    .menu_bar_div{
    	display: none;
    }

    .menu_bar{
        height: 62px;
        float: left;
		border-right: 1px solid #e2e2e2;
    }

    .menu_bar, .menu_bar_nav > a{
    	font-size: 20px;
        text-align: center;
		color:#666;
    }

    .menu_bar_nav{
    	padding: 15px 40px 15px 40px;
    }

    .menu_bar_right{
        padding: 0px 5px 0 40px;
        float: right;
        text-align: right;
    }

    .active_menu_bar{
    	border-bottom: 4px solid <?=array_color_new(2)?>;
    	font-family: "fakt-semicon";
    }
    /******* END of MENU BAR ********/


    /******* MENU CONTENT ********/
    .menu_content_section{
    	margin-top: 20px;
    	padding: 0px;
    }
    .menu_section_title{
    	font-size: 16px;
    	text-align: right;
    	font-family: "fakt-semibold";
    	color: #c0aa63;
    	margin-bottom: 10px;
    }
    /******* END of MENU CONTENT ********/

    

	/**** POP UP MOdul *****/
	.modal-content{
		border-radius: 0px !important;
		margin-top: 40px !important;
	}
	.pop_up_content_broventh{
		padding: 20px 15px 20px 15px !important;
	}
	/**** End POP UP MOdul *****/


	.cirlce_frame_broventh{
		border-radius: 100px;
		background-color: <?=array_color_new(2)?>;
		color:white;
		padding: 10px;
		padding-top: 8px;
		font-size: 20px;
		height: 40px; width: 40px;
	}
	.number_of_notif{
		padding: 1px 5px 1px 5px;
		background-color: <?=array_color_new(4)?>;
		color: white;
		font-size: 11px;
		margin-top: -30px;
		margin-left: 15px;
		
		border-radius: 5px;
		float: left;
	}



	/********** Profile Menu Tab ************/
	.profile_sub_menu{
		padding-bottom: 10px; width: 12.5%;
	}
	.profile_sub_menu.active{
		border-bottom: 2px solid <?=array_color_new(2)?>;
	}
	.profile_sub_menu a{
		color:<?=array_color(9)?>;
	}
	.profile_sub_menu.active a{
		color: <?=array_color_new(2)?>;
	}
	/********** Profile Menu Tab ************/


	/********** Div Custom Section ************/




	/********** Font Custom Section ************/
	.news_title, .news_title > a{
		font-family: "fakt-semicon";
		color:#666;
	}

	.content_title, .content_title > a{
		font-family: "fakt-semicon";
		color:#79a0d5;
	}

	.condens_font{
		font-family: "fakt-semicon";
	}

	.light_font{
		font-family: "fakt-light";
	}
	.semibold_font{
		font-family: "fakt-semibold";
	}

	h4.news_title{
		line-height: 22px;
	}

	.page_title{
		color:<?=array_color_new(10)?>;
		font-family: "fakt-normal";
	}

	.text_description{
		font-family: "fakt-normal";
		color:#888;
	}

	.front_title{
		font-family: "atlas-light" !important;
		color:<?=array_color_new(10)?>;
	}

	.category_label{
		font-family: "fakt-normal";
        text-transform: uppercase;
        font-size: 10px;
        padding-bottom: 1px;
        border-bottom: 1px solid <?=array_color_new(8)?>;
        color:<?=array_color_new(5)?>;
    }
	/********** End Font Custom Section ************/


	/********** Button Custom Section ************/


	.btn-broventh{
		padding:8px 8px 8px 8px;
		border-radius: 5px;
		color:white !important;
		border: 1px solid #e7e7e7;
	}
	.btn-broventh.btn-circle{
		border-radius: 220px;
		text-align: center !important;
		padding: 8px 4px 0 8px; font-size: 14px;
		height: 29px; width: 29px;
	}

	.btn-broventh.btn-lg{
		height: 40px !important; width: 40px !important;
		font-size: 20px;
		padding-top: 7px;
	}
	
	.btn-broventh.btn-full, .btn-brobot.active{
		color:#c2c2c2 !important;
	}
	
	.btn-broventh.btn-first{
		background-color:<?=array_color_new(2)?>;
	}

	.btn-broventh.btn-second{
		background-color:<?=array_color_new(3)?>;
	}

	.btn-broventh.btn-third{
		background-color:<?=array_color_new(8)?>;
		color:<?=array_color(8)?> !important;
	}

	.btn-broventh.btn-fourth{
		background-color:<?=array_color_new(5)?>;
	}

	.btn-broventh.btn-fifth{
		background-color:<?=array_color_new(1)?>;
	}

	.btn-broventh.btn-white{
		background-color:#fff;
		color: #888 !important;
	}

	.btn-broventh.btn-edit{
		background-color:#fae6c9 !important;
		color: #888 !important;
	}

	.btn-broventh.btn-delete{
		background-color:#fcd7d2 !important;
		color: #888 !important;
	}

	.btn-broventh:hover{
		color:white !important;
		background-color:<?=array_color_new(10)?>;
	}

	.btn-broventh .glyphicon{
		padding-right: 5px;
	}

	.bootstrap-select .btn.dropdown-toggle{
		border-radius: 0 !important;
		height: 42px !important;
		color: #555;
	}
	.dropdown-menu{
		border-radius: 0 !important;
	}
	.edit_background_color{
		background-color: #f0ad4e !important;
	}
	/********** End Button Custom Section ************/


	/********** Form Custom Section ************/
	.form-control-minimalist {
		/* Font: Open Sans Regular / 16px / #333333 */
		font-size: 14px;
		display: block;
		width: 100%;
		height: 42px;
		padding: 6px 6px 6px 12px;
		line-height: 16px;
		color: #333333;
		vertical-align: middle;
		background-color: transparent;
		outline: none;
		border-radius: 0px !important;
		border: none !important;
		-webkit-box-shadow: none !important;
		-moz-box-shadow: none !important;
		box-shadow: none !important;
		border: 1px solid #d2d2d2 !important;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}
	.form-control-minimalist:focus { /* Font: Open Sans Light / 16px / #333333 */
		border-color: none !important;
		border: 1px solid <?=array_color_new(3)?> !important; 	/*added as suggested by antikode 22-02-2015*/
	  		-webkit-box-shadow: none;
	          box-shadow: none;					/*end of suggested by antikode 22-02-2015*/

	}
	.form-control-minimalist::-webkit-input-placeholder { /* Field Text Font: Open Sans Light / 16px / #C8CBD1 */
		color: #aaa !important;
	}
	.form-control-minimalist::-moz-placeholder { /* Field Text Font: Open Sans Light / 16px / #C8CBD1 */
		color: #bbb;
	}

	textarea.form-control-minimalist{
		height: 80px !important;
	}

	.addon-minimalist{
		background-color: <?=array_color_new(2)?> !important;
		color: white;
		border-left: 0;
		margin-left: -10px;
		border-color: <?=array_color_new(2)?> !important;
		border-radius: 0;
	}

	.floating_footer {
		display: block;
	}

	.control-label{
		color:<?=array_color_new(3)?> !important;
	}

	.form-borventh .form-group{
		padding-left: 40px !important;
	}

	.form_navigation{
		margin-top: 40px;
	}
	.nav_form_sign{
		margin-top: 7px;
		font-size: 12px;
		font-family: "fakt-light";
	}
	.form_group_part_title{
		font-family: "fakt-light";
		color:#666;
		font-size: 24px;
		text-align: center;
		margin-bottom: 20px;
	}
	.form_group_part_description{
		font-family: "fakt-light";
		color:#999;
		font-size: 14px;
		text-align: center;
		margin-bottom: 0px;
	}
	/********** End Form Custom Section ************/

	/************************************ END CBIC NEW BROVENTH CSS ************************************/

</style>