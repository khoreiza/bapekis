function show_detail_customer(group){
		if($('#detail_pipeline_customer').css('display') == 'none'){
			toggle_visibility('detail_pipeline_customer');
		}
		$('.group-filter-elmt').html('Corporate Banking '+group);
	}

function get_summary_pipeline(v_cbgroup, v_product, v_valuta, v_id_div_summary, v_id_div_summary_highlight, v_id_div_detail, v_id_div_detail_highlight, v_id_table_rincian, v_id_customer_highlight){
	var result=[];
	var detail_type="cbgroup";
	if(v_cbgroup=="all"){
		detail_type="cbgroup";
	}else{
		detail_type="cbdept";
	}
	$.getJSON(
		config.base+"api_fund/query_pipeline_projection",
		{
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta
		},
		function(data,status,xhr){
			if(status=="success"){
				//console.log("success"+v_id_div_summary+v_id_div_summary_highlight);
				draw_pipeline_graph(data, v_id_div_summary, v_id_div_summary_highlight);
				draw_table_rincian(detail_type, data, v_id_table_rincian);	
				//draw_customer_realization_graph(data.targets, v_date, v_cbgroup, v_product, v_valuta, v_id_customer, v_id_customer_highlight);			
	 		}else{
	 			console.log(status);
	 		}
		}
	);
}

function draw_pipeline_graph(v_data, v_id_div, v_id_div_highlight){
	// data_provider = [
	// 	{
	// 		"year": "Sep 2015",
	// 		"income": 23.5,
	// 		"expenses": 18.1
	// 	}
	// ];
	var data_provider=[];
	var total_target=0;
	var total_realization=0;
	var date = null;
	var newDate = "";
	var percentage=0;

	// Get Target
	$.each( v_data.targets, function( key, val ) {
		date = new Date(val.date);
		date_target = date.toString('MMM yy');
		total_target = parseFloat(total_target) + parseFloat(val.target);
	});

	// Get Realization
	$.each( v_data.realizations, function( key, val ) {
		date = new Date(val.date);
		date_realz = date.toString('MMM yy');
		total_realization = parseFloat(total_realization) + parseFloat(val.realization);
	});
	var pipe_per = 1; var date_pipe = []; var real_pipe = []; var last_pipe = parseFloat(total_realization); var gap_pipe = []; var open_pipe = []; var color_pipe = [];
	$.each( v_data.pipeline, function( key, each_pp ) {
		var tot_pipe_part = 0;
		$.each( each_pp, function( key, val ) {
			date = new Date(val.pipeline_date);
			//date_pipe[pipe_per] = date.toString('MMM yy');
			//real_pipe[pipe_per] = parseFloat(real_pipe[pipe_per]) + parseFloat(val.amount);
			tot_pipe_part = tot_pipe_part + parseFloat(val.amount)*1000000;
		});
		open_pipe[pipe_per] = last_pipe;
		gap_pipe[pipe_per] = tot_pipe_part;
		real_pipe[pipe_per] = last_pipe+tot_pipe_part;
		if(tot_pipe_part<0){
			color_pipe[pipe_per] = fund_negative_color;
		}else{color_pipe[pipe_per] = fund_color;}
		last_pipe = real_pipe[pipe_per];
		pipe_per=pipe_per+1;
	});

	// Draw Highlight
	percentage = parseFloat(last_pipe*100 / total_target).toFixed(get_bhd_comma(last_pipe*100 / total_target));
	$("#"+v_id_div_highlight).html(percentage+"%");

	var chart = AmCharts.makeChart("chartdiv_pipeline", {
		"fontFamily": 'Myriad Pro Light',
	  	  "fontSize": fontsize,
		"type": "serial",
		"theme": "light",
		  "dataProvider": [ {
			"name": date_realz,
			"open": 0,
			"close": total_realization,
			"show_val": get_show_number(total_realization).toFixed(get_bhd_comma_val(get_show_number(total_realization))),
			"satuan": get_show_number_satuan(total_realization),
			"color": fund_color,
		  }, {
			"name": "Mgu 1",
			"open": open_pipe[1],
			"close": real_pipe[1],
			"show_val": get_show_number(gap_pipe[1]).toFixed(get_bhd_comma_val(get_show_number(gap_pipe[1]))),
			"satuan": get_show_number_satuan(gap_pipe[1]),
			"color": color_pipe[1],
		  }, {
			"name": "Mgu 2",
			"open": open_pipe[2],
			"close": real_pipe[2],
			"show_val": get_show_number(gap_pipe[2]).toFixed(get_bhd_comma_val(get_show_number(gap_pipe[2]))),
			"satuan": get_show_number_satuan(gap_pipe[2]),
			"color": color_pipe[2],
		  }, {
			"name": "Mgu 3",
			"open": open_pipe[3],
			"close": real_pipe[3],
			"show_val": get_show_number(gap_pipe[3]).toFixed(get_bhd_comma_val(get_show_number(gap_pipe[3]))),
			"satuan": get_show_number_satuan(gap_pipe[3]),
			"color": color_pipe[3],
		  }, {
			"name": "Mgu 4",
			"open": open_pipe[4],
			"close": real_pipe[4],
			"show_val": get_show_number(gap_pipe[4]).toFixed(get_bhd_comma_val(get_show_number(gap_pipe[4]))),
			"satuan": get_show_number_satuan(gap_pipe[4]),
			"color": color_pipe[4],
		  }, {
			"name": "Target<br>"+date_target,
			"open": 0,
			"close": total_target,
			"show_val": get_show_number(total_target).toFixed(get_bhd_comma_val(get_show_number(total_target))),
			"satuan": get_show_number_satuan(total_target),
			"color": target_color,
		  } ],
		  "valueAxes": [ {
			"axisAlpha": 0,
			"gridAlpha": 0,
			"position": "left",
			"labelsEnabled":false,
		  } ],
		  "startDuration": 1,
		  "graphs": [ {
			"balloonText": "<span style='color:[[color]]'>[[category]]</span><br><b>[[show_val]] [[satuan]]</b>",
			"colorField": "color",
			"fillAlphas": 0.8,
			"labelText": "[[show_val]] [[satuan]]",
			"lineColor": "#ffffff",
			"openField": "open",
			"type": "column",
			"valueField": "close"
		  } ],
	 
		  "columnWidth": 0.6,
		  "categoryField": "name",
		  "categoryAxis": {
			"gridPosition": "start",
			"axisAlpha": 1,
			"gridAlpha": 0,
		  },
		  "export": {
			"enabled": true
		  }
	});
}
	
function draw_table_rincian(v_detail_type, v_data, v_id_table_rincian){
   	/**
	*	input 
	*   -	v_data_target :
	*	- 	v_date 	  : date  
	*	-	v_product : GIRO, DEPO, ALL
	*	-	V_valuta  : RP, VA, ALL
	*	-	v_cbgroup_id : 1 - 7, ALL
	*	-	v_sort    : DESC, ASC (DESC: highest growth, ASC: lowest growth)
	*	-	v_limit   : 20, 10, x (integer)
	*	-	v_id_div  : id div html
	*	process : get the highest and lowest growth
	*	output : group by customer_group, order by percentage, and filter by product, valuta
	*/
	var items=[]; var tot_tgt=0; var tot_rlz=0; var tot_pipe_one=0; var tot_pipe_two=0; var tot_pipe_three=0; var tot_pipe_four=0;
	var tot_all_per = 0;
	$.each( v_data.targets, function( key, valTarget ) {
		date = new Date(valTarget.target_date);
		newDate = date.toString('MMM yyyy');
		var target = parseFloat(valTarget.target); 
		var realization = 0;
		var percentage=0;
		var tol_all_cb=0;
		// Get Realization
		$.each( v_data.realizations, function( key, valReal ) {
			if(v_detail_type=="cbgroup"){
				if( valTarget.cbgroup == valReal.cbgroup ){
					realization = parseFloat(valReal.realization);
					org = valReal.cbgroup;
					tot_rlz = tot_rlz+realization;
				}
			}else if(v_detail_type=="cbdept"){
				if( valTarget.cbdept == valReal.cbdept ){
					realization = parseFloat(valReal.realization);
					org = valReal.cbdept;
					tot_rlz = tot_rlz+realization;
				}
			} 
		});
		var gap_pipe_one = 0;
		$.each( v_data.pipeline_one, function( key, pipeone ) {
			if(v_detail_type=="cbgroup"){
				if( valTarget.cbgroup == pipeone.cbgroup ){
					gap_pipe_one = parseFloat(pipeone.amount)*1000000;
					tot_pipe_one = tot_pipe_one+gap_pipe_one;
				}
			}else if(v_detail_type=="cbdept"){
				if( valTarget.cbdept == pipeone.cbdept ){
					gap_pipe_one = parseFloat(pipeone.amount)*1000000;
					tot_pipe_one = tot_pipe_one+gap_pipe_one;
				}
			} 
		});
		var gap_pipe_two = 0;
		$.each( v_data.pipeline_two, function( key, pipetwo ) {
			if(v_detail_type=="cbgroup"){
				if( valTarget.cbgroup == pipetwo.cbgroup ){
					gap_pipe_two = parseFloat(pipetwo.amount)*1000000;
					tot_pipe_two = tot_pipe_two+gap_pipe_two;
				}
			}else if(v_detail_type=="cbdept"){
				if( valTarget.cbdept == pipetwo.cbdept ){
					gap_pipe_two = parseFloat(pipetwo.amount)*1000000;
					tot_pipe_two = tot_pipe_two+gap_pipe_two;
				}
			} 
		});
		var gap_pipe_three = 0;
		$.each( v_data.pipeline_three, function( key, pipethree ) {
			if(v_detail_type=="cbgroup"){
				if( valTarget.cbgroup == pipethree.cbgroup ){
					gap_pipe_three = parseFloat(pipethree.amount)*1000000;
					tot_pipe_three = tot_pipe_three+gap_pipe_three;
				}
			}else if(v_detail_type=="cbdept"){
				if( valTarget.cbdept == pipethree.cbdept ){
					gap_pipe_three = parseFloat(pipethree.amount)*1000000;
					tot_pipe_three = tot_pipe_three+gap_pipe_three;
				}
			} 
		});
		var gap_pipe_four = 0;
		$.each( v_data.pipeline_four, function( key, pipefour ) {
			if(v_detail_type=="cbgroup"){
				if( valTarget.cbgroup == pipefour.cbgroup ){
					gap_pipe_four = parseFloat(pipefour.amount)*1000000;
					tot_pipe_four = tot_pipe_four+gap_pipe_four;
				}
			}else if(v_detail_type=="cbdept"){
				if( valTarget.cbdept == pipefour.cbdept ){
					gap_pipe_four = parseFloat(pipefour.amount)*1000000;
					tot_pipe_four = tot_pipe_four+gap_pipe_four;
				}
			} 
		});
		tol_all_cb = realization+gap_pipe_one+gap_pipe_two+gap_pipe_three+gap_pipe_four;
		tot_all_per = tot_all_per+tol_all_cb;
		tot_tgt = tot_tgt+target;
		/*percentage=parseFloat(realization*100/target).toFixed(0);
		if(percentage>=100){
			color=fund_color;
		}else{
			color=fund_negative_color;
		}*/
		//var pct = parseFloat(val.realization*100 / total_target).toFixed(2);
		//total_percentage=parseFloat(total_percentage)+parseFloat(pct);
		items.push("<tr>"+
		"<td style='text-align:left'>"+org+"</td>"+
		"<td>"+get_show_number(realization).toFixed(get_bhd_comma_val(get_show_number(realization)))+" "+get_show_number_satuan(realization)+"</td>"+
		"<td>"+get_show_number(gap_pipe_one).toFixed(get_bhd_comma_val(get_show_number(gap_pipe_one)))+" "+get_show_number_satuan(gap_pipe_one)+"</td>"+
		"<td>"+get_show_number(gap_pipe_two).toFixed(get_bhd_comma_val(get_show_number(gap_pipe_one)))+" "+get_show_number_satuan(gap_pipe_two)+"</td>"+
		"<td>"+get_show_number(gap_pipe_three).toFixed(get_bhd_comma_val(get_show_number(gap_pipe_one)))+" "+get_show_number_satuan(gap_pipe_three)+"</td>"+
		"<td>"+get_show_number(gap_pipe_four).toFixed(get_bhd_comma_val(get_show_number(gap_pipe_one)))+" "+get_show_number_satuan(gap_pipe_four)+"</td>"+
		"<td>"+get_show_number(tol_all_cb).toFixed(get_bhd_comma_val(get_show_number(tol_all_cb)))+" "+get_show_number_satuan(tol_all_cb)+"</td>"+
		"<td>"+get_show_number(target).toFixed(get_bhd_comma_val(get_show_number(target)))+" "+get_show_number_satuan(target)+"</td>"+
		"<td>"+(tol_all_cb/target*100).toFixed(get_bhd_comma(tol_all_cb/target*100))+"%</td>");
		$('#'+v_id_table_rincian).html(items);
	});
	items.push("<tr style='font-weight:bold;'>"+
	"<td>Total</td>"+
	"<td>"+get_show_number(tot_rlz).toFixed(get_bhd_comma_val(get_show_number(tot_rlz)))+" "+get_show_number_satuan(tot_rlz)+"</td>"+
	"<td>"+get_show_number(tot_pipe_one).toFixed(get_bhd_comma_val(get_show_number(tot_pipe_one)))+" "+get_show_number_satuan(tot_pipe_one)+"</td>"+
	"<td>"+get_show_number(tot_pipe_two).toFixed(get_bhd_comma_val(get_show_number(tot_pipe_two)))+" "+get_show_number_satuan(tot_pipe_two)+"</td>"+
	"<td>"+get_show_number(tot_pipe_three).toFixed(get_bhd_comma_val(get_show_number(tot_pipe_three)))+" "+get_show_number_satuan(tot_pipe_three)+"</td>"+
	"<td>"+get_show_number(tot_pipe_four).toFixed(get_bhd_comma_val(get_show_number(tot_pipe_four)))+" "+get_show_number_satuan(tot_pipe_four)+"</td>"+
	"<td>"+get_show_number(tot_all_per).toFixed(get_bhd_comma_val(get_show_number(tot_all_per)))+" "+get_show_number_satuan(tot_all_per)+"</td>"+
	"<td>"+get_show_number(tot_tgt).toFixed(get_bhd_comma_val(get_show_number(tot_tgt)))+" "+get_show_number_satuan(tot_tgt)+"</td>"+
	"<td>"+(tot_all_per/tot_tgt*100).toFixed(get_bhd_comma(tot_all_per/tot_tgt*100))+"%</td>");
	$('#'+v_id_table_rincian).html(items);
}

function get_top_pipeline_fund(gv_cbgroup, gv_product, gv_valuta, gv_type){
	$.getJSON(
		config.base+"api_fund/get_top_pipeline_fund",
		{
			cbgroup: gv_cbgroup,
			product: gv_product,
			valuta: gv_valuta,
			type: gv_type
		},
		function(data,status,xhr){
			var items=[];
			if(status=="success"){
				$.each( data.results, function( key, val ) {
					var amount = addCommas((val.total_amount/1).toFixed(0));
					items.push("<tr>"+
	    			"<td style='text-align:left;'>"+val.customer+"</td>"+
	    			"<td style='text-align:center'>"+val.buc+"</td>"+
	    			"<td style='text-align:center'>"+val.valuta+"</td>"+
	    			"<td style='text-align:center'>"+val.product+"</td>"+
	    			"<td style='text-align:center'>"+amount+"</td>"+
	    			"<td style='text-align:center'>"+val.period+"</td></tr>");
	  			});
	  			$("#top_pipeline_fund").html(items);
	 		}else{
	  			$("#top_pipeline_fund").html("data could not be loaded");
	 		}
		}
	);
}


function load_fund_pipeline_summary(gv_cbgroup, gv_product, gv_valuta, gv_type){	
	get_summary_pipeline(gv_cbgroup, gv_product, gv_valuta, 
		"chartdiv_pipeline", "total_projection_highlight",
		"detail_realization_graph", "detail_realization_highlight",
		"group_pipeline_detail","customer_realization_highlight");
	get_top_pipeline_fund(gv_cbgroup, gv_product, gv_valuta, gv_type);
	change_element_filter(gv_cbgroup, gv_product, gv_valuta);
}

function load_fund_summary(gv_cbgroup, gv_product, gv_valuta, gv_type){
	load_fund_pipeline_summary(gv_cbgroup, gv_product, gv_valuta, gv_type);
}