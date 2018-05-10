<style>
	.event_cal button{
		padding:0px;
		width:100%;
		font-size:11px;
		border:0;
		background-color:transparent;
	}
	.event_cal button:hover{
		color:#189cb8;
	}
</style>
<?php
	$sumdate = date("t", mktime(0,0,0, $month, 1, $year));
	$day = date("N", mktime(0,0,0, $month, 1, $year)); $firstday = true;
	$tmonth = date("m");
	$tday = date("d");
	
	$firstday_diw = $day; 
	$tday_diw = ($tday%7)+$firstday_diw-1;
	if($tday_diw>7){$tday_diw=$tday_diw-7;}
?>
<div class="square_box" style="margin-top: 40px;">
	<div class="square_box_body" id="content_calender" style="margin-top:-20px;">
		<div style="margin: 30px 0 20px 0;">
			<h3 class="center_text news_title">
				<?php 
					$prev_month = $month-1; $prev_year = $year;
					$next_month = $month+1;	$next_year = $year;

					if($prev_month == 0){
						$prev_month = 12; $prev_year --;
					}
					if($next_month == 13){
						$next_month = 1; $next_year ++;
					}
				?>
				<a onclick="get_month_calendar(<?=$prev_month?>,<?=$prev_year?>)" style="font-size: 16px;">
					<span class="glyphicon glyphicon-menu-left"></span>
				</a>

				<a onclick="get_event('','<?=$year."-".$month?>')" style="margin:0 20px 0 20px;">
					<?php echo date("F Y", mktime(0,0,0, $month, 1, $year))." "?>
				</a>

				<a onclick="get_month_calendar(<?=$next_month?>,<?=$next_year?>)" style="font-size: 16px;">
					<span class="glyphicon glyphicon-menu-right"></span>
				</a>
			</h3>
		</div>
		<div style="margin-top:10px;">
			<div id="calendartable" style="width:99%; margin:0 auto;">
				<div style="text-align:right">
					<div>
						<div class="as ">M</div>
						<div class="as ">T</div>
						<div class="as ">W</div>
						<div class="as ">T</div>
						<div class="as ">F</div>
						<div class="as " style="color:#c3c3c3">S</div>
						<div class="as " style="color:#c3c3c3">S</div>
						<div style="clear:both"></div>
					</div>
					<?php 
						$i=1; 
						while($i<=$sumdate){
							echo "<div style=\"min-height:62px;\">";
							for($diw=1;$diw<=7;$diw++){
								if($i<=$sumdate){
									if($firstday && ($day != $diw)){?>
										<div class="as"></div>
									<?php }else{?>
										<div class="as" style="border-top:solid 
											<?php 
											if($tmonth == $month){
												if($i==$tday){echo "3px ".array_color_new(6); }
												elseif((($tday - $i +$diw)==$tday_diw)){echo "3px ".array_color_new(3);}
												else{echo "1px #e2e2e2;";}
											}
											else{echo "1px #e2e2e2;";}?>">
											<div>
												<div style="text-align: center; top:2px;">
													<a onclick="get_event('<?=$year."-".$month."-".$i?>','')">
														<span style="<?php if($month==$tmonth && $i==$tday){echo "color: ".array_color_new(6)."; font-size: 18px;";}elseif($diw>5){echo "color:#c3c3c3;";}?>"><?php echo $i?></span>
													</a>
												</div>
												<div style="clear:both"></div>
											</div>
											<div id="calendarisi">
												<div>
													<?php if(in_array($i, $arr_event_date)){?>
														<div style="height: 8px; width: 8px; border-radius: 10px; background-color: <?=array_color_new(9)?>; margin:0 auto; margin-top: 5px;">
														</div>
													<?php }?>
												</div>
												<div style="clear:both"></div>
											</div>
										</div>
										<?php 
										$i++; 
										if($firstday){
											$firstday=false;
										}
									}
								}
							}
							echo "<div style='clear:both'></div></div>";
					}?>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	#calendartable th{
		text-align:center;
		width:14%;
	}
	#calendarisi{
		font-size:11px;
	}
	.as{
		float:left;
		width:14.2857%;
		padding:5px;
	}
	.headeras{
		text-align:center;
		font-weight:bold;
	}
</style>