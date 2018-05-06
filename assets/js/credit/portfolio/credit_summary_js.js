function load_credit_summary_summary(gv_cbgroup, gv_product, gv_valuta){
	load_credit_growth_summary(gv_cbgroup, gv_product, gv_valuta);
	load_credit_realz_summary(gv_cbgroup, gv_product, gv_valuta);
	load_credit_monitoring_summary(gv_cbgroup, gv_product, gv_valuta);
	load_credit_pipeline_summary(gv_cbgroup, gv_product, gv_valuta);
}

function load_credit_summary(gv_cbgroup, gv_product, gv_valuta){
	load_credit_summary_summary(gv_cbgroup, gv_product, gv_valuta);
}