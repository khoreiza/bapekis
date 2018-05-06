function get_realization_product_by_cbgroup(v_cbgroup){
	var result=[];
	$.getJSON(
		config.base+"api_fee/get_realization_product_by_cbgroup",
		{
			cbgroup: v_cbgroup
		},
		function(data,status,xhr){
			if(status=="success"){
				draw_table_realization_product(data,"#realization_product_table");
				draw_pie_realization_product(data,"chartdiv_composition");
	 		}else{
	 			
	 		}
		}
	);
}

function get_realization_product_by_product(v_cbgroup){
	var result=[];
	$.getJSON(
		config.base+"api_fee/get_realization_product_by_product",
		{
			cbgroup: v_cbgroup
		},
		function(data,status,xhr){
			if(status=="success"){
				draw_bar_graph_realization_product(data,"chartdiv_product_realization","detail_realization_highlight");
	 		}else{
	 			
	 		}
		}
	);
}


function draw_pie_realization_product(v_data, v_id_div){
	var data_provider = [];
	// Get Realization
	var realization_other=0; var tot_real = 0;
	$.each( v_data.realizations, function( key, val ) {
		tot_real += parseFloat(val.realization);
	});
	
	$.each( v_data.realizations, function( key, val ) {
		date = new Date(val.date);
		if(key==0){
			data_provider.push({
	            fee_group: val.fee_group,
				show_fee: val.fee_group,
	            realization: val.realization,
				show_val: (val.realization/tot_real*100).toFixed(2)+"%"
			});
			highest_pct = val.realization/tot_real*100;
			highest_product = val.fee_group;
		}else if(key<10){
			if(val.realization/tot_real > 0.03){
				data_provider.push({
					fee_group: val.fee_group,
					realization: val.realization,
					show_val: (val.realization/tot_real*100).toFixed(2)+"%"
				});
			}else{
				data_provider.push({
					fee_group: val.fee_group,
					realization: val.realization,
					show_val: ''
				});
			}
		}else{
			realization_other=realization_other+parseFloat(val.realization);
		}
		
	});
	data_provider.push({
		fee_group: "Lainnya", 
		show_fee: "Lainnya",
		realization: realization_other,
		show_val: (realization_other/tot_real*100).toFixed(2)+"%"
	});
	
	var label_radius = -60;
	if(url_arr[3]=="summary"){
		label_radius = -40;
	}

	var chart = AmCharts.makeChart( v_id_div, {
	  "type": "pie",
	  "fontFamily": 'Myriad Pro Light',
	  "fontSize": fontsize,
	  "theme": "light",
	  "dataProvider": data_provider,
	  "titleField": "fee_group",
	  "valueField": "realization",
	  "labelRadius": label_radius,
	  "colors":["#007aff", "#4ca1ff", "#99c9ff", "#b2d7ff", "#cce4ff", "#ffcc00","#ffe066","#ffea99","#c3c3c3", "#d3d3d3","#f3f3f3"],
  
	  "radius": "45%",
	  "innerRadius": "42%",
	  "labelText": "[[show_fee]]<br>[[show_val]]",
	  "export": {
		"enabled": true
	  }
	});
	
	var tot_realz_fee = get_show_number(tot_real).toFixed(get_bhd_comma_val(get_show_number(tot_real)))+" "+get_show_number_satuan(tot_real);
	var pct_show = get_show_number(highest_pct).toFixed(get_bhd_comma_val(get_show_number(highest_pct)))+"%";
	$("#highlight_total_amount_realization_product").html(tot_realz_fee);
	$("#highlight_highest_value_realization_product").html(highest_product);
	$("#total_realization_highlight").html(pct_show);
}

function draw_bar_graph_realization_product(v_data, v_id_div, v_id_div_highlight){
	var data_provider=[];
	var date = null;
	var newDate = "";
	var productachieve = 0;
	var producttotal = 0;
	var highestpercentage = 0;
	var highestproduct = "";


	// Get Target
	$.each( v_data.targets, function( key, valTarget ) {
		date = new Date(valTarget.target_date);
		newDate = date.toString('MMM yyyy');
		var target = parseFloat(valTarget.target); 
		var realization = 0;
		var organization = "";
		var color="";
		var percentage=0;

		// init organization
		organization = valTarget.cbgroup;

		// Get Realization
		if(target==0){
			// I dont know what should be done if the target is zero, make the percentage become infinite and make the bar graph disappear
		}else{
			$.each( v_data.realizations, function( key, valReal ) {
			 	if( valTarget.fee_group == valReal.fee_group ){
			 		realization = parseFloat(realization) + parseFloat(valReal.realization);
		 			organization = valTarget.fee_group;			 		
			 	}
			});
			percentage=parseFloat(realization*100/target).toFixed(0);
			// Get Highest Percentage
			if( parseFloat( parseFloat(highestpercentage).toFixed(2) ) <= parseFloat( parseFloat(percentage).toFixed(2) ) ){
				highestpercentage = percentage;
				highestproduct = organization;
			}
			if(percentage>=100){
				color=fund_color;
				productachieve=productachieve+1;
			}else{
				color=fund_negative_color;
			}
			producttotal=producttotal+1;
			if(realization){
				data_provider.push({
					organization: organization, 
					target: target,
					realization: realization,
					percentage: percentage,
					color:color
				});
			}
		}
	});
	console.log(JSON.stringify(data_provider));

	// Draw Highlight
	$("#"+v_id_div_highlight).html(productachieve+" dari "+producttotal+" Produk di Corporate Banking telah mencapai target "+ newDate+". <br/> Realisasi terbesar terdapat di "+highestproduct);
	
	// Draw Graph
	var chart = AmCharts.makeChart(v_id_div, {
		  "type": "serial",
		  
		  "marginRight": 70,
		  "dataProvider": data_provider,
		  "startDuration": 1,
		  "graphs": [{
		    "balloonText": "<b>[[category]]: [[value]]</b>",
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
					
				}
			],
		  "export": {
		    "enabled": true
		  }

		});
}

function draw_table_realization_product(v_data, v_id_div){
	var colors = ["#007aff", "#4ca1ff", "#99c9ff", "#b2d7ff", "#cce4ff", "#ffcc00","#ffe066","#ffea99","#c3c3c3", "#d3d3d3","#f3f3f3"];
	var items=[]; var tot_real = 0;
	$.each( v_data.realizations, function( key, val ) {
		tot_real += parseFloat(val.realization);
	});
	$.each( v_data.realizations, function( key, val ) {
		var amount = addCommas((val.realization/1000000).toFixed(0));
		if(key<10){color=colors[key];}else{color="#f3f3f3;"}
		items.push("<tr>"+
		"<td><div class='legend_cb' style='background-color:"+color+"'</div></td>"+
		"<td>"+val.fee_group+"</td>"+
		"<td style=\"text-align:center\">"+amount+"</td>"+
		"<td style=\"text-align:center\">"+(val.realization/tot_real*100).toFixed(2)+"%</td></tr>");
	});
	$(v_id_div).html(items);
}


function load_fee_product_summary(gv_cbgroup, gv_product){
	// var date_yesterday = $("#date_yesterday").val();
	// get_summary_realization_vs_target(date_yesterday, gv_cbgroup, gv_product, gv_valuta, 
	// 	"total_realization_graph", "total_realization_highlight",
	// 	"chartdiv_product_realization", "detail_realization_highlight",
	// 	"customer_realization_table","customer_realization_highlight");
	change_element_filter(gv_cbgroup, gv_product, "all");
	get_realization_product_by_cbgroup(gv_cbgroup);
	get_realization_product_by_product(gv_cbgroup);
}

function load_fee_summary(gv_cbgroup, gv_product){
	load_fee_product_summary(gv_cbgroup, gv_product);
}

function load_performance_summary(gv_cbgroup, gv_product){
	load_fee_product_summary(gv_cbgroup, gv_product);
}
