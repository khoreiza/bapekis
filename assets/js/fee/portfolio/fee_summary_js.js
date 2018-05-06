function load_fee_summary_summary(gv_cbgroup, gv_product){
	load_fee_growth_summary(gv_cbgroup, gv_product);
	load_fee_realz_summary(gv_cbgroup, gv_product);
	load_fee_product_summary(gv_cbgroup, gv_product);
}

function load_fee_summary(gv_cbgroup, gv_product){
	load_fee_summary_summary(gv_cbgroup, gv_product);
}