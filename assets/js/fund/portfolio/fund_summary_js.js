function load_fund_summary_summary(gv_cbgroup, gv_product, gv_valuta){
	load_fund_growth_summary(gv_cbgroup, gv_product, gv_valuta);
	load_fund_realz_summary(gv_cbgroup, gv_product, gv_valuta);
	
	load_fund_pipeline_summary(gv_cbgroup, gv_product, gv_valuta);
}

function load_fund_summary(gv_cbgroup, gv_product, gv_valuta){
	load_fund_summary_summary(gv_cbgroup, gv_product, gv_valuta);
}