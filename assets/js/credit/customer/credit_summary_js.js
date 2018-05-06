function load_credit_summary_summary(gv_cbgroup, gv_product, gv_valuta){
	load_credit_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'YoY', 'chartdiv_YoY_smry');
	load_credit_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'YtD', 'chartdiv_YtD_smry');
	load_credit_growth_summary(gv_cbgroup, gv_product, gv_valuta, 'MtD', 'chartdiv_MtD_smry');
	load_credit_realization_summary(gv_cbgroup, gv_product, gv_valuta, "chartdiv_pareto_smry");
	load_credit_monitoring_summary(gv_cbgroup, gv_product, gv_valuta, "monitoring_highlight_smry", "sum_jth_tmp_smry");
	load_credit_pipeline_summary(gv_cbgroup, gv_product, gv_valuta, "chartdiv_pipeline_smry");
}

function load_credit_summary(gv_cbgroup, gv_product, gv_valuta){
	load_credit_summary_summary(gv_cbgroup, gv_product, gv_valuta);
}