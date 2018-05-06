function load_performance_summary_summary(gv_cbgroup, gv_product, gv_valuta){
	
	if(gv_modul=="mypage"){gv_modul = credit; gv_cbgroup ="all";}

	load_performance_growth_summary(gv_cbgroup, gv_product, gv_valuta, "summary",gv_modul);
	load_performance_realz_summary(gv_cbgroup, gv_product, gv_valuta, "summary",gv_modul);
	if(gv_modul == "fund"){
		//load_performance_special_rate_summary(gv_cbgroup, gv_product, gv_valuta);
		load_fund_pipeline_summary(gv_cbgroup, gv_product, gv_valuta);
	}else if(gv_modul == "credit"){
		load_credit_monitoring_summary(gv_cbgroup, gv_product, gv_valuta);
		load_credit_pipeline_summary(gv_cbgroup, gv_product, gv_valuta);
	}else if(gv_modul == "fee"){
		load_fee_product_summary(gv_cbgroup, gv_product);
	}
}

function load_performance_summary(gv_cbgroup, gv_product, gv_valuta){
	load_performance_summary_summary(gv_cbgroup, gv_product, gv_valuta);
}