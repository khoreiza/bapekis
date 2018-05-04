<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admins
 *
 * @author Maulnick
 */

function get_kpi_color($realization){
	$arr['color_pct'] = array_color_broventh(9); $arr['color_txt'] = "";
    $arr['color_font'] = 'white';

    if($realization){
        if($realization >= 100){$arr['color_pct'] = array_color_broventh(3); $arr['color_txt'] = array_color_broventh(2);}
        elseif($realization<100 && $realization >= 95){$arr['color_pct'] = array_color_broventh(7); $arr['color_txt'] = array_color_broventh(6); $arr['color_font'] = "#777";}
        elseif($realization<95 && $realization >= 0){$arr['color_pct'] = array_color_broventh(5); $arr['color_txt'] = array_color_broventh(4);}

        if(!$arr['color_txt']) $arr['color_txt'] = $arr['color_pct'];
    }


	return $arr;
}


function get_news_page_title($type){
	if($type == "OCE") return "Office of Chief Economist";
	elseif($type == "Mansek") return "Mandiri Sekuritas";
	else return $type;
}

function get_kpi_type_result($type){
	if($type == "Ending Balance Dana") return "performance-fund";
	elseif($type == "Ending Balance Kredit") return "performance-credit";
	elseif($type == "Fee Based Income") return "performance-fee";
	elseif($type == "Fee Based Income") return "performance-fee";
	elseif($type == "Wholesale Income Anchor Clients") return "anchor-Wholesale";
	elseif($type == "Alliance Income Anchor Clients") return "anchor-Value Chain";
	else return $type;
}


function get_position_priority($position){
	if(strtoupper($position) == "GROUP HEAD") $data['priority'] = 1;
    elseif(strtoupper($position) == "DEPARTMENT HEAD") $data['priority'] = 2;
    elseif(strtoupper($position) == "TEAM LEADER") $data['priority'] = 3;
    elseif(strtoupper($position) == "OFFICER") $data['priority'] = 4;
    elseif(strtoupper($position) == "PELAKSANA") $data['priority'] = 5;
    elseif(strtoupper($position) == "SEKRETARIS") $data['priority'] = 5;

    return $data['priority'];
}

function get_position_color($position){
	if(strtoupper($position) == "DIRECTOR") return array_color_new(10);
	elseif(strtoupper($position) == "GROUP HEAD") return array_color_new(9);
	elseif(strtoupper($position) == "DEPARTMENT HEAD") return array_color_new(1);
	elseif(strtoupper($position) == "TEAM LEADER") return array_color_new(2);
	elseif(strtoupper($position) == "OFFICER") return array_color_new(3);
	elseif(strtoupper($position) == "PELAKSANA") return array_color_new(5);
	elseif(strtoupper($position) == "SEKRETARIS") return array_color_new(6);
	else return array_color_new(8);
}

function get_greeting(){
	$hrs = date("H");
	$mnt = date("i");

	if($hrs >  4){
		$msg = "It's Still Early"; // REALLY early
		$color = "#e7f4f6";
		$img = "dawn.png";
	}
	if(($hrs >  6) && ($mnt > 29) || ($hrs >  7)){
		$msg = "Good Morning";      // After 6am
		$color = "#724f23";
		$img = "morning.png";
	}
	if($hrs > 11){
		$msg = "Good Afternoon";    // After 12pm
		$color = "#3b5998";
		$img = "afternoon.png";
	}
	if($hrs > 16){
		$msg = "Good Evening";      // After 5pm
		$color = "#3E2A8D";
		$img = "evening.png";
	}
	if($hrs > 18){
		$msg = "Good Night";        // After 10pm
		$color = "#e5e5e5";
		$img = "night.png";
	}
	if($hrs > 22){
		$msg = "It's Late";        // After 10pm
	}
	return array("msg" => $msg, "color" => $color, "img" => $img);
}

function get_calendar_category($category,$start){
	if($category == "Bussiness Related") $img = "Bussiness_Related.png";
	elseif($category == "Customer Engagement") $img = "Customer_Engagement.png";
	elseif($category == "Worked Related") $img = "Worked_Related.png";
	elseif($category == "Employee Engagement") $img = "Employee_Engagement.png";
	elseif($category == "Meeting") $img = "Worked_Related.png";
	elseif($category == "TIB") $img = "Worked_Related.png";
	else{
		if($start < 15) $img = "Others_morning.png";
		elseif($start >= 15 && $start < 19) $img = "Others_evening.png";
		elseif($start >=19) $img = "Others_night.png";
	}

	return base_url()."assets/img/calendar_category/".$img;
}

function get_ssf_activities(){
	$arr_act = array("Negosiasi Terms & Condition", "Penunjukan Konsultan FS", "Pengumpulan Data & Dokumen", "Penyusunan CBI & NAK", "Market Checking","Proses Persetujuan Kredit","Arrangement Sindikasi","Dokumentasi");
	return $arr_act;
}

function dot_devider(){
	return " · ";
}

function get_commitment_category_title($key_categ){
	if($key_categ == "credit"){ $title_categ = "Credit Pipeline"; }
    else if($key_categ == "dana"){ $title_categ = "Dana Pipeline";}
    else if($key_categ == "fund"){ $title_categ = "Dana Pipeline";}
    else if($key_categ == "ots"){ $title_categ = "Call Report"; }
    else if($key_categ == "call_reports"){ $title_categ = "Call Report"; }
    else if($key_categ == "account_plan"){ $title_categ = "Account Plan"; }
    else if($key_categ == "other"){ $title_categ = "Other"; }

    return $title_categ;
}

function get_commitment_category_img($category){
	$arr = array("credit" => "refund", "dana" => "cash in hand", "fund" => "cash in hand", "ots" => "check book", "other" => "blog", "account_plan" => "survey", "call_reports" => "check book");
	if($category) return base_url()."assets/img/icon/".$arr[$category]." - office.png";
	else return $arr;
}

function get_array_permohonan(){
	return array("Permohonan Fasilitas Baru","Tambahan Fasilitas","Perpanjangan Fasilitas","Perubahan Syarat","Restrukturisasi","Others");
}

function get_directorate_priority($dir){
	if($dir == "Corporate Banking") return 1;
}

function get_arr_segment_ap(){
	return array("Wholesale","Value Chain","Subsidiaries");
}

function get_arr_directorate(){
	return array("Corporate Banking","Commercial Banking","Digital Banking & Technology","Finance & Treasury");
}

function get_raker_component($category){
	$arr_prod = array("FBI", "Dana", "Kredit", "VST", "Culture");
	$arr_icon = array("purse - color", "money transfer - office", "donate - office", "ship - color", "culture - color");
	$arr_title = array("FBI", "Dana", "Kredit", "Corporate Solution", "Culture");
	$i=0;
	foreach($arr_prod as $row){
		if($category == $row){
			$arr['icon'] = $arr_icon[$i];
			$arr['title'] = $arr_title[$i];
			break;
		}
		$i++;
	}
	return $arr;
}

function get_ftp_tenor($tenor, $tenor_type){
	if($tenor_type != "Hari") return $tenor." ".$tenor_type;
	else{
		if(1<=$tenor && $tenor<=4) return "1 s/d 4 Hari";
		elseif(5<=$tenor && $tenor<=12) return "5 s/d 12 Hari";
		elseif(13<=$tenor && $tenor<=20) return "13 s/d 20 Hari";
		elseif(21<=$tenor && $tenor<=31) return "21 s/d 28 Hari";
	}
}

function get_year_eom_array($year){
	$arr_eom = array();
	for($i=1; $i<=12; $i++){
		$time = $year."-".$i."-1";
		$arr_eom[$i] = date("Y-m-t", strtotime($time));
	}
	return $arr_eom;
}

function get_date_where($start,$end){
}

function loading_sign(){
	echo "<div class=\"center_text\">"
			."<img style=\"height:40px; margin-bottom:5px;\" src=\"".base_url()."assets/img/loader_images/loading.gif\">"
			."<div>Loading . . .</div>"
		."</div>";
}

function user_display($user){
	$user_name_words = explode(" ",$user['full_name']);
	$user_disp = $user_name_words[0];
	if(strlen($user_disp) < 3){
		$user_disp = $user_name_words[0]." ".$user_name_words[1];
	}
	if(isset($user['panggilan'])&& $user['panggilan']){
		$user_disp = $user['panggilan'];
	}

	return ucwords(strtolower($user_disp));
}

function get_user_nick_name($user){
	if(isset($user->panggilan)&& $user->panggilan){
		$user_disp = $user->panggilan;
	}
	else{
		$user_name_words = explode(" ",$user->full_name);
		$user_disp = $user_name_words[0];
		if(strlen($user_disp) < 3){
			$user_disp = $user_name_words[0]." ".$user_name_words[1];
		}
	}
	return $user_disp;
}

function write_this_instead_of($long, $short, $max){
	if(strlen($long) > $max){
		echo $short;
	}else{echo $long;}
}

function return_menu_array($menu){
	if($menu == "Performance Information"){
		return array("Dana","Kredit","Fee Based","Profitability","Biaya","DS Files","Special Rate","Required Yield","Commitment Monitoring");
	}
	elseif($menu == "Customer Information"){
		return array("CB Customer","CES, CBI & Call Report","Obligo Monitoring","Sales Pipeline");
	}
	elseif($menu == "Internal Information"){
		return array("Meeting Room","Legal & Compliance","Human Resources","Calendar of Event","Product Knowledge","Internal Sharing","CBIC Tube","FTP Rate","Informasi Kurs");
	}
	elseif($menu == "Market & Industry"){
		return array("Market Outlook","Portfolio Checking","Risk Knowledge","Industry Peers");
	}
	else{
		return array("My Page","My Report","My Tools","Search Page");
	}
}

function get_user_wallpaper($user){
	if(strtoupper($user->group) == "CORPORATE BANKING 6"){$wp = "farm.png";}
	elseif(strtolower($user->department) == "sector airport"){$wp = "airport.png";}
	elseif(strtolower($user->department) == "sector infrastructure & toll road"){$wp = "bridge.png";}
	elseif(strtolower($user->department) == "sector construction"){$wp = "construction.png";}
	elseif(strtolower($user->department) == "sector sea port & transportation"){$wp = "seaport.png";}
	elseif(strtolower($user->department) == "sector mining"){$wp = "mining.png";}
	elseif(strtolower($user->department) == "sector oil & gas i"){$wp = "oil & gas 1.png";}
	elseif(strtolower($user->department) == "sector oil & gas ii"){$wp = "oil & gas 2.png";}
	elseif(strtolower($user->department) == "sector information, communication & technology"){$wp = "bts.png";}
	elseif(strtolower($user->department) == "sector electricity"){$wp = "lightning.png";}
	elseif(strtolower($user->department) == "sector property"){$wp = "property.png";}
	elseif(strtolower($user->department) == "management information support"){$wp = "mis.png";}

	else{$wp = "gedung ny.jpg";}

	$wp = "assets/img/group_wallpaper/".$wp;

	return $wp;
}

function get_user_position(){
	return array("Director","Group Head","Department Head","Officer","Sekretaris","all");
}

function get_thumbnail_src($src){
	$src_ex = explode("/", $src);
	$return = "";
	for($i=0; $i<(count($src_ex) - 1); $i++){
		$return = $return.$src_ex[$i]."/";
	}
	return $return."thumb"."/".$src_ex[count($src_ex) - 1]."_thumbnail.jpg";
}

function data_biaya(){
	$arr_res = array();
	$arr_res[1] = array("group" => "CB1", "rkap" => 21875, "anggaran" => 17446, "real" => 14702, "rkap_pr" => 1266, "anggaran_pr" => 739, "real_pr" => 710);
	$arr_res[2] = array("group" => "CB2", "rkap" => 16852, "anggaran" => 13479, "real" => 12821, "rkap_pr" => 1634, "anggaran_pr" => 953, "real_pr" => 878);
	$arr_res[3] = array("group" => "CB3", "rkap" => 13303, "anggaran" => 10581, "real" => 10482, "rkap_pr" => 1225, "anggaran_pr" => 715, "real_pr" => 662);
	$arr_res[4] = array("group" => "CB4", "rkap" => 20429, "anggaran" => 16261, "real" => 9440, "rkap_pr" => 1635, "anggaran_pr" => 953, "real_pr" => 1063);
	$arr_res[5] = array("group" => "CB5", "rkap" => 11971, "anggaran" => 9753, "real" => 9653, "rkap_pr" => 1152, "anggaran_pr" => 672, "real_pr" => 848);
	$arr_res[6] = array("group" => "CB6", "rkap" => 11891, "anggaran" => 9513, "real" => 8136, "rkap_pr" => 1001, "anggaran_pr" => 584, "real_pr" => 464);
	$arr_res[7] = array("group" => "CB7", "rkap" => 0, "anggaran" => 0, "real" => 0, "rkap_pr" => 0, "anggaran_pr" => 0, "real_pr" => 0);
	$arr_res[8] = array("group" => "CB7 JV", "rkap" => 0, "anggaran" => 0, "real" => 0, "rkap_pr" => 0, "anggaran_pr" => 0, "real_pr" => 0);
	$arr_res[9] = array("group" => "CBS", "rkap" => 19170, "anggaran" => 15268, "real" => 6611, "rkap_pr" => 3071, "anggaran_pr" => 1791, "real_pr" => 1392);
	$arr_res[10] = array("group" => "DPLK", "rkap" => 0, "anggaran" => 0, "real" => 0, "rkap_pr" => 0, "anggaran_pr" => 0, "real_pr" => 0);
	$arr_res[11] = array("group" => "DCOR", "rkap" => 697, "anggaran" => 558, "real" => 409, "rkap_pr" => 0, "anggaran_pr" => 0, "real_pr" => 0);

	return $arr_res;
}

function get_biaya_time(){
	$result['year'] = 2017;
	$result['month'] = 9;
	return $result;
}

function cmp($a, $b){
	if($a['gap'] == $b['gap']){
		return 0;
	}
	return ($b['gap']<$a['gap']) ? -1:1;
}
function get_group_buc($group){
	$group = explode(" ", $group);
	$res = $group[2];
	/*if($res == 3){$res = 5;}
	elseif($res == 5){$res = 3;}
	elseif($res == 4){$res = 6;}
	elseif($res == 6){$res = 4;}*/
	return $res;
}

function get_user_buc_like($user){

}

function get_user_group_filter($user){
	$group_ex = explode(" ", $user['group']);
	$data['group'] = ""; $data['buc'] = "CB";
    if($user['role'] != "Director" && ($group_ex[0] == "CORPORATE" && $group_ex[1] == "BANKING") && !is_user_role($user,"SYSTEM ADMINISTRATOR")){
        $data['group'] = $user['group'];

        $buc_num = get_group_buc($data['group']);
        $data['buc'] = "CB".$buc_num;
    }
    if($data['group']){$data['group_title'] = "CB".$group_ex[2];}
    else{$data['group_title'] = "Dir CB";}

    return $data;
}

function get_realization_color($pct){
 	if($pct<95){return "red";}
 	elseif($pct>=100){return "green";}
 	else{return "orange";}
}

function get_files_upload_desc($code){
	if($code == "sr_atch"){
		return "Nota Special Rate";
	}
	else{
		return long_text($code,100);
	}
}

function first_letter_text($string, $max){
	if(strlen($string) > $max){
		return get_first_letter($string);
	}else{return check_all_big($string);}
}

function first_letter_text_real($string, $max){
	if(strlen($string) > $max){
		return get_first_letter($string);
	}else{return $string;}
}

function get_first_letter($string){
	$string = strtoupper($string);
	$words = explode(" ", $string);
	$acronym = "";

	foreach ($words as $w) {
		$stop_letter = array("&","OF");
		if(!(in_array($w, $stop_letter))){
			if($w) $acronym .= $w[0];
		}
	}
	return $acronym;
}

function get_ext_icon($ext){
	$arr_img = array('.jpg','.png','.jpeg');

	if($ext == ".doc" || $ext == ".docx"){$img = "word - color";}
	elseif($ext == ".xls" || $ext == ".xlsx"){$img = "xlx - color";}
	elseif($ext == ".ppt" || $ext == ".pptx"){$img = "ppt - color";}
	elseif($ext == ".pdf"){$img = "pdf - color";}
	elseif(in_array($ext, $arr_img)){$img = "gallery - color";}
	else{$img = "copy - color";}

	return get_icon_url($img.'.png');
}

function get_group_title($group,$dept){
    if($dept){
    	if(strlen($dept)>15){$group_title = get_first_letter($dept);}
    	else{$group_title = $dept;}
    }
    elseif($group){
    	$group_ex = explode(" ", $group);
    	$group_title = "SAM".$group_ex[2];
    }
    else{$group_title = "Dir SAM";}

    return $group_title;
}

function get_group_title_real($user){
	if(strtoupper($user['position']) == "DIRECTOR") return get_long_text($user['directorate'],200);
	elseif(strtoupper($user['position']) == "GROUP HEAD") return get_long_text($user['group'],200);
	else return get_long_text($user['dept'],200);
}

function plus_icon(){
	$src = get_icon_url('plus - tosca.png');
	echo "<img style=\"height:20px;\" src='".$src."'>";
}

function get_s($num){
	if($num > 1){echo "s";}
}

function sales_pipeline_icon($cycle){
	$num = explode("Cycle-", $cycle)[1];
	$arr_icon = array("reading","fine print","idea","training","blog","collaboration","handshake","gps receiving","cancel");
	icon_url($arr_icon[$num-1]." - office.png");
}

function get_file_ext($ext){
	$ext = strtolower($ext);
	if($ext == ".doc" || $ext == ".docx"){$img = "word";}
    elseif($ext == ".xls" || $ext == ".xlsx"){$img = "xlx";}
    elseif($ext == ".ppt" || $ext == ".pptx"){$img = "ppt";}
    elseif($ext == ".png" || $ext == ".jpg"){$img = "gallery";}
    else{$img = "pdf";}
    return $img;
}

function get_file_ext_office($ext){
	$ext = strtolower($ext);
	if($ext == ".doc" || $ext == ".docx"){$img = "word";}
    elseif($ext == ".xls" || $ext == ".xlsx"){$img = "xls";}
    elseif($ext == ".ppt" || $ext == ".pptx"){$img = "ppt";}
    elseif($ext == ".png" || $ext == ".jpg"){$img = "images";}
    elseif($ext == ".pdf"){$img = "pdf";}
    else{$img = "file";}
    return $img." - office.png";
}

function get_ext_office($ext){
	return get_icon_url(get_file_ext_office($ext));
}

function get_perf_table_title($title){
	if($title == "cbgroup"){return "group";}
	if($title == "cbdept"){return "dept";}
	elseif($title == "bikole"){return "kolektabilitas";}
	elseif($title == "kolektabilitas"){return "bikole";}
	elseif($title == "gas_accounting"){return "segment";}
	elseif($title == "group"){return "cbgroup";}
	elseif($title == "dept"){return "cbdept";}
	elseif($title == "kelolaan"){return "cbgroup";}
	else{return $title;}
}

function get_perf_table_title_extracom($title){
	if($title == "cbgroup"){return "group";}
	if($title == "cbdept"){return "dept";}
	elseif($title == "bikole"){return "kolektabilitas";}
	elseif($title == "kolektabilitas"){return "bikole";}
	elseif($title == "gas_accounting"){return "segment";}
	else{return $title;}
}

function get_report_date($report_type,$last_date){

	$last_date_array = explode("-", $last_date);
	$last_month_mtd = $last_date_array[1]-1; $last_year_mtd = $last_date_array[0];
	if($last_date_array[1]==1){
		$last_month_mtd = 12;
		$last_year_mtd=$last_date_array[0] -1;
	}

	if(strtolower($report_type) == strtolower("YoY")){
		$date=date('Y-m-t',mktime(0, 0, 0, $last_date_array[1], cal_days_in_month(CAL_GREGORIAN, $last_date_array[1], $last_date_array[0]-1), $last_date_array[0]-1)).";"
		.date('Y-m-d',mktime(0, 0, 0, $last_date_array[1], $last_date_array[2], $last_date_array[0]));
	}

	elseif(strtolower($report_type) == strtolower("YtD")){
		$date=date('Y-m-t',mktime(0, 0, 0, '12', cal_days_in_month(CAL_GREGORIAN, 12, $last_date_array[0]-1), $last_date_array[0]-1)).";";
		// get last date of last month in previous year
		$first_month=date('m',mktime(0, 0, 0, '01', cal_days_in_month(CAL_GREGORIAN, 1, $last_date_array[0]), $last_date_array[0]));
		$this_month=date('m',mktime(0, 0, 0, $last_date_array[1], cal_days_in_month(CAL_GREGORIAN, $last_date_array[1], $last_date_array[0]), $last_date_array[0]));
		$gap_month=$this_month - $first_month;
		for($i=1;$i<=$gap_month;++$i){
			if($i==2){
				$date=$date.date('Y-m-t',mktime(0, 0, 0, "02", "01", $last_date_array[0])).";";
			}else{
				$date=$date.date('Y-m-t',mktime(0, 0, 0, $i, cal_days_in_month(CAL_GREGORIAN, $i, $last_date_array[0]), $last_date_array[0])).";";
			}
		}
		$date=$date.date('Y-m-d',mktime(0, 0, 0, $last_date_array[1], $last_date_array[2], $last_date_array[0]));
	}

	elseif(strtolower($report_type) == strtolower("MtD")){
		$date=date('Y-m-t',mktime(0, 0, 0, $last_month_mtd, cal_days_in_month(CAL_GREGORIAN, $last_month_mtd, $last_year_mtd), $last_year_mtd)).";"; // get last date of last month within same year

		for($i=1;$i<=$last_date_array[2];++$i){
			if($i==$last_date_array[2]){
				$date=$date.date('Y-m-d',mktime(0, 0, 0, $last_date_array[1], $i, $last_date_array[0]));
			}else{
				$date=$date.date('Y-m-d',mktime(0, 0, 0, $last_date_array[1], $i, $last_date_array[0])).";";
			}
		}
	}
	$array_date=explode(';', $date);
	return $array_date;
}

function get_report_date_custom($report_type,$start_date,$end_date){
	if($report_type == "bulanan"){
		if($end_date<$start_date){$array_date = array($end_date);}

        else{
            $date=$start_date.";";
            $start_ex = explode("-", $start_date);
            $end_ex = explode("-", $end_date);

            for($i = $start_ex[0];$i<=$end_ex[0];$i++){
            	$start_m = 1; $end_m = 12;
            	if($i == $start_ex[0]){$start_m = $start_ex[1];}
            	if($i == $end_ex[0]){$end_m = $end_ex[1];}

            	for($j=$start_m;$j<$end_m;$j++){
            		$date = $date.date('Y-m-d',mktime(0, 0, 0, $j, cal_days_in_month(CAL_GREGORIAN, $j, $i), $i)).";";
            	}
            }
            $date = $date.$end_date.";";
            $array_date=explode(';', $date);
        }

	}elseif ($report_type == "harian") {
		$array_date = array("range_date",$start_date,$end_date);
	}
	return $array_date;
}

function get_update_sub_modul($sub_modul){
    if($sub_modul=='Internal Sharing'){return 'mysharing';}
    elseif($sub_modul=='Tokosidia'){return 'mysharing';}
    elseif($sub_modul=='Calendar of Event'){return 'calendar';}
    elseif($sub_modul=='Market Outlook'){return 'market';}
    elseif(($sub_modul=='Legal & Compliance News')){return 'compliance';}
    elseif(($sub_modul=='Human Resources')){return 'hr';}
    elseif(($sub_modul=='DS Files')){return 'dsfile';}
}

function get_code_sub_modul($sub_modul){
  if($sub_modul=='market'){return 'Market Outlook';}
  elseif(($sub_modul=='compliance')){return 'Legal & Compliance News';}
  elseif(($sub_modul=='hr')){return 'Human Resources';}
}

function get_pct_tgt_realz($realz, $target, $data){
	if(is_object($target)){
		$target = $target->target;
	}

	if(is_object($realz)){
		$realz =  $realz->endbal;
	}

	if($realz){$data['realization'] = $realz;}
	else{$data['realization'] = 0;}

	if($target && $target){
		$data['target'] = $target;
		$data['pct'] = ($data['realization'])/($data['target'])*100;
	}else{
		$data['target'] = 0;
		$data['pct'] = 100;
	}
	return $data;
}

function pipeline_title($pie){
	if($pie=='group_cb'){ $title='Group';}
	elseif($pie=='client_tier'){$title='Tiering';}
	elseif($pie=='progres'){$title='Progress';}
	elseif(($pie=='jenis_pembiayaan')){$title='Type Of Credit';}
	elseif(($pie=='sektor')){$title='Sektor';}
	elseif(($pie=='infra')){$title='Infrastruktur';}
	elseif(($pie=='valuta')){$title='Valuta';}
	return $title;
}

function long_text($string,$char){
	$ex = explode(" ", $string);
	$words = "";
	foreach($ex as $row){
		$row_word = check_all_big($row);
		$words.=$row_word." ";
	}
	echo substr($words, 0,$char);
	//echo ucwords(strtolower(substr($string,0,$char)));
	if((strlen($string))>$char){echo "...";}
}

function long_text_real($string,$char){
	echo substr($string,0,$char);
	if((strlen($string))>$char){echo "...";}
}

function check_all_big($string){
	$arr_all_big = array("PLN","DCOR","HCBP","BOD","SEVP","PTPN","II","III","IV","VI","XIII","LPDP","BPDP","BPJS","XL","BOD","KMK","KI","AKR","SME","IDR","(AKM)","CASA", "MKM", "KTA", "PWE", "LC", "KPR", "MGM", "FX", "EDC","ATM","DF","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII","SSF","PT");
	if(!in_array(strtoupper($string), $arr_all_big)) return ucwords(strtolower($string));
	else return strtoupper($string);
}

function get_first_letter_big($string){
	return ucwords(strtolower($string));
}

function get_long_text($string,$char){
	$return_result = "";
	$ex = explode(" ", $string);
	$words = "";
	foreach($ex as $row){
		$row_word = check_all_big($row);
		$words.=$row_word;
		if($row != end($ex)) $words.=" ";
	}
	$return_result = substr($words, 0,$char);
	//echo ucwords(strtolower(substr($string,0,$char)));
	if((strlen($string))>$char){$return_result .= "...";}
	return $return_result;
}

function get_long_text_real($string,$char){
	$return_result = substr($string, 0,$char);
	if((strlen($string))>$char){$return_result .= "...";}
	return $return_result;
}

function array_profit(){
	$array_profit = array("pend_bunga","biaya_ftp","asset_spread","biaya_bunga","pend_ftp","liability_spread","pend_bunga_bersih","ppap","pend_bersih_asset","premi_penjaminan","pend_bersih_lia","pend_bersih","fee_dan_pend","biaya_opre","biaya_um","biaya_tk","biaya_prom","biaya_lain","kontri_tnp_ppa","kontri_ppa","kontri_intra","kontri_cost","kontri_ppap");
	return $array_profit;
}

function currency_format($amount){
	if($amount>=0){
		return get_satuan($amount);
	}else{
		return "-".get_satuan(abs($amount));
	}
}

function currency_format_full($amount){
	if($amount>=0){
		$res = explode(" ", get_satuan($amount));
		if(isset($res[1]) && $res[1]){
			if($res[1] == "T") return $res[0]." Trillion";
			elseif($res[1] == "M") return $res[0]." Billion";
			elseif($res[1] == "Jt") return $res[0]." Million";
		}
		else return $res[0];

	}else{
		return "-".get_satuan(abs($amount));
	}
}

function get_satuan($amount){
	if($amount >= 1000000000000){
		$amount = $amount/1000000000000;
		return get_blkg_cmma($amount)." T";
	}elseif($amount >= 1000000000){
		$amount = $amount/1000000000;
		return get_blkg_cmma($amount)." M";
	}elseif($amount >= 1000000){
		$amount = $amount/1000000;
		return get_blkg_cmma($amount)." Jt";
	}elseif($amount>0){
		return get_blkg_cmma($amount);
	}
	else{
		return "-";
	}
}

function in_trillion($amount){
	$amount = $amount/1000000000;
	$amount = number_format ( $amount , 2 , "." , "" );
	return $amount;
}

function get_blkg_cmma($amount){
	if(!is_float($amount)){$i=0;}
	else{
		if($amount >= 100){
			$i = 0;
		}elseif($amount >=10){
			$i = 1;
		}elseif($amount>0){
			$i = 2;
		}
	}

	return number_format($amount,$i);
}

function get_batas_sp($bawah_val,$atas_val,$bawah_rate,$atas_rate,$val,$rate){
	$result = false;
	if($val>$bawah_val){
		if(($atas_val && ($val<$atas_val)) || ($atas_val==0)){}
	}

	return $result;
}

function get_form_element($array, $this){
	$result = array();
	foreach ($array as $row) {
		$result[$row] = $this->input->post($row);
	}
	return $result;
}

function get_arr_peers(){
	return array('cur_ratio','quick_ratio','return_on_avg','operating_pro_mar','net_profit','return_on_avr_asst','ebitda_grow','net_inc_grow','sales_grow','debt_to_equ','debt_to_asst','ltd_to_equ','ebitda_to_liab','leverage_ratio','assets_to','inventory_to','receivable_to','acc_pay_to','fixed_asst_to','sga');
}

function peers_ratio($code){
 		if($code == "cur_ratio"){return array("Current Ratio","","Liquidity");}
 		elseif($code == "quick_ratio"){return array("Quick Ratio","","Liquidity");}
 		elseif($code == "return_on_avg"){return array("Return to Average Equity","%","Profitability");}
 		elseif($code == "operating_pro_mar"){return array("Operating Profit Margin","%","Profitability");}
 		elseif($code == "net_profit"){return array("Net Profit Margin","%","Profitability");}
 		elseif($code == "return_on_avr_asst"){return array("Return to Average Asset","%","Profitability");}
 		elseif($code == "ebitda_grow"){return array("Ebitda Growth","%","Growth");}
 		elseif($code == "net_inc_grow"){return array("Net Income Growth","%","Growth");}
 		elseif($code == "sales_grow"){return array("Sales Growth","%","Growth");}
 		elseif($code == "debt_to_equ"){return array("Debt To Equity","%","Solvency");}
 		elseif($code == "debt_to_asst"){return array("Debt To Assets","%","Solvency");}
 		elseif($code == "ltd_to_equ"){return array("LTD To Equity","%","Solvency");}
 		elseif($code == "ebitda_to_liab"){return array("Ebitda To Liabilities","%","Solvency");}
 		elseif($code == "leverage_ratio"){return array("Leverage Ratio","%","Solvency");}
 		elseif($code == "assets_to"){return array("Assets TO","%","Activity");}
 		elseif($code == "inventory_to"){return array("Inventory TO","%","Activity");}
 		elseif($code == "receivable_to"){return array("Receivable TO","%","Activity");}
 		elseif($code == "acc_pay_to"){return array("Account Payable TO","%","Activity");}
 		elseif($code == "fixed_asst_to"){return array("Fixed Asset TO","%","Activity");}
 		elseif($code == "sga"){return array("SGA/Sales","%","Activity");}
 	}

function array_color($i){
	$arr_col = array("#43b4d6","#8ed2e6","#ffc000","#ffd966","#f4614e","#f8a095","#296480","#64abcd","#7f7f7f","#bfbfbf","#cfcfcf","#106d80","#189cb8", "#5db9cd","#ff9900","#ffb74c","#ad5b54","#f88379","#faa8a1","#888888","#ababab","#cfcfcf");
	$x = $i % sizeof($arr_col);
	return $arr_col[$x];
}

function array_color_new($i){
	$arr_col = array("#c1954f","#ffb500","#c2c2c2","#90d2e5","#f4614e","#f8a095","#296480","#64abcd", "#e6e7e8","#bfbfbf","#3f5a78","#778c9f","#1bbfe2","#88d3f0","#1ab99b","#dd5967","#ea9ba3","#ffc80b","#ffe385","#e6e7e8","#c5cdd6","#3f5a78");
	return $arr_col[$i];
}

function array_color_broventh($i){
	$arr_col = array("#43b4d6","#8ed2e6","#ffc000","#ffd966","#f4614e","#f8a095","#296480","#64abcd","#7f7f7f","#bfbfbf","#3f5a78","#778c9f","#1bbfe2","#88d3f0","#1ab99b","#dd5967","#ea9ba3","#ffc80b","#ffe385","#e6e7e8","#c5cdd6","#3f5a78");
	$x = $i % sizeof($arr_col);
	return $arr_col[$x];
}

function dir_info($id){
	if($id=="as"){
		$arr['name'] = "Agus Sudiarto";
		$arr['title'] = "SEVP of Special Asset Management";
		$arr['desc'] = '<p>Mr. Agus Sudiarto is an Indonesian citizen. Born in 1964.
		He Served as a SEVP of Special Asset Management at PT Bank Mandiri (Persero) Tbk';
	}
	return $arr;
}

function array_group_color($i){
	$arr_col = array("#189cb8", "#5db9cd","#ff9900","#ffb74c","#888888","#ababab","#cfcfcf");
	return $arr_col[$i];
}

function get_employee_photo($user){
	if(!$user->profile_picture){
 		if(file_exists("assets/uploads/user_photo/".$user->nik.".jpg")){
			$url = base_url()."assets/uploads/user_photo/".$user->nik.".jpg";
		}else{
			$url = base_url()."assets/img/general/profile.gif";
		}
	}else{
		$url = base_url().$user->profile_picture;

	}
	return $url;
}

function box_photo($url){
	if(file_exists($url)){
		$url = base_url().$url;
	}else{
		$url = base_url()."assets/img/general/photo_empty.png";
	}
	echo "<img style='width:100%; margin:0 auto; margin-top:0px; margin-left:0px;' src='".$url."'>";
}

function employee_photo($user){
	if(!$user->profile_picture){
 		if(file_exists("assets/uploads/user_photo/".$user->nik.".jpg")){
			$url = base_url()."assets/uploads/user_photo/".$user->nik.".jpg";
		}else{
			$url = base_url()."assets/img/general/profile.gif";
		}
	}else{
		$url = base_url().$user->profile_picture;

	}
	echo "<img style='width:100%; margin:0 auto; margin-top:0px; margin-left:0px;' src='".$url."'>";
}

function employee_photo_custom($user){
	if(!$user->profile_picture){
 		if(file_exists("assets/uploads/user_photo/".$user->nik.".jpg")){
			$url = base_url()."assets/uploads/user_photo/".$user->nik.".jpg";
		}else{
			$url = base_url()."assets/img/general/profile.gif";
		}
	}else{
		$url = base_url().$user->profile_picture;

	}
	echo "<img style='width:100%; margin-top:-1px;' src='".$url."'>";
}

function my_photo($user){
	if(!$user['profile_picture']){
 		if(file_exists("assets/uploads/user_photo/".$user['nik'].".jpg")){
			$url = base_url()."assets/uploads/user_photo/".$user['nik'].".jpg";
		}else{
			$url = base_url()."assets/img/general/profile.gif";
		}
	}else{
		$url = base_url().$user['profile_picture'];
	}

	echo "<img style='width:100%; margin:0 auto; margin-top:0px; margin-left:0px;' src='".$url."'>";
}


function employee_photo_thumb_small($user){
	if(!$user->profile_picture){
 		if(file_exists("assets/uploads/user_photo/thumb/".$user->nik.".jpg_thumbnail.jpg")){
			$url = base_url()."assets/uploads/user_photo/thumb/".$user->nik.".jpg_thumbnail.jpg";
		}else{
			$url = base_url()."assets/img/general/profile.gif";
		}
	}else{
		$ex = explode("/", $user->profile_picture);
		$url = base_url()."assets/uploads/user_profile/thumb/".end($ex)."_thumbnail.jpg";

	}
	echo "<img style='width:100%; margin:0 auto; margin-top:-3px; margin-left:0px;' src='".$url."'>";
}


function employee_photo_thumb($user){
	if(!$user->profile_picture){
 		if(file_exists("assets/uploads/user_photo/thumb/".$user->nik.".jpg_thumbnail.jpg")){
			$url = base_url()."assets/uploads/user_photo/thumb/".$user->nik.".jpg_thumbnail.jpg";
		}else{
			$url = base_url()."assets/img/general/profile.gif";
		}
	}else{
		$ex = explode("/", $user->profile_picture);
		$url = base_url()."assets/uploads/user_profile/thumb/".end($ex)."_thumbnail.jpg";

	}
	echo "<img style='width:100%; margin:0 auto; margin-top:0px; margin-left:0px;' src='".$url."'>";
}

function my_photo_thumb($user){
	if(!$user['profile_picture']){
 		if(file_exists("assets/uploads/user_photo/thumb/".$user['nik'].".jpg_thumbnail.jpg")){
			$url = base_url()."assets/uploads/user_photo/thumb/".$user['nik'].".jpg_thumbnail.jpg";
		}else{
			$url = base_url()."assets/img/general/profile.gif";
		}
	}else{
		$ex = explode("/", $user['profile_picture']);
		$url = base_url()."assets/uploads/user_profile/thumb/".end($ex)."_thumbnail.jpg";
		//$url = base_url().$user['profile_picture']."_thumbnail.jpg";
	}

	echo "<img style='width:100%; margin:0 auto; margin-top:0px; margin-left:0px;' src='".$url."'>";
}


function component_title($title){
	//$title = str_replace(array('_'), ' ',$title);
 	echo "<h4 style='margin:0 0px 10px 0; color:#df756c' class='pull-right'>".$title."</h4>";
	echo "<div style='clear:both'></div>";
}

function component_title_box($title){
	$title = str_replace(array('_'), ' ',$title);
 	echo "<h4>".$title."</h4>";
}

function sub_title_link(){
	return "<span style=\"font-size:12px;\" class='glyphicon glyphicon-menu-right'></span>";
}

function sub_title_span($type,$sub_title){
	return "<span class='".$type."_sub_title'>$sub_title</span>";
}

function get_sub_title($contr){
	$arr_financial = array('dsfile','special_rate','required_yield','biaya','profitability','portfolio','credit_pipeline','credit_pipeline_list','fourdx');
	$arr_customer = array('customer_group','sales_pipeline','customer_files','mos');
	$arr_internal = array('hr','product_knowledge','calendar','currency','compliance','watchlist','downgrade','ftp','mysharing','tube','meeting');
	$arr_market = array('market','idata','peers');
	$arr_mypage = array('mypage','mytools','myreport');
	$arr_ots = array('ots');
	$arr_admin = array('user','log_activity');

	if(in_array($contr, $arr_financial)){return "Performance Information";}
	elseif(in_array($contr, $arr_customer)){return "Customer Information";}
	elseif(in_array($contr, $arr_internal)){return "Internal Information";}
	elseif(in_array($contr, $arr_market)){return "Market & Industry (iData)";}
	elseif(in_array($contr, $arr_mypage)){return "My Page";}
	elseif(in_array($contr, $arr_ots)){return "OTS";}
	elseif(in_array($contr, $arr_admin)){return "Admin";}
	elseif($contr == "updates" || !$contr){return "My Page";}
	elseif($contr == "customize_analysis"){return "My Analysis";}
	elseif($contr == "festival"){return "CBIC Festival";}
}

function write_page_sign($contr, $page_name){
	echo "<a href=\"".base_url()."\"><div style=\"float:left; \"><span class=\"glyphicon glyphicon glyphicon-home\" aria-hidden=\"true\" ></span></a></div>";
	echo return_arrow();
	echo "<div class=\"small_to_show\" style=\"float:left; \">".get_sub_title($contr)."</div>";
	if($page_name){
		echo "<div class=\"small_to_show\" style=\"float:left; \">".return_arrow()."</div>";
		echo "<div style=\"float:left; \">".$page_name."</div>";
	}else{echo "</div>";}
}

function get_group($group){
	if($group == "Corporate Banking I" || $group == "CB 1"){return "CORPORATE BANKING 1";}
	elseif($group == "Corporate Banking II" || $group == "CB 2"){return "CORPORATE BANKING 2";}
	elseif($group == "Corporate Banking III" || $group == "CB 3"){return "CORPORATE BANKING 3";}
	elseif($group == "Corporate Banking IV" || $group == "CB 4"){return "CORPORATE BANKING 4";}
	elseif($group == "Corporate Banking V" || $group == "CB 5"){return "CORPORATE BANKING 5";}
	elseif($group == "Corporate Banking VI" || $group == "CB 6"){return "CORPORATE BANKING 6";}
	elseif($group == "Corporate Banking VII" || $group == "CB 7"){return "CORPORATE BANKING 7";}
	elseif($group == "CBS"){return "CORPORATE BANKING SOLUTION";}
	elseif($group == "GVI 1"){return "GOVERNMENT & INSTITUTIONAL 1";}
	elseif($group == "GVI 2"){return "GOVERNMENT & INSTITUTIONAL 2";}
	elseif($group == "GVP"){return "GOVERNMENT PROGRAM";}
	else{return $group;}
}

function get_db_product($product){
	if(in_array($product, array('CASA','GIRO','TABBIS','DEPO','DOC','TAB'))){
		return "mfund";
	}
	elseif (in_array($product, array('KMK','KI','TR'))) {
		return "mcredit";
	}
}
function get_array_status(){
	return array("Not Started","On Progress","Delay","Done");
}
function status_font_color($status){
	if($status == "On Progress"){return "black";}
	elseif($status == "Delay"){return "white";}
	elseif($status == "Potential to be Delayed"){return "white";}
	elseif($status == "Done"){return "white";}
	elseif($status == "Not Started"){return "white";}
}
function status_color($status){
	if($status == "On Progress"){return "#67cb7a";}
	elseif($status == "Delay"){return "#da635d";}
	elseif($status == "Potential to be Delayed"){return "#ffcc00";}
	elseif($status == "Done"){return "#08c";}
	elseif($status == "Not Started"){return "#8e8e93";}
}

function status_soft_color($status){
	if($status == "On Progress"){return "#e0f4e4";}
	elseif($status == "Delay"){return "#f3d0ce";}
	elseif($status == "Potential to be Delayed"){return "#ffea99";}
	elseif($status == "Done"){return "#cce7f4";}
	elseif($status == "Not Started"){return "#d2d2d2";}
}
function arr_4dx_category(){
	return  array('credit', 'fund', 'fee', 'other');
}
function arr_initiative_category(){
	return  array('tiering', 'bis_process','service','rm_ca','vst', 'cbic', 'it_cpx');
}
function fourdx_categ($id){
	if($id=="intracom"){return "Intrakom";}
	elseif($id=="extracom"){return "Ekstrakom";}
}
function draw_category_icon($id){
	if($id=="credit"){return icon_url("money transfer - office.png");}
	elseif($id=="fund"){return icon_url("donate - office.png");}
	elseif($id=="fee"){return icon_url("coins - office.png");}
	elseif($id=="mis"){return icon_url("multiple devices - office.png");}
	else{return icon_url("book shelf - office.png");}
}
function icon_url($img){
	echo base_url()."assets/img/icon/".$img;
}
function get_icon_url($img){
	return base_url()."assets/img/icon/".$img;
}
function get_knowledge_info($sub_modul){
	$info = array();
	if($sub_modul == "structure"){
		$info = array('modul' => "organization", 'modul_title' => "Organisasi", 'sub_title'=>"Struktur Organisasi");
	}elseif($sub_modul == "ownership"){
		$info = array('modul' => "organization", 'modul_title' => "Organisasi", 'sub_title'=>"Ownership");
	}elseif($sub_modul == "model"){
		$info = array('modul' => "business", 'modul_title' => "Model Bisnis", 'sub_title'=>"Model Bisnis Nasabah");
	}elseif($sub_modul == "product"){
		$info = array('modul' => "business", 'modul_title' => "Model Bisnis", 'sub_title'=>"Potensi Product Perbankan");
	}elseif($sub_modul == "sales"){
		$info = array('modul' => "business", 'modul_title' => "Model Bisnis", 'sub_title'=>"Customer Sales");
	}elseif($sub_modul == "distribution"){
		$info = array('modul' => "branches", 'modul_title' => "Sebaran Bisnis", 'sub_title'=>"Sebaran Bisnis Nasabah");
	}elseif($sub_modul == "product_reg"){
		$info = array('modul' => "branches", 'modul_title' => "Sebaran Bisnis", 'sub_title'=>"Potensi Product Perbankan Wilayah");
	}elseif($sub_modul == "model_vc"){
		$info = array('modul' => "value_chain", 'modul_title' => "Value Chain", 'sub_title'=>"Model Bisnis Value Chain");
	}elseif($sub_modul == "distribution_vc"){
		$info = array('modul' => "value_chain", 'modul_title' => "Value Chain", 'sub_title'=>"Sebaran Bisnis Value Chain");
	}elseif($sub_modul == "support"){
		$info = array('modul' => "value_chain", 'modul_title' => "Value Chain", 'sub_title'=>"Dukungan Anchor Client");
	}elseif($sub_modul == "visi"){
		$info = array('modul' => "vision", 'modul_title' => "Company Profile", 'sub_title'=>"Visi Misi");
	}elseif($sub_modul == "value"){
		$info = array('modul' => "vision", 'modul_title' => "Company Profile", 'sub_title'=>"Nilai Perusahaan");
	}elseif($sub_modul == "strategy"){
		$info = array('modul' => "vision", 'modul_title' => "Company Profile", 'sub_title'=>"Strategi Perusahaan");
	}elseif($sub_modul == "priority"){
		$info = array('modul' => "vision", 'modul_title' => "Company Profile", 'sub_title'=>"Prioritas Perusahaan");
	}elseif($sub_modul == "target"){
		$info = array('modul' => "vision", 'modul_title' => "Company Profile", 'sub_title'=>"Target Bisnis");
	}elseif($sub_modul == "strength"){
		$info = array('modul' => "swot", 'modul_title' => "SWOT", 'sub_title'=>"Strengths");
	}elseif($sub_modul == "weakness"){
		$info = array('modul' => "swot", 'modul_title' => "SWOT", 'sub_title'=>"Weaknesses");
	}elseif($sub_modul == "opportunity"){
		$info = array('modul' => "swot", 'modul_title' => "SWOT", 'sub_title'=>"Opportunities");
	}elseif($sub_modul == "threat"){
		$info = array('modul' => "swot", 'modul_title' => "SWOT", 'sub_title'=>"Threats");
	}elseif($sub_modul == "impact"){
		$info = array('modul' => "industry", 'modul_title' => "Industry", 'sub_title'=>"Industy Impact to Bussiness");
	}elseif($sub_modul == "general_analysis"){
		$info = array('modul' => "general_analysis", 'modul_title' => "BMRI Relation", 'sub_title'=>"Posisi BMRI di Mata Nasabah");
	}elseif($sub_modul == "product_voc"){
		$info = array('modul' => "voc", 'modul_title' => "Voice of Client", 'sub_title'=>"Client Voice about Product");
	}elseif($sub_modul == "service_voc"){
		$info = array('modul' => "voc", 'modul_title' => "Voice of Client", 'sub_title'=>"Client Voice about Services");
	}elseif($sub_modul == "rm_voc"){
		$info = array('modul' => "voc", 'modul_title' => "Voice of Client", 'sub_title'=>"Client Voice about Relationship Manager");
	}
	$info['sub'] = $sub_modul;
	return $info;
}

function is_user_role($user,$role){
	if(is_array ( $user )){
		$arr_role = explode(";",$user['role']);
		$user_role = $user['role'];
	}else{
		$arr_role = explode(";",$user->role);
		$user_role = $user->role;
	}

	if(($user_role == $role || in_array($role,$arr_role)) || (in_array("SYSTEM ADMINISTRATOR", $arr_role) && $role != "MEGA ADMINISTRATOR")){
		return true;
	}
}

function is_user_role_only($user,$role){
	if(is_array ( $user )){
		$arr_role = explode(";",$user['role']);
		$user_role = $user['role'];
	}else{
		$arr_role = explode(";",$user->role);
		$user_role = $user->role;
	}

	if(($user_role == $role || in_array($role,$arr_role)) || (in_array("MEGA ADMINISTRATOR", $arr_role))){
		return true;
	}
}

function does_user_role($role){
	$user = $this->session->userdata('userdbcisam');
	$arr_role = explode(";",$user['role']);
	if(($user['role'] == $role || in_array($role,$arr_role)) || in_array("SYSTEM ADMINISTRATOR", $arr_role)){
		return true;
	}
}

function make_dir($path){
	if (!is_dir($path)) {
		mkdir($path, 0777, true);
	}
}
function upload_config($upload_path){
  	$full_path = "assets/uploads/".$upload_path;
  	if (!is_dir($full_path)) {
		mkdir($full_path, 0777, true);
	}
  	$config = array(
		'upload_path' => $full_path,
		'allowed_types' => "*",
		'overwrite' => FALSE,
		'max_size' => "2048000000",
		'maintain_ratio' => TRUE,
	);
      return $config;
  }

  function upload_config_full_url($upload_path){
  	$full_path = $upload_path;
  	if (!is_dir($full_path)) {
		mkdir($full_path, 0777, true);
	}
  	$config = array(
		'upload_path' => $full_path,
		'allowed_types' => "*",
		'overwrite' => FALSE,
		'max_size' => "2048000000",
		'maintain_ratio' => TRUE,
	);
      return $config;
  }

function return_growth_type($type){
	if($type=="MtD"){return "Month to Date";}
	elseif($type=="YtD"){return "Year to Date";}
	else{return "Year on Year";}
}
function get_disabled($submenu,$urls){
	if(is_array($urls)){
	foreach($urls as $url){
		if($submenu == $url){
			echo "selected";
			break;
		}
	}
	}else{
		if($submenu == $urls){
		echo "selected";
	}
	}
}

 function get_breadcrumb_menu($contr, $func, $type, $id){
	$arr_bc = array("portal","portfolio","fund","credit","fee","obligo","customer_group","customer_files");
	$arr_perf = array("portfolio","fund","credit","fee");
	$arr_cust = array("obligo","customer_group","customer_files");
	if(in_array($contr,$arr_bc)){
		echo "<div style=\"padding-left:20px; float:left; color:#333\"><a href='".base_url()."'><span class=\"glyphicon glyphicon glyphicon-home\" aria-hidden=\"true\" ></span></a></div>";
		echo return_arrow();
	if(in_array($contr,$arr_perf)){
		echo "<div style=\"margin-left:5px; float:left; color:#333; font-size:14px;\"><a href='".base_url()."portfolio/realization'>Performance</a></div>";
		echo return_arrow();
		echo "<div style=\"margin-left:5px; float:left; color:#333\">
				<button class=\"btn btn-link\" onclick=\"toggle_visibility('menu1')\">".return_contr_func_real_name($contr)."</span></button>
				<div class=\"bc_menu\" id=\"menu1\">
					<div><a href='".base_url()."portfolio/realization'>Summary</a></div>
					<div><a href='".base_url()."fund/summary'>Dana</a></div>
					<div><a href='".base_url()."credit/summary'>Kredit</a></div>
					<div><a href='".base_url()."fee/summary'>Fee Based</a></div>
				</div>
			</div>";
		if($contr != "portfolio"){
			$prod_add = "";
			if($func!="summary" && $func!="special_rate" && $func!="product"){$prod_add = return_contr_func_real_name($contr);}
			echo return_arrow();
			echo "<div style=\"margin-left:5px; float:left; color:#333\">
					<button class=\"btn btn-link\" onclick=\"toggle_visibility('menu2')\">".return_contr_func_real_name($func)." ".$prod_add."</span></button>
					<div class=\"bc_menu\" id=\"menu2\">
						<div><a href='".base_url().$contr."/summary'>Summary</a></div>
						<div><a href='".base_url().$contr."/growth'>Pergerakan ".return_contr_func_real_name($contr)."</a></div>
						<div><a href='".base_url().$contr."/realization'>Realisasi ".return_contr_func_real_name($contr)."</a></div>";
			if($contr == "fund"){
				echo "<div><a href='".base_url().$contr."/special_rate'>Special Rate</a></div>";
			}elseif($contr == "credit"){
				echo "<div><a href='".base_url().$contr."/monitoring'>Monitoring ".return_contr_func_real_name($contr)."</a></div>";
			}elseif($contr == "fee"){
				echo "<div><a href='".base_url().$contr."/product'>Komposisi Product</a></div>";
			}
			if($contr != "fee"){
				echo "<div><a href='".base_url().$contr."/pipeline'>Pipeline ".return_contr_func_real_name($contr)."</a></div>";
			}
			echo	"</div>";
		}
	}
	if(in_array($contr,$arr_cust)){
		echo "<div style=\"margin-left:5px; float:left; color:#333; font-size:14px;\"><a href='".base_url()."customer_group/search'>Customer</a></div>";
		if($func != "search"){
			echo return_arrow();
			echo "<div style=\"margin-left:5px; float:left; color:#333\">";
			if($contr=="customer_files"){echo "<button class=\"btn btn-link\" onclick=\"toggle_visibility('menu1')\">Files</span></button>";}
			elseif($contr=="obligo"){echo "<a href='".base_url()."obligo/summary/'>Obligo Monitoring</a>";}
			else{echo "<button class=\"btn btn-link\" onclick=\"toggle_visibility('menu1')\">".return_contr_func_real_name($func)."</span></button>";}

			echo	"<div class=\"bc_menu\" id=\"menu1\">
						<div><a href='".base_url()."performance/summary'>Summary</a></div>
						<div><a href='".base_url()."customer_group/fund/".$type."/".$id."'>Dana</a></div>
						<div><a href='".base_url()."customer_group/credit/".$type."/".$id."'>Kredit</a></div>
						<div><a href='".base_url()."customer_group/fee/".$type."/".$id."'>Fee Based</a></div>";
			if($type=="customer"){
				echo "<div><a href='".base_url()."customer_group/fee/".$type."/".$id."'>Files</a></div>
						<div><a href='".base_url()."obligo/summary/".$type."/".$id."'>Obligo Monitoring</a></div>";
			}
			echo	"</div>
				</div>";
		}
	}
	if($contr == "portal"){
		echo "<div style=\"margin-left:5px; float:left; color:#333; font-size:14px;\"><a href='".base_url()."portfolio/realization'>RING Portal</a></div>";
		echo return_arrow();
		echo "<div style=\"margin-left:5px; float:left; color:#333; font-size:14px;\"><a href='".base_url()."portfolio/realization'>Customer Information</a></div>";
	}
	echo "</div>";
		}
}

function return_arrow(){
	return "<div style=\"margin-left:5px; margin-right:5px; float:left; color:#c3c3c3; font-size:16px;\"><span class=\"glyphicon glyphicon glyphicon-menu-right\" aria-hidden=\"true\"></span></div>";
}

function return_contr_func_real_name($param){
	if($param=="portfolio"){return "Summary";}
	elseif($param=="fund"){return "Dana";}
	elseif($param=="credit"){return "Kredit";}
	elseif($param=="fee"){return "Fee Based";}
	elseif($param=="summary"){return "Summary";}
	elseif($param=="growth"){return "Pergerakan";}
	elseif($param=="realization"){return "Realisasi";}
	elseif($param=="pipeline"){return "Pipeline";}
	elseif($param=="special_rate"){return "Special Rate";}
	elseif($param=="monitoring"){return "Monitoring";}
	elseif($param=="product"){return "Komposisi Product";}
	elseif($param=="portal"){return "RING Portal";}
}

function get_subordinate($param){
	$param = strtolower($param);
	if($param=="direktur" || $param=="director"){
		return "group head";
	}else if($param=="group head"){
		return "department head";
	}else if($param=="department head"){
		return "officer";
	}else{
		return "";
	}
}

function get_superior($param){
	$param = strtolower($param);
	if($param=="group head"){
		return "director";
	}else if($param=="department head"){
		return "group head";
	}else if($param=="officer"){
		return "department head";
	}else{
		return "";
	}
}

function get_level($param){
	$param = strtolower($param);
	if($param=="direktur" || $param=="director"){
		return 3;
	}else if($param=="group head"){
		return 2;
	}else if($param=="department head"){
		return 1;
	}else if($param=="officer"){
		return 0;
	}else{
		return 0;
	}
}

function get_position_name($level,$user){
	if($level==3){
		return "Director";
	}else if($level==2){
		return $user->group;
	}else if($level==1){
		return $user->department;
	}else{
		return '';
	}
}


function excelDateToDate($readDate){
    $phpexcepDate = $readDate-25569; //to offset to Unix epoch
    return strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
}

function excelDateToDateNew($readDate){
	$UNIX_DATE = ($readDate - 25569) * 86400;
	$date = new DateTime("@$UNIX_DATE");
	return $date->format("Y-m-d");
}

function beautify_words($word){
	return ucwords(str_replace("_"," ",$word));
}

function code_frequency($word){
	if($word=='quarter'){
		$string = "Triwulan ini";
	}else if($word=='month'){
		$string = "Bulan ini";
	}else if($word=='week'){
		$string = "Minggu ini";
	}else if($word=='year'){
		$string = "Tahun ini";
	}
	return $string;
}

function shorten_news($news, $onclick, $limit=200, $start=0){
	// strip and trim news
	$news = strip_tags($news, "");
	$news = str_replace("  ", " ", $news);
	$news = str_replace("  ", " ", $news);
	$news = str_replace("  ", " ", $news);
	$news = str_replace("&nbsp;&nbsp;", "&nbsp;", $news);
	$news = str_replace("&nbsp;&nbsp;", "&nbsp;", $news);
	$news = str_replace("&nbsp;&nbsp;", "&nbsp;", $news);
	$news = str_replace("&nbsp; ", "&nbsp;", $news);
	$news = str_replace("&nbsp; ", "&nbsp;", $news);
	$news = str_replace("&nbsp; ", "&nbsp;", $news);
	$news = str_replace(" &nbsp;", "&nbsp;", $news);
	$news = str_replace(" &nbsp;", "&nbsp;", $news);
	$news = str_replace(" &nbsp;", "&nbsp;", $news);

	// shorten news
	$shorten = substr($news, $start, $limit);

	if (strlen($news) > $limit) {
		return "$shorten . . .<br /><div style='text-align:right'><a onclick='$onclick'>Read More</a></div>";
	}

	return $shorten;
}

function internalsharingdefault() {
	return base_url()."assets/img/general/internalsharingdefault.jpg";
}

function json_error(&$json, $exception, $code = 500) {
	log_message('error', $exception->getMessage());

	$json = array();
	$json['status'] = "error";
	$json['message'] = "Internal Server Error (500).<br />Silahkan hubungi Administrator.";
	$json['exception'] = $exception->getMessage();

	return $json;
}

function monthstr_to_monthno($string){
	switch (strtolower($string)) {
	    case 'jan':
	    case 'januari':
	        return 1;
	        break;
	    case 'feb':
	    case 'februari':
	        return 2;
	        break;
	    case 'mar':
	    case 'maret':
	        return 3;
	        break;
	    case 'apr':
	    case 'april':
	        return 4;
	        break;
	   	case 'mei':
	        return 5;
	        break;
	   	case 'jun':
	   	case 'juni':
	        return 6;
	        break;
	   	case 'jul':
	   	case 'juli':
	        return 7;
	        break;
	    case 'agu':
	   	case 'aug':
	   	case 'agustus':
	        return 8;
	        break;
	   	case 'sept':
	    case 'sep':
	    case 'september':
	        return 9;
	        break;
	    case 'oct':
	    case 'okt':
	    case 'oktober':
	        return 10;
	        break;
	    case 'nov':
	    case 'november':
	    	return 11;
	        break;
	    case 'des':
	    case 'dec':
	    case 'desember':
	        return 12;
	        break;
	    default:
	        return 0;
	}
}

function search_header_monthly($header){
	$arr_month_en = array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des');
	$arr_month_in = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$arr_header = array();
	foreach($arr_month_in as $k=>$v){
		$month=monthstr_to_monthno($v);
		$arr_header['month_'.$month] = array_search(strtoupper($v),$header);
		if($arr_header['month_'.$month] == FALSE){
			$month=monthstr_to_monthno($arr_month_in[$k]);
			$arr_header['month_'.$month] = array_search(strtoupper($arr_month_en[$k]),$header);
		}
	}
	return $arr_header;
}


function get_amount_monthly($excel, $arr_header, $row){
	$arr_temp_header = array();
	for($i=1;$i<=12;$i++){
		$arr_temp_header[$i]['amount'] = 0;
		$arr_temp_header[$i]['amount'] = $excel['wrksheet']->getCellByColumnAndRow($arr_header['month_'.$i], $row)->getCalculatedValue();
		if($arr_temp_header[$i]['amount']=='-'){
			$arr_temp_header[$i]['amount'] = 0;
		}
	}
	return $arr_temp_header;
}

function set_priority_status($status){
	$alphabet = range('a', 'z');
	if(strtolower($status)=='start'){
		return 0;
	}else if(strtolower($status)=='end'){
		return 100;
	}else{
		return array_search(strtolower($status[0]), $alphabet)+1;
	}
}

function last_date_prev_year($date){
    $yr = date('Y', strtotime($date));
    $fdate = $yr-1 . '-12-31';
	return $fdate;
}

function set_priority_status_movement($report,$type){
	$resp = "";
	if($report=='intrakomtabel'){
		switch (strtolower($type)) {
			case 'start':
				$resp = 0;
				return $resp;
			case 'end':
				$resp = 10000;
				return $resp;
		    case 'downgrade':
		    case 'dg':
		        $resp = 1;
		        return $resp;
		        break;
		    case 'upgrade':
		    case 'ug':
		        $resp = 2;
		        return $resp;
		        break;
		    case 'wo':
		    case 'write off':
		    	$resp = 3;
		    	return $resp;
		        break;
		    case 'payment':
		        $resp = 4;
		        return $resp;
		        break;
   		    case 'collection':
		        $resp = 5;
		        return $resp;
		        break;
		    case 'lain plus':
		    case 'up':
		        $resp = 97;
		        return $resp;
		        break;
		    case 'lain minus':
		    case 'down':
		        $resp = 98;
		        return $resp;
		        break;
		    default:
		        return 99;
		}
	}else if($report=='ekstrakomtabel'){
		switch (strtolower($type)) {
			case 'start':
				$resp = 0;
				return $resp;
			case 'end':
				$resp = 10000;
				return $resp;
		    case 'collection':
		    	$resp = 2;
		    	return $resp;
		        break;
		    case 'wo':
		    case 'wo baru':
		    case 'write off baru':
		    case 'tambahan':
		        $resp = 1;
		        return $resp;
		        break;
		    case 'write back':
		        $resp = 3;
		        return $resp;
		        break;
		    case 'adjustment plus':
		    case 'lain plus':
		    case 'up':
		        $resp = 97;
		        return $resp;
		        break;
		    case 'adjustment minus':
		    case 'lain minus':
		    case 'down':
		        $resp = 98;
		        return $resp;
		        break;
		    default:
		        return 99;
		}
	}else if($report=='restru'){
		switch (strtolower($type)) {
			case 'start':
				$resp = 0;
				return $resp;
			case 'end':
				$resp = 10000;
				return $resp;
		    case 'tambahan':
		    case 'tambahan restru':
		        $resp = 1;
		        return $resp;
		        break;
		    case 'collection':
		    	$resp = 2;
		    	return $resp;
		        break;
		    case 'write off':
		    case 'wo':
		    	$resp = 3;
		    	return $resp;
		        break;
		    case 'adjustment plus':
		    case 'lain plus':
		    case 'up':
		        $resp = 97;
		        return $resp;
		        break;
		    case 'adjustment minus':
		    case 'lain minus':
		    case 'down':
		        $resp = 98;
		        return $resp;
		        break;
		    default:
		        return 99;
		}
	}
}

function up_or_down_report($report, $type){
	$resp = "";
	if($report=='intrakomtabel'){
		switch (strtolower($type)) {
		    case 'downgrade':
		    case 'dg':
		        $resp = 'up';
		        return $resp;
		        break;
		    case 'collection':
		    	$resp = 'down';
		    	return $resp;
		        break;
		    case 'upgrade':
		    case 'ug':
		        $resp = 'down';
		        return $resp;
		        break;
		    case 'payment':
		        $resp = 'down';
		        return $resp;
		        break;
		    case 'wo':
		    case 'write off':
		        $resp = 'down';
		        return $resp;
		        break;
		    case 'lain plus':
		        $resp = 'up';
		        return $resp;
		        break;
		    case 'lain minus':
		        $resp = 'down';
		        return $resp;
		        break;
		    default:
		        return 'up';
		}
	}else if($report=='ekstrakomtabel'){
		switch (strtolower($type)) {
		    case 'lain plus':
		        $resp = 'up';
		        return $resp;
		        break;
		    case 'lain minus':
		    	$resp = 'down';
		    	return $resp;
		        break;
		    case 'collection':
		    	$resp = 'down';
		    	return $resp;
		        break;
		    case 'wo':
		    case 'write off':
		    case 'wo baru':
		        $resp = 'up';
		        return $resp;
		        break;
		    case 'write back':
		        $resp = 'down';
		        return $resp;
		        break;
		    default:
		        return 'up';
		}
	}else if($report=='restru'){
		switch (strtolower($type)) {
		    case 'tambahan':
		    case 'tambahan restru':
		        $resp = 'up';
		        return $resp;
		        break;
		    case 'collection':
		    	$resp = 'down';
		    	return $resp;
		        break;
		    case 'wo':
		        $resp = 'down';
		        return $resp;
		        break;
		    case 'adjustment plus':
		    case 'up':
		    case 'lain plus':
		        $resp = 'up';
		        return $resp;
		        break;
		    case 'adjustment minus':
		    case 'down':
		    case 'lain minus':
		        $resp = 'down';
		        return $resp;
		        break;
		    default:
		        return 'up';
		}
	}
}

function clean_filter_title($str){
	$a = str_replace('_',' ', $str);
	return $a;
}

function clean_print_html($str){
	$a = htmlspecialchars(strip_tags($str));
	return $a;
}

function redirect_not_employee(){
	$CI =& get_instance();
	$CI->load->library('session');
	$user= $CI->session->userdata('userdbcisam');
	if($user['is_employee']==0){
		header('Location: '.'/cisam');
	}
}