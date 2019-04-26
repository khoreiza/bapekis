<?php $user = $this->session->userdata('userbapekis');?>


<div class="row">
	<div class="col-md-9">
		
	</div>
	<div class="col-md-2">
		<div>
			<a onclick="show_calendar_form('','mosque',<?=$mosque->mosque_id?>)" class="btn btn-broventh btn-white show_header_option">
                <span class="glyphicon glyphicon-calendar"></span> Add Kalender Ramadhan
            </a>
            <a onclick="show_sharing_form('',<?=$mosque->mosque_id?>);" class="btn btn-broventh btn-white show_header_option">
                <span class="glyphicon glyphicon-calendar"></span> Add Menu Takjil
            </a>
            <a onclick="show_sharing_form('',<?=$mosque->mosque_id?>);" class="btn btn-broventh btn-white show_header_option">
                <span class="glyphicon glyphicon-calendar"></span> Add Ceramah Rabu
            </a>
            <a onclick="show_sharing_form('',<?=$mosque->mosque_id?>);" class="btn btn-broventh btn-white show_header_option">
                <span class="glyphicon glyphicon-calendar"></span> Add Jadwal Taraweh
            </a>
		</div>
	</div>
</div>