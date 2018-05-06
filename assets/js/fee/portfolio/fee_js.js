var fontsize=14;
if(url_arr[3]!="summary"){
	fontsize=18;
}

var gv_product="all";
var gv_valuta="all";
var gv_cbgroup="all";
load_fee_summary(gv_cbgroup, gv_product);

function change_element_filter(gv_cbgroup, gv_product, gv_valuta){
	if(gv_cbgroup=="all"){el_grp = "";}else{el_grp = gv_cbgroup.split(" ")[2];}
	if(gv_valuta=="all"){el_val = "";}else if(gv_valuta == "RP"){el_val = "Rupiah";}else{el_val = "Valas";}
	if(gv_product=="all"){el_prd = "Fee Based";}else{el_prd = gv_product;}
	
	$('.group-filter-elmt').html("Corporate Banking "+el_grp);
	$('.val-filter-elmt').html(el_val);
	$('.prd-filter-elmt').html(el_prd);
}
