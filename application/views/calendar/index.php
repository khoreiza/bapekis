<?php 
	$user = $this->session->userdata('userbapekis');
?>
<div id="" class="container_broventh container_broventh_small">
    <div class="row" style="">
    	<div class="col-md-9 column" style="padding-right: 20px;">
    		<div>
                <h2 class="page_title">Calendar of Event</h2>
                <p class="broventh_page_description">
                </p>
            </div>
            <div class="broventh_submenu_div" style="margin-top: 0px;">
                <div class="broventh_submenu_title no_border">
                    <div class="row">
                        <div class="col-md-7">
                            <a onclick="show_calendar_form('');" class="btn btn-broventh btn-circle btn-first" style="margin-right: 10px;">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                            <span class="date_title">This Month</span> Events
                        </div>
                        <div class="col-md-5 right_text">
                            <div class="input-group" style="width: 100%;">
                                <input class="form-control-minimalist with_addon search_date" value="" id="event_search" onchange="get_event('date')" placeholder="Search Event">
                                <div class="input-group-addon addon-minimalist"><span class="glyphicon glyphicon-search"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="broventh_submenu_body">
                    <div class="row">
                        <div class="col-md-7 column" id="events_list_div"></div>
                        <div class="col-md-5 column" style="padding-left: 20px;">
                            <div id="calendar_month_div"></div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    	<div class="col-md-3 column" style="margin-top: 30px; padding-left: 20px;">
            <?=$latest_event?>
    	</div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/calendar.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        get_month_calendar();
    });


</script>