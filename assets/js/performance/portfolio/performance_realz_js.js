function get_summary_realization_vs_target(v_cbgroup, v_product, v_valuta, v_id_div_summary, v_id_div_summary_highlight, v_id_div_detail, v_id_div_detail_highlight, modul, page){
	var result=[];
	var detail_type="cbgroup";
	if(v_cbgroup=="all"){
		detail_type="cbgroup";
	}else{
		detail_type="cbdept";
	}
	$.getJSON(
		config.base+"api_performance/query_realization_vs_target",
		{
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta,
			dept: gv_dept,
			modul:modul
		},
		function(data,status,xhr){
			if(status=="success"){
				//console.log("success"+v_id_div_summary+v_id_div_summary_highlight);
				draw_summary_graph(data, v_id_div_summary, v_id_div_summary_highlight);
				if(v_cbgroup == "all" ){
					draw_detail_graph(detail_type, data, v_id_div_detail, v_id_div_detail_highlight, page);	
				}		
	 		}else{
	 			console.log(status);
	 		}
		}
	);
}

function draw_summary_graph(v_data, v_id_div, v_id_div_highlight){
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
		total_target = parseFloat(total_target) + parseFloat(val.target);
	});

	// Get Realization
	$.each( v_data.realizations, function( key, val ) {
		date = new Date(val.date);
		newDate = date.toString('MMM yyyy');
		total_realization = parseFloat(total_realization) + parseFloat(val.realization);
	});
	//Font Size
	
	if(total_target == 0){
		total_target = total_realization;
	}
	
	// Draw Highlight
	percentage = addCommas(parseFloat(total_realization*100 / total_target).toFixed(get_bhd_comma(total_realization*100 / total_target)));
	$("#"+v_id_div_highlight).html(percentage+"%");

	
	// Draw graph
	data_provider.push({
	    date: newDate, 
	    target: total_target,
	    realization: total_realization,
	    target_show: get_show_number(total_target).toFixed(get_bhd_comma_val(get_show_number(total_target))), 
	    realization_show: get_show_number(total_realization).toFixed(get_bhd_comma_val(get_show_number(total_realization))),
	    satuan_real: get_show_number_satuan(total_realization),
	    satuan_tgt: get_show_number_satuan(total_target),
		target_jt: addCommas((total_target/1000000).toFixed(0)),
		realization_jt: addCommas((total_realization/1000000).toFixed(0)),
	});
	var chart = AmCharts.makeChart(v_id_div, {
		"fontFamily": 'Myriad Pro Light',
	    "fontSize": fontsize,
		"type": "serial",
		"legend": {
				"horizontalGap": 0,
				"maxColumns": 2,
				"position": "top",
				"useGraphSettings": true,
				"markerSize": 10,
				"align":"center",
				"markerType": "circle",
				"textClickEnabled": true,
			},
	     "theme": "light",
		"categoryField": "date",
		"rotate": true,
		"startDuration": 1,
		"categoryAxis": {
			"gridPosition": "start",
			"position": "left",
			"gridAlpha": 0,
		},
		"trendLines": [],
		"graphs": [
			{
				"balloonText": "Realisasi: [[realization_jt]]",
				"fillAlphas": 0.8,
				"lineColor": fund_color,
				"labelText": "[[realization_show]] [[satuan_real]]",
				"fontSize": fontsize,
				"id": "AmGraph-1",
				"lineAlpha": 0.2,
				"title": "Realization",
				"type": "column",
				"valueField": "realization"
			},
			{
				"balloonText": "Target: [[target_jt]]",
				"fillAlphas": 0.8,
				"lineColor": target_color,
				"labelText": "[[target_show]] [[satuan_tgt]]",
				"fontSize": fontsize,
				"id": "AmGraph-2",
				"lineAlpha": 0.2,
				"title": "Target",
				"type": "column",
				"valueField": "target"
			}
		],
		"guides": [],
		"valueAxes": [
			{
				"id": "ValueAxis-1",
				"position": "top",
				"axisAlpha": 0,
				"gridAlpha": 0,
				"labelsEnabled":false,
				"minMaxMultiplier":1,
				"minimum":0,
				
			}
		],
		"allLabels": [],
		"balloon": {},
		"titles": [],
		"dataProvider": data_provider,
	    "export": {
	    	"enabled": true
	     }

	});
}

function draw_detail_graph(v_detail_type, v_data, v_id_div, v_id_div_highlight, page){
	var data_provider=[];
	var date = null;
	var newDate = "";
	var cbachieve = 0;
	var cbtotal = v_data.targets.length;
	var highestreal = 0;
	var highestcb = "";


	// Get Target
	
	$.each( v_data.targets, function( key, valTarget ) {
		date = new Date(valTarget.target_date);
		newDate = date.toString('MMM yyyy');
		var target = parseFloat(valTarget.target); 
		var realization = 0;
		var organization = "";
		var color="";
		var percentage=0;

		// Get Realization
		$.each( v_data.realizations, function( key, valReal ) {
			if(v_detail_type=="cbgroup"){
				if( valTarget.cbgroup == valReal.cbgroup ){
					realization = parseFloat(realization) + parseFloat(valReal.realization);
					//realization = parseFloat(valReal.realization);
					if(page=="summary"){
						organization = "CB"+valTarget.cbgroup.split(" ")[2];
					}else{
						organization = "Corp. Banking"+valTarget.cbgroup.split(" ")[2];
					}
				}
			}else if(v_detail_type=="cbdept"){
				if( valTarget.cbdept == valReal.cbdept ){
					realization = parseFloat(valReal.realization);
					if(page=="summary"){
						organization = valReal.buc;
					}else{
						organization = ucwords_js(valTarget.cbdept);//valTarget.cbdept;
					}
				}
			}
		});
		// Get Highest Realization
		if(target == 0){
			target = realization*100;
		}
		percentage=parseFloat(realization*100/target).toFixed(0);
		if(percentage>=100){
			color=fund_color;
			cbachieve=cbachieve+1;
		}else{
			color=fund_negative_color;
		}
		if(highestreal <= (realization*100/target) ){
			highestreal = percentage;
			highestcb = organization;
		}
		
		data_provider.push({
		    organization: organization, 
		    target: target,
		    realization: realization,
		    percentage: percentage,
		    color:color,
			target_show: addCommas((target/1000000).toFixed(0)),
			realization_show: addCommas((realization/1000000).toFixed(0)),
		});
		//console.log("--------");
	});

	// Draw Highlight
	if(v_detail_type=="cbgroup"){
		$("#"+v_id_div_highlight).html(cbachieve+" dari "+cbtotal+" Group di Corporate Banking telah mencapai target "+ newDate+". <br/> Realisasi terbesar terdapat di "+highestcb);
	}else if(v_detail_type=="cbdept"){
		$("#"+v_id_div_highlight).html(cbachieve+" dari "+cbtotal+" Dept di Corporate Banking telah mencapai target "+ newDate+". <br/> Realisasi terbesar terdapat di "+highestcb);
	}
	//console.log(cbachieve+" dari "+cbtotal+" Group di Corporate Banking telah mencapai target September 2015");
	//console.log("Realisasi terbesar terdapat di "+highestcb);

	// Draw Graph
	var chart = AmCharts.makeChart(v_id_div, {
		  "type": "serial",
		  "fontFamily": 'Myriad Pro Light',
	  	  "fontSize": fontsize,
		  "marginRight": 70,
		  "dataProvider": data_provider,
		  "startDuration": 1,
		  "graphs": [{
		    "balloonText": "[[category]]<br>Target: [[target_show]]<br>Realz: [[realization_show]]",
		    "fillColorsField": "color",
		    "fillAlphas": 0.9,
		    "lineAlpha": 0,
		    "type": "column",
		    "labelText": "[[value]]%",
		    "valueField": "percentage"
		  }],
		  "chartCursor": {
		    "categoryBalloonEnabled": false,
		    "cursorAlpha": 0,
		    "zoomable": false
		  },
		  "categoryField": "organization",
		  "categoryAxis": {
		    "gridPosition": "start",
			"gridAlpha": 0,
		  },
		  "valueAxes": [
				{
					"id": "ValueAxis-1",
					"position": "top",
					"axisAlpha": 0,
					"gridAlpha": 0,
					"labelsEnabled":false,
					"minimum":0,
					
				}
			],
		  "export": {
		    "enabled": true
		  }

		});
}

function draw_customer_realization_graph(v_cbgroup, v_product, v_valuta, v_id_div, v_id_div_highlights, modul){
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
	var items=[];
	var total_composition=0;
	var total_amount=0;
	$.getJSON(
		config.base+"api_"+modul+"/get_top_customer_realization",
		{
			cbgroup: v_cbgroup,
			product: v_product,
			valuta: v_valuta
		},
		function(data,status,xhr){
			if(status=="success"){
				$.each( data.results , function( key, val ) {
					var amount = addCommas((val.realization/1000000).toFixed(0));
					var composition = parseFloat(val.composition).toFixed(2);
					var item_td;
					total_composition = parseFloat(total_composition) + parseFloat(composition) ;
					total_amount = parseFloat(total_amount) + parseFloat(val.realization/1000000);
					
					items.push("<tr>"+
	    			"<td style='text-align:left'><a href="+config.base+"customer_group/"+modul+"/group/"+val.custgroup_id+">"+val.customer+"</td>"+
	    			"<td>"+amount+"</td>"+
	    			"<td>"+composition+"%</td>"+
	    			"<td id='file_"+val.custgroup_id+"'><a style='color:#08c' onclick=\"show_ces_customer('"+val.customer+"')\">Download File</a></td>");
							
				});
				$('#'+v_id_div).html(items);
				$('#'+v_id_div_highlights).html(parseFloat(total_composition).toFixed(2)+"% ("+addCommas((total_amount).toFixed(0))+")");
				$('#tot_group_realz').html(addCommas((data.total_composition/1000000).toFixed(0)));
			}else{
	 			$('#'+v_id_div).html("error");
	 			$('#'+v_id_div_highlights).html("0%");
	 		}
		}
	);
}

function load_performance_realz_summary(cbgroup, product, valuta, page, modul){
	var div_to_draw = "";
	if(gv_modul == "portfolio"){
		div_to_draw = "_"+modul;
	}
	
	get_summary_realization_vs_target(cbgroup, product, valuta, 
		"total_realization_graph"+div_to_draw, "total_realization_highlight",
		"detail_realization_graph"+div_to_draw, "detail_realization_highlight",
		modul, page);
	
	if(page == "detail"){
		draw_customer_realization_graph(cbgroup, product, valuta, "customer_realization_table", "customer_realization_highlight", modul);
	}
	
	change_element_filter(cbgroup, product, valuta);
}

function load_performance_summary(cbgroup, product, valuta){
	if(gv_modul == "portfolio"){
		load_performance_realz_summary(gv_cbgroup, gv_product, gv_valuta, "summary","fund");
		load_performance_realz_summary(gv_cbgroup, gv_product, gv_valuta, "summary","credit");
		load_performance_realz_summary(gv_cbgroup, gv_product, gv_valuta, "summary","fee");
	}else{
		load_performance_realz_summary(cbgroup, product, valuta, "detail", gv_modul);
	}
}
