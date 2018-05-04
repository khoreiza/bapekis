<?php
$user = $this->session->userdata('userdbcisam'); $user_disp="";
?>
<style type="text/css">
	/*CSS for new CBIC sub menu*/


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
	    border-bottom: 2px solid <?=array_color_new(2)?>;
	    border-radius: 0px;
	    cursor: default;
	    background-color: transparent;
	}

	.header_menu_group li.active a{
		color: <?=array_color_new(2)?>;
	}

	#user_menu_dropdown{
	  	margin-top: -40px;
	}

</style>

<div class="header_menu_group submenu_not_show" style="font-size: 12px; padding-top: 10px; width:100%; position: relative; z-index: 1002">
	<ul class="cbic_submenu list_menu_group" style="padding-left: 0px;">
        <li class="active underline-animation"><a class="" href="<?=base_url()?>">WHAT'S ON</a></li>
        <li class="cbic-sudropdown underline-animation">
        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">OPERATING TOOLS</a>
        	<ul class="dropdown-menu">
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
        </li>
        <li class="dropdown underline-animation">
        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PERFORMANCE INFO</a>
        	<ul class="dropdown-menu">
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
        </li>
        <li class="dropdown underline-animation">
        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">CUSTOMER INFO</a>
        	<ul class="dropdown-menu">
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
        </li>
        <li class="dropdown underline-animation">
        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">INTERNAL INFO</a>
        	<ul class="dropdown-menu">
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
        </li>
        <li class="dropdown underline-animation">
        	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">MARKET INDUSTRY</a>
        	<ul class="dropdown-menu">
	            <li>
	            	<a href="<?=base_url()?>market">
	            		<img style="height:20px;" src="<?php echo icon_url('news - office.png')?>">
        				<span style="margin-left: 5px;">Market Outlook</span>
	            	</a>
	            </li>
	        </ul>
        </li>
    </ul>
</div>
