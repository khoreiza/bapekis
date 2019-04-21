<style type="text/css">
    .kpi_sign{
        float:left;
        margin-right: 20px;
        font-size: 12px;
    }
    .kpi_sign .legend_box{
        float: left;
        margin-right: 5px;
        margin-top: 2px;
    }
    .table_small_content .form-control{
        font-size: 12px !important;
    }
    .income_cf{
		color: #5889cb !important;
	}
	.outcome_cf{
		color: #cb5858 !important;
	}
</style>
<?php 
    $user = $this->session->userdata('userbapekis');
?>

<div>
    <div class="row">
        <div class="col-md-4">
        	<div class="menu_section_title" style="text-align: left">
				<div>SUMMARY FINANCIAL</div>
			</div>
        	<div class="broventh_card">
        		<div id="chartdiv_realization" style="width: 100%; max-width: 300px; height: 238px; margin:0 auto;"></div>
        		<div class="center_text">
	            	<div>
                        <div class="" style="border-top:1px dashed #e2e2e2; padding: 20px;">
                            <h4>You have</h4>
                            <h2 style="margin:10px 0 10px 0;" class="news_title">Rp <?=currency_format($summary->sum_income-$summary->sum_outcome)?></h2>
                            <h4>as your Mosque Cashflow</h4>
                        </div>
                    </div>
                    <p style="margin-top: 0px;">Your Incoming Cashflow <label class="theme_color">Rp <?=currency_format($summary->sum_income)?></label> and your Outgoing Cashflow <label class="theme_color">Rp <?=currency_format($summary->sum_outcome)?></label></p>
	            </div>
        	</div>
            
        </div>
        <div class="col-md-8">
        	<div class="menu_section_title" style="text-align: left">
				<div>DETAIL FINANCIAL</div>
			</div>
        	<div>
        		<div class="broventh_card">
		            <div id="chartdiv_growth" style="width: 100%; height: 238px; margin:0 auto;"></div>
		        </div>
        	</div>
        	<div class="row">
	        	<div class="col-md-12">
	        		<div class="broventh_card">
	        			<table class="table table-striped" id="table_incoming">
							<thead>
								<tr>
									<th>#</th>
									<th>Item</th>
									<th>Type</th>
									<th>Date</th>
									<th>Amount</th>
									<th width="40px;"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($cashflows as $i => $row){?>
									<tr class="<?=($row->type=='Outcome') ? 'outcome_cf' : 'income_cf'?>">
										<td><?= $i+1;?></td>
										<td>
                                            <div><?= long_text($row->purpose, 20);?></div>
                                            <div class="helper_text" style="margin-top: 5px; font-size: 12px;"><?=$row->description?></div>
                                        </td>
										<td><?=$row->type?></td>
										<td class="right_text" title="<?= $row->date;?>"><?= date("j M y", strtotime($row->date));?></td>
										<td class="right_text" title="<?= number_format($row->amount);?>"><?= currency_format($row->amount)?></td>
										<td style="width: 40px; font-size: 10px;">
				                            <a class="edit_color" onclick="show_financial_form('<?=$row->id?>',<?=$row->mosque_id?>)">
				                                <span class="glyphicon glyphicon-pencil"></span>
				                            </a>
				                            <a class="delete_color" onclick="">
				                                <span class="glyphicon glyphicon-trash"></span>
				                            </a>
				                        </td>
									</tr>
									
								<?php }?>
							</tbody>
						</table>
	        		</div>
	        	</div>
		    </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {         
        
        $('#table_incoming').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                //'excelHtml5',
            ],
            pagingType:'simple',
        } );

        //draw_principal_gauge();
        draw_realization_pipeline();
        draw_growth();
    });


    
    function draw_realization_pipeline(){
        <?php if(isset($summary) && $summary->sum_income){?>
	        var chart = AmCharts.makeChart( "chartdiv_realization", {
	          "fontFamily": 'Myriad Pro Light',
	          "fontSize": 14,
	          "type": "serial",
	            "dataProvider": [
	                {
	                    "category": "Income",
	                    "title": "Income",
	                    "value": <?=$summary->sum_income?>,
	                    "capai": "",
	                    "color": "<?= array_color_new(2);?>",
	                    "disp": "<?=currency_format($summary->sum_income)?>",
	                    "real": "<?=number_format($summary->sum_income)?>",
	                },
	                {
	                    "category": "Outcome",
	                    "title": "Outcome",
	                    "value": <?=$summary->sum_outcome?>,
	                    "capai": "",
	                    "color": "<?= array_color_new(8);?>",
	                    "disp": "<?=currency_format($summary->sum_outcome)?>",
	                    "real": "<?=number_format($summary->sum_outcome)?>",
	                }
	            ],
	            "valueAxes": [{
	                "axisAlpha": 0,
	                "gridAlpha": 0,
	                "minimum": 0,
	                "labelsEnabled":false,
	            }],
	            "startDuration": 1,
	            "startEffect":"bounce",
	            "graphs": [{
	                "balloonText": "<b>[[title]]:</b><br>[[real]]<br>[[capai]]",
	                "fillAlphas": 1,
	                "labelText": "[[disp]]",
	                "colorField": "color",
	                "lineAlpha": 0.3,
	                "type": "column",
	                "lineColor": "#fafafa",
	                "valueField": "value"
	            }],
	            "categoryField": "category",
	            "categoryAxis": {
	                "gridPosition": "start",
	                "axisAlpha": 0.3,
	                "gridAlpha": 0,
	                "position": "left"
	            },
	            "export": {
	                "enabled": true
	             }

	        });
    	<?php } ?>
    }




    function draw_growth(){
        var chart = AmCharts.makeChart(chartdiv_growth, {
          "fontFamily": 'Myriad Pro Light',
          type: "serial",
          "fontSize": 14,
          dataDateFormat: "YYYY-MM-DD",
          "dataProvider": [
                <?php if($growth){$prev=0; foreach($growth as $row){ $thismonth = $prev+$row->sum_amount;?>
                    {
                    "date": "<?= date("j M", strtotime($row->date))?>",
                    "amount": <?= $thismonth?>,
                    "amount_disp": "<?= currency_format($thismonth);?>",
                    "amount_full": "<?= number_format($thismonth);?>",
                    },
                <?php $prev = $thismonth;}}?>
            ],
          addClassNames: true,
          startthis_year: 0,
          color: "black",
          marginLeft: 0,
          categoryField:"date",
          categoryAxis: {
                gridAlpha: 0
            },
          valueAxes: [{
            gridAlpha: 0,
            axisAlpha: 0,
            labelsEnabled: false,
            "minimum":0,
          }],
          graphs: [
            {
            valueField: "amount",
            classNameField: "bulletClass",
            type: "line",
            lineColor: "<?=array_color_new(2)?>",
            balloonText: "[[category]]: <br><b>[[amount_full]]</b>",
            lineThickness: 2,
            fillColorsField: "<?=array_color_new(3)?>",
            fillAlphas: 0.8,
            bullet: "round",
            labelText: "[[amount_disp]]",
            bulletBorderColor: "<?=array_color_new(2)?>",
            bulletBorderThickness: 2,
            bulletBorderAlpha: 1,
            dashLengthField: "dashLength",
            
          }
          ],

          chartCursor: {
            zoomable: false,
            categoryBalloonDateFormat: "DD",
            cursorAlpha: 0,
            valueBalloonsEnabled: false
          },
          "export": {
              "enabled": true
            }
        });
    }
</script>