function load_fee_summary_summary(gv_cbgroup, gv_product, gv_valuta){
	load_fee_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'YoY', 'chartdiv_YoY_smry');
	load_fee_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'YtD', 'chartdiv_YtD_smry');
	load_fee_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'MtD', 'chartdiv_MtD_smry');
	if(cust_type == "group"){
		load_fee_realization_summary(gv_cbgroup, gv_product, gv_valuta, "chartdiv_pareto_smry");
	}
	load_fee_product_summary(gv_cbgroup, gv_product, "chartdiv_composition_smry");
}

function load_fee_summary(gv_cbgroup, gv_product, gv_valuta){
	load_fee_summary_summary(gv_cbgroup, gv_product, gv_valuta);
}