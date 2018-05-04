<?php
	$user = $this->session->userdata('userdbcisam'); $user_disp="";
?>
<style type="text/css">
	/* The side navigation menu */
    .sidenav {
        height: 100%; /* 100% Full-height */
        width: 0; /* 0 width - change this with JavaScript */
        position: fixed; /* Stay in place */
        z-index: 9999; /* Stay on top */
        top: 0;
        left: 0;
        background-color: #f4f4f4; /* Black*/
        overflow-x: hidden; /* Disable horizontal scroll */
        padding-top: 0px; /* Place content 60px from the top */
        transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
        border-right: 1px solid #e2e2e2;
        padding-bottom: 60px;
    }

    /* The navigation menu links */
    .sidenav_link a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        color: #818181;
        display: block;
        transition: 0.3s
    }

    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover, .offcanvas a:focus{
        color: <?=array_color_new(9)?>;
    }

    /* Position and style the close button (top right corner) */
    .sidenav .closebtn {
        font-size: 18px;
        color:#c2c2c2;
    }

    /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
    #main {
        transition: margin-left .5s;
        padding: 20px;
    }

    .sub_menu_grouping{
    	border-top:1px solid #e2e2e2;
    	padding: 20px 10px 10px 32px;
    }

    .sub_menu_grouping .news_title{
    	font-size: 12px;
    	color:<?=array_color_new(2)?> !important;
    }

    .menu_list{
    	list-style: none;
    	padding: 20px 0 0 0;
    	display: none;
    }

    .menu_list > li > a{
    	padding: 8px 8px 8px 0px;
        text-decoration: none;
        color: #818181;
        display: block;
        transition: 0.3s
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }
</style>

<div id="mySidenav" class="sidenav">
    <div class="row" style="background-color: white !important; padding: 10px 10px 20px 20px;">
    	<div class="col-xs-10">
    		<img style="padding-top:10px; width:100%; max-width: 120px;" src="<?=base_url()?>assets/img/general/sam-logo.png"></img>
    	</div>
    	<div class="col-xs-2 right_text" style="padding-top: 25px;">
    		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
    			<span class="glyphicon glyphicon-menu-hamburger"></span>
    		</a>
    	</div>
    	
	</div>
	<div>
	    <div class="sidenav_link">
		    <a href="<?=base_url()?>"><span style="margin-right: 10px;" class="glyphicon glyphicon-home"></span> What's On</a>
		    <!-- <a href="<?=base_url()?>profile"><span style="margin-right: 10px;" class="glyphicon glyphicon-user"></span>Profile</a> -->
		    <a onclick="show_external_link()"><span style="margin-right: 10px;" class="glyphicon glyphicon-link"></span> External Link</a>
		    <!-- <a href="#"><span style="margin-right: 10px;" class="glyphicon glyphicon-comment"></span> Messaging</a> -->
		</div>
	    <div class="sub_menu_grouping">
	    	<a onclick="toggle_visibility('operating_list_menu')">
	    		<span class="pull-right glyphicon glyphicon-chevron-down"></span>
	    		<h5 class="news_title">OPERATING</h5>
	    	</a>
	    	<ul class="menu_list" id="operating_list_menu">
	            <li>
	            	<a href="<?=base_url()?>commitment">
	            		<img style="height:20px;" src="<?php echo icon_url('to do - office.png')?>">
        				<span style="margin-left: 5px;">Commitment Monitoring</span>
	            	</a>
	            </li>
	            <li>
	            	<a href="<?=base_url()?>meeting">
	            		<img style="height:20px;" src="<?php echo icon_url('sign up - office.png')?>">
        				<span style="margin-left: 5px;">Booking Meeting Room</span>
	            	</a>
	            </li>
	            <!-- <li>
	            	<a href="<?=base_url()?>profile">
	            		<img style="height:20px;" src="<?php echo icon_url('podium - office.png')?>">
        				<span style="margin-left: 5px;">Profile</span>
	            	</a>
	            </li> -->
	            <!-- <li>
	            	<a href="<?=base_url()?>account_planning">
	            		<img style="height:20px;" src="<?php echo icon_url('torah - color.png')?>">
        				<span style="margin-left: 5px;">Account Plan Page</span>
	            	</a>
	            </li> -->
	            <li>
	            	<a href="<?=base_url()?>legal">
	            		<img style="height:20px;" src="<?php echo icon_url('fine print - office.png')?>">
        				<span style="margin-left: 5px;">Legal Page</span>
	            	</a>
	            </li>
	            <!-- <li>
	            	<a href="<?=base_url()?>ssf">
	            		<img style="height:20px;" src="<?php echo icon_url('cash in hand - office.png')?>">
        				<span style="margin-left: 5px;">SSF Page</span>
	            	</a>
	            </li> -->
	            <!-- <li>
	            	<a href="<?=base_url()?>credit_pipeline">
	            		<img style="height:20px;" src="<?php echo icon_url('refund - office.png')?>">
        				<span style="margin-left: 5px;">Cashflow Credit</span>
	            	</a>
	            </li> -->
	            <!-- <li>
	            	<a href="<?=base_url()?>fund_pipeline">
	            		<img style="height:20px;" src="<?php echo icon_url('cash in hand - office.png')?>">
        				<span style="margin-left: 5px;">Cashflow Dana</span>
	            	</a>
	            </li> -->
	            <!-- <li>
	            	<a href="<?=base_url()?>obligo/summary">
	            		<img style="height:20px;" src="<?php echo icon_url('workers - office.png')?>">
        				<span style="margin-left: 5px;">Obligo Monitoring</span>
	            	</a>
	            </li> -->
	            <!-- <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
	            	<li>
		            	<a href="<?=base_url()?>inventory">
		            		<img style="height:20px;" src="<?php echo icon_url('drawer - color.png')?>">
	        				<span style="margin-left: 5px;">Inventory</span>
		            	</a>
		            </li>
	            <?php }?> -->
	          </ul>
	    </div>
	    <div class="sub_menu_grouping">
	    	<a onclick="toggle_visibility('performance_list_menu')">
	    		<span class="pull-right glyphicon glyphicon-chevron-down"></span>
	    		<h5 class="news_title">PERFORMANCE</h5>
	    	</a>
	    	<ul class="menu_list" id="performance_list_menu">
	            <li>
	            	<a href="<?=base_url()?>portfolio/summary/intracom">
	            		<img style="height:20px;" src="<?php echo icon_url('money transfer - office.png')?>">
        				<span style="margin-left: 5px;">Intrakomtabel</span>
	            	</a>
	            </li>
	            <li>
	            	<a href="<?=base_url()?>portfolio/summary/extracom">
	            		<img style="height:20px;" src="<?php echo icon_url('donate - office.png')?>">
        				<span style="margin-left: 5px;">Ekstrakomtabel</span>
	            	</a>
	            </li>
	            <!-- <li>
	            	<a href="<?=base_url()?>portfolio/summary/fee">
	            		<img style="height:20px;" src="<?php echo icon_url('coins - office.png')?>">
        				<span style="margin-left: 5px;">Fee Based</span>
	            	</a>
	            </li> -->
	            <!-- <li>
	            	<a href="<?=base_url()?>profitability">
	            		<img style="height:20px;" src="<?php echo icon_url('trolley - office.png')?>">
        				<span style="margin-left: 5px;">Profitability</span>
	            	</a>
	            </li> -->
	            <!-- <li>
	            	<a href="<?=base_url()?>biaya/summary">
	            		<img style="height:20px;" src="<?php echo icon_url('money bag - office.png')?>">
        				<span style="margin-left: 5px;">Biaya</span>
	            	</a>
	            </li> -->
	            <li>
	            	<a href="<?=base_url()?>portfolio/summary/restru">
	            		<img style="height:20px;" src="<?php echo icon_url('receipt - office.png')?>">
        				<span style="margin-left: 5px;">Restrukturisasi</span>
	            	</a>
	            </li>
	            <li>
	            	<a href="<?=base_url()?>dsfile">
	            		<img style="height:20px;" src="<?php echo icon_url('ftp - office.png')?>">
        				<span style="margin-left: 5px;">File Library</span>
	            	</a>
	            </li>
	         </ul>
	    </div>
	    <div class="sub_menu_grouping">
	    	<a onclick="toggle_visibility('customer_list_menu')">
	    		<span class="pull-right glyphicon glyphicon-chevron-down"></span>
	    		<h5 class="news_title">CUSTOMER INFO</h5>
	    	</a>
	    	<ul class="menu_list" id="customer_list_menu">
	            <li>
	            	<a href="<?=base_url()?>customer/search">
	            		<img style="height:20px;" src="<?php echo icon_url('people - office.png')?>">
        				<span style="margin-left: 5px;">SAM Customer</span>
	            	<!-- </a> -->
	            </li>
	            <li>
	            	<a href="<?=base_url()?>customer_files">
	            		<img style="height:20px;" src="<?php echo icon_url('manual - office.png')?>">
        				<span style="margin-left: 5px;">CES & CBI</span>
	            	</a>
	            </li>
	            <li>
	            	<a href="<?=base_url()?>samassets">
	            		<img style="height:20px;" src="<?php echo icon_url('report card - office.png')?>">
        				<span style="margin-left: 5px;">SAM Assets</span>
	            	</a>
	            </li>
	            <li>
	            	<a href="<?=base_url()?>ots">
	            		<img style="height:20px;" src="<?php echo icon_url('check book - office.png')?>">
        				<span style="margin-left: 5px;">Laporan OTS</span>
	            	</a>
	            </li>
	            <li>
	            	<!-- <a href="<?=base_url()?>mos"> -->
	            		<img style="height:20px;" src="<?php echo icon_url('flow - office.png')?>">
        				<span style="margin-left: 5px;">EDM CTD - TFD</span>
	            	<!-- </a> -->
	            </li>
	            <!-- <li>
	            	<a href="<?=base_url()?>mcm">
	            		<img style="height:20px;" src="<?php echo icon_url('copy machine - office.png')?>">
        				<span style="margin-left: 5px;">MCM Utilization</span>
	            	</a>
	            </li> -->
	          </ul>
	    </div>
	    <div class="sub_menu_grouping">
	    	<a onclick="toggle_visibility('internal_list_menu')">
	    		<span class="pull-right glyphicon glyphicon-chevron-down"></span>
	    		<h5 class="news_title">INTERNAL INFO</h5>
	    	</a>
	    	<ul class="menu_list" id="internal_list_menu">
	            <li>
	            	<a href="<?=base_url()?>hr">
	            		<img style="height:20px;" src="<?php echo icon_url('podium - office.png')?>">
        				<span style="margin-left: 5px;">Human Resources</span>
	            	</a>
	            </li>
	            <li>
	            	<a href="<?=base_url()?>mysharing/internal">
	            		<img style="height:20px;" src="<?php echo icon_url('collaboration - office.png')?>">
        				<span style="margin-left: 5px;">Internal Sharing</span>
	            	</a>
	            </li>
	            <!-- <li>
	            	<a href="<?=base_url()?>compliance">
	            		<img style="height:20px;" src="<?php echo icon_url('advertising - office.png')?>">
        				<span style="margin-left: 5px;">DCOR Page</span>
	            	</a>
	            </li> -->
	            <li>
	            	<a href="<?=base_url()?>calendar">
	            		<img style="height:20px;" src="<?php echo icon_url('calendar - office.png')?>">
        				<span style="margin-left: 5px;">Calendar of Event</span>
	            	</a>
	            </li>
	            <li>
	            	<a href="<?=base_url()?>product_knowledge">
	            		<img style="height:20px;" src="<?php echo icon_url('courses - office.png')?>">
        				<span style="margin-left: 5px;">Product Knowledge</span>
	            	</a>
	            </li>
	            <li>
	            	<a href="<?=base_url()?>mail">
	            		<img style="height:20px;" src="<?php echo icon_url('register - office.png')?>">
        				<span style="margin-left: 5px;">SAM Documentation</span>
	            	</a>
	            </li>
	        </ul>
	    </div>
	    <div class="sub_menu_grouping">
	    	<a onclick="toggle_visibility('market_list_menu')">
	    		<span class="pull-right glyphicon glyphicon-chevron-down"></span>
	    		<h5 class="news_title">MARKET & INDUSTRY</h5>
	    	</a>
	    	<ul class="menu_list" id="market_list_menu">
	            <li>
	            	<a href="<?=base_url()?>market">
	            		<img style="height:20px;" src="<?php echo icon_url('news - office.png')?>">
        				<span style="margin-left: 5px;">Market Outlook</span>
	            	</a>
	            </li>
	        </ul>
	    </div>
	</div>
</div>

<script type="text/javascript">
	 /* Set the width of the side navigation to 250px and the left margin of the page content to 250px and add a black background color to body */
    function openNav() {
        //document.getElementById("mySidenav").style.width = "100%";
        //document.getElementById("mySidenav").style.max_width = "350px";

        $("#mySidenav").css({
		     "width": "100%", 
		     "max-width": "285px"
		 });
        document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.body.style.backgroundColor = "white";
    }
</script>