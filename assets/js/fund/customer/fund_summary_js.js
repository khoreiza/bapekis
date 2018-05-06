function load_fund_summary_summary(gv_cbgroup, gv_product, gv_valuta){
	load_fund_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'YoY', 'chartdiv_YoY_smry');
	load_fund_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'YtD', 'chartdiv_YtD_smry');
	load_fund_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'MtD', 'chartdiv_MtD_smry');
	if(cust_type == "group"){
		load_fund_realization_summary(gv_cbgroup, gv_product, gv_valuta, "chartdiv_pareto_smry");
	}
	//load_fund_special_rate_summary(gv_cbgroup, gv_product, gv_valuta, "chartdiv_special_rate_smry");
	load_fund_pipeline_summary(gv_cbgroup, gv_product, gv_valuta, gv_type, "chartdiv_pipeline_smry");
}

function load_fund_summary(gv_cbgroup, gv_product, gv_valuta){
	load_fund_summary_summary(gv_cbgroup, gv_product, gv_valuta);
}