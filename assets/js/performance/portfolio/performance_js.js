var fontsize=14;
if(url_arr[3]!="summary" && url_arr[2]!="portfolio"){
	fontsize=18;
}

var gv_modul = url_arr[2];

if(gv_modul=="mypage"){
	gv_modul = "credit"; gv_cbgroup ="all"; gv_product="all"; gv_valuta="all"; gv_dept="all";
	fontsize = 14;
	fund_color = "#189cb8";
}

load_performance_summary(gv_cbgroup, gv_product, gv_valuta);

function change_element_filter(gv_cbgroup, gv_product, gv_valuta){
	if(gv_cbgroup=="all"){el_grp = "";}else{el_grp = gv_cbgroup.split(" ")[2];}
	if(gv_valuta=="all"){el_val = "";}else if(gv_valuta == "RP"){el_val = "Rupiah";}else{el_val = "Valas";}
	if(gv_product=="all"){
		if(gv_modul=="fund"){el_prd = "Dana";}
		else if(gv_modul=="credit"){el_prd = "Kredit";}
		else if(gv_modul=="fee"){el_prd = "Fee Based";}
		else if(gv_modul=="portfolio"){el_prd = "Portfolio";}
	}else if(gv_product == "GIRO"){el_prd = "Giro";}
	else if(gv_product == "DEPO"){el_prd = "Deposito";}
	else{el_prd = gv_product;}
	
	if(gv_dept == "all"){
		$('.group-filter-elmt').html("Corporate Banking "+el_grp);
	}else{
		$('.group-filter-elmt').html(gv_dept);
	}
	$('.val-filter-elmt').html(el_val);
	$('.prd-filter-elmt').html(el_prd);
}