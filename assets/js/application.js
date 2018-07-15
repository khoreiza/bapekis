function show_sharing_form(id, mosque_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"sharing/show_sharing_form",
        data: {id: id, mosque_id: mosque_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                //$('#modal_finder').html(resp.html);
                //$('#sharing_form_Modal').modal('show');
                show_popup_modal(resp.html);
                $(".loading_panel").hide();
            }else{}
        }
    });
}






function change_customer(type){
    $.ajax({
        type: "GET",
        url: config.base+"customer_files/change_customer_type",
        data: {type: type},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $('#customer_select').html(resp.html);
                $('.selectpicker').selectpicker('refresh');
            }else{}
        }
    });
}



function change_div_component_info(key, div_class){
    $('.'+div_class+'_nav').removeClass('helper_text');
    $('.'+div_class+'_nav').removeClass('active_menu_bar');

    $('.'+div_class+'_nav').addClass('helper_text');
    $('#'+key+'_nav').removeClass('helper_text');
    
    $('#'+key+'_nav').addClass('active_menu_bar');

    $("."+div_class+"_div").hide();
    $("#"+key+"_div").show();
}



function show_page_related_tutorial(uri_string){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"data/show_page_related_tutorial",
        data: {uri_string: uri_string},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
            $(".loading_panel").hide();
        }
    });
}



function show_calendar_form(id,modul,ownership_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"calendar/show_calendar_form",
        data: {id: id, modul: modul, ownership_id: ownership_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
                $(".loading_panel").hide();
            }else{}
        }
    });
}


function adjust_img_size(div, type){
    setTimeout(function(){
        var img = $('#'+div);
        var width = img.width();
        var height = img.height();

        var parent = $('#'+div+"_parent");
        //alert("<?=$sharing->id?> "+width+" "+height);
        if((width > height) || (width/height > 1.6)){
            
            img.height('100%');
            img.width('');

            if(img.width() < parent.width()){
                img.height('');
                img.width('100%');
            }
        }
    }, 400);
}


function list_initiatives_commitment(subordinate, category, cbgroup, cbdept, user_id, status){
    var subordinate = subordinate;
    var category = category;
    var start_date = $('#start_date_filter').val();
    var end_date = $('#end_date_filter').val();
    var cbgroup = cbgroup; if(cbgroup==""){cbgroup = $('#cbgroup_filter').val();}
    var cbdept = cbdept; if(cbdept==""){cbdept = $('#cbdept_filter').val();}
    var user_id = user_id;
    var status = status;

    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"commitment/show_details",
        data: {subordinate: subordinate, category: category, start_date: start_date, end_date: end_date, cbgroup: cbgroup, cbdept: cbdept, user_id: user_id, status: status},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
                $(".loading_panel").hide();
            }else{}
        }
    });

}
function list_activities_commitment(user_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"commitment/show_list_activities_involved",
        data: {user_id: user_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
                $(".loading_panel").hide();
            }else{}
        }
    });

}
function change_broventh_active_page_button(btn_class, btn_id){
    $("."+btn_class).removeClass('btn-third');
    $("."+btn_class).removeClass('btn-first');

    $("."+btn_class).addClass('btn-third');

    $("#"+btn_id).removeClass('btn-third');
    $("#"+btn_id).addClass('btn-first');
}

var loading_sign = "<div class='center_text'>"+
            "<img style='height:40px; margin-bottom:5px;' src="+config.base+"assets/img/loader_images/Preloader_14.gif>"+
            "<div>Loading . . .</div>"+
        "</div>";
function change_form_group_part(form_id){
    $(".form_group_part_div").hide();
    $("#form_group_part_div_"+form_id).show();

    //$(".step_checker").removeClass('use_full_choice_active');
    //$("#step_"+form_id).addClass('use_full_choice_active');
  }


function show_sticky_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"updates/show_sticky_detail",
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
                $(".loading_panel").hide();
            }else{}
        }
    });
}
    
function get_customer_info(){
    var customer = $("#customer").val();
    if(customer){
        $.ajax({
            type: "GET",
            url: config.base+"customer_files/get_customer_info",
            data: {customer: customer, type: 'customer'},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $("#customer_group").val(resp.customer['custgroup_name']);
                    $("#customer_new").val('');
                    $("#customer_group").val(resp.customer['custgroup_name']);
                    $('#kolektabilitas').selectpicker('val', resp.customer['kolektabilitas']);
                    
                    if(!$("#rating").val()){
                        $("#rating").val(resp.customer['customer_rating']);
                    }
                    if(!$("#bidang_usaha").val()){
                        $("#bidang_usaha").val(resp.customer['sector']);
                    }

                    $("#gh_bu").val(resp.pengelola['gh']['full_name']);
                    $("#dh_bu").val(resp.pengelola['dh']['full_name']);
                    $("#cbgroup").val(resp.department['group_name']);
                    $("#cbdept").val(resp.department['dept_name']);
                    $("#buc").val(resp.customer['buc']);
                }else{}
            }
        });
    }
}

function take_screenshot(div,is_print) {
  // First render all SVGs to canvases
    var svgElements= $("#"+div).find('svg');

    //replace all svgs with a temp canvas
    svgElements.each(function () {
    var canvas, xml;

     canvas = document.createElement("canvas");
     canvas.className = "screenShotTempCanvas";
     //convert SVG into a XML string
     xml = (new XMLSerializer()).serializeToString(this);

     // Removing the name space as IE throws an error
     xml = xml.replace(/xmlns=\"http:\/\/www\.w3\.org\/2000\/svg\"/, '');

     //draw the SVG onto a canvas
     canvg(canvas, xml);
     $(canvas).insertAfter(this);
     //hide the SVG element
     this.className = "tempHide";
     $(this).hide();
    });

    html2canvas($("#"+div), {
         allowTaint: true,
         onrendered: function (canvas) {
             var myImage = canvas.toDataURL("image/pdf");
             var tWindow = window.open(""); 
             var div_width = $("#"+div).width();
             $(tWindow.document.body).html("<img id='Image' src=" + myImage + " style='width:"+div_width+";'></img>").ready(function () {
                tWindow.focus();
                
                if(is_print){
                    setTimeout(function(){tWindow.print();}, 1500);
                }

                $(".screenShotTempCanvas").hide();
                
                svgElements.each(function () {
                    $(this).show();
                });
             });
         }
    });
    //location.reload();
}

function make_qrcode(div, value) {      
    new QRCode(div, {
        text: value,
        width: 105,
        height: 105,
        colorDark : "#000000",  
        colorLight : "#ffffff"
    });
}

function auto_complete(id,type){
    var resp = config.base+"search/get_suggestion/"+type;
    var arr = [];   
    var resArray = [];
    $.getJSON(resp, function(result){
        $.each( result, function( key, value ) {arr[key] = value.val;});
        resArray = $.map(arr, function (value, key) { return { value: value, data: key }; });

        // Initialize ajax autocomplete:
        $(id).autocomplete({
            //serviceUrl: '/autosuggest/service/url',
            lookup: resArray,
            lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
        });
    });
}

function fill_user_options(div){
    var options = {
        ajax          : {
            url     : config.base+"user/search_user_select",
            type    : 'POST',
            dataType: 'json',
            // Use "{{{q}}}" as a placeholder and Ajax Bootstrap Select will
            // automatically replace it with the value of the search query.
            data    : {
                q: '{{{q}}}',
            }
        },
        locale        : {
            emptyTitle: 'Select User...'
        },
        log           : 3,
        preprocessData: function (data) {
            var i, l = data.length, array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text : data[i].full_name,
                        value: data[i].id,
                        data : {
                            subtext: ''
                        }
                    }));
                }
            }
            // You must always return a valid array when processing data. The
            // data argument passed is a clone and cannot be modified directly.
            return array;
        }
    };
    console.log(options);
    $('#'+div).selectpicker().filter('.with-ajax').ajaxSelectPicker(options);
    $('#'+div).trigger('change');
}

function fill_customer_options(type){
    var options = {
        ajax          : {
            url     : config.base+"customer_group/search_customer_select",
            type    : 'POST',
            dataType: 'json',
            // Use "{{{q}}}" as a placeholder and Ajax Bootstrap Select will
            // automatically replace it with the value of the search query.
            data    : {
                q: '{{{q}}}',type: type,
            }
        },
        locale        : {
            emptyTitle: 'Select Customer...'
        },
        log           : 3,
        preprocessData: function (data) {
            var i, l = data.length, array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text : data[i].customer,
                        value: data[i].customer,
                        data : {
                            subtext: ''
                        }
                    }));
                }
            }
            // You must always return a valid array when processing data. The
            // data argument passed is a clone and cannot be modified directly.
            return array;
        }
    };
    console.log(options);
    $('#customer').selectpicker().filter('.with-ajax').ajaxSelectPicker(options);
    $('#customer').trigger('change');
}

function submit_comment(ownership_id, type, kind, modul, sub_modul, is_rich_text){
    var modul_id = modul;

    /******* CHAT TO DEPT ********/
    var chat_to_dept = $("#chat_to_dept").val();

    var comment_text_form = $( "#comment");
    var comment_list = $('#comment_list');
    if(kind == "id"){
        comment_text_form = $( "#comment_"+ownership_id);
        comment_list = $('#comment_list_'+ownership_id);
    }
    
    var comment = comment_text_form.val();
    var view_comment = $( "#view_comment").val();
	var role = $( "#role").val();
    //alert(comment);
    $.ajax({
        type: "POST",
        url: config.base+"comment/store",
        data: {comment:comment, ownership_id: ownership_id, ownership_type: type, kind: kind, modul: modul, sub_modul: sub_modul, view_comment: view_comment, role: role},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                //console.log('c'+comment);console.log('t'+type);console.log('k'+kind);console.log('m'+modul);console.log('s'+sub_modul);console.log('oid'+ownership_id);
                comment_list.html(resp.comment_list);
                comment_text_form.val('');
                if(type == "audit"){
                    $('#comment_form').html("<textarea onfocus=\"actived_summernote('comment');\" type=\"text\" class=\"form-control-borderless\" name=\"comment\" id=\"comment\" placeholder=\"Add Comment\"></textarea>");

                }
				if(role == "General"){
                    $('#comment_textarea').html("<textarea onfocus=\"actived_summernote('comment');\" class=\"form-control\" id=\"comment\"  style=\"height:50px; font-size: 12px; resize: none; border-bottom-right-radius: 0; border-bottom-left-radius: 0;\"><b>To </b>: <br /><b>Message </b>: <br /></textarea>");

                }
                else if(is_rich_text){
                    $('#comment_textarea').html("<textarea onfocus=\"actived_summernote('comment');\" class=\"form-control\" id=\"comment\"  style=\"height:50px; font-size: 12px; resize: none; border-bottom-right-radius: 0; border-bottom-left-radius: 0;\"></textarea>");
                }

            }else{}
        }
    });
}

function show_comment_popoup(ownership_id, ownership_type, kind, modul, sub_modul){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"comment/show_comment_popup",
        data: {ownership_id: ownership_id, ownership_type: ownership_type, kind: kind, modul: modul, sub_modul: sub_modul},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function show_crs_detail(id){
    $.ajax({
        type: "GET",
        url: config.base+"compliance/show_crs_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function show_category_form(id,menu,submodul){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"category/show_form",
        data: {id: id, menu: menu, submodul: submodul},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
                $(".loading_panel").hide();
            }else{}
        }
    });
}

function show_video_form(id,page){
    $.ajax({
        type: "GET",
        url: config.base+"tube/show_video_form",
        data: {id: id,page: page},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function show_video_category_form(id){
    $.ajax({
        type: "GET",
        url: config.base+"tube/show_category_form",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function delete_tube(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"tube/delete_video",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                    $('#my_vid_'+id).animate({'opacity':'toggle'});
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function show_ces_customer(customer_group){
    $.ajax({
        type: "GET",
        url: config.base+"customer_files/get_detail_ces_custgroup",
        data: {custgroup: customer_group},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function to_customer_page(name,type){
    if(type == "customer_group"){type="group";}
    $.ajax({
        type: "POST",
        url: config.base+"customer_group/to_customer_page",
        data: {name: name, type: type},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                window.location.href = resp.link;
            }else{}
        }
    });
}

function show_group_companies(cust_group){
    $("#loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"customer_group/show_group_companies",
        data: {cust_group: cust_group},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
                $("#loading_panel").hide();
            }else{}
        }
    });
}
function get_task_update(id){
    $.ajax({
        type: "GET",
        url: config.base+"fourdx/show_task_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function show_external_link(){
    $.ajax({
        type: "GET",
        url: config.base+"home/show_external_link",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function show_form_files(file_modul,file_submodul,id,ownership_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"file/show_form_files",
        data: {file_modul: file_modul, file_submodul: file_submodul,id: id, ownership_id: ownership_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function show_form_ces(id,page){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"myreport/show_form_myreport",
        data: {id: id,page: page},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function see_all_files(modul,submodul,ownership_id){
    $(".loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"file/see_all_file",
        data: {modul: modul, submodul: submodul, ownership_id: ownership_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
                $(".loading_panel").hide();
            }else{}
        }
    });
}
    
function get_dept(group){
    if(!group){$("#dept_select").html("<div style='text-align:center; color:#838383; padding-top:8px;'>No Group Selected</div><input type='hidden' value='' id='dept_filter'>");}
    else{
        $.getJSON(
            config.base+"user/get_cbdept_by_cbgroup",
            {
                cbgroup: group
            },
            function(data, status, xhr){
                var items = ''; var opt = ''; 
                if(status=="success"){
                    opt = "<option value=''>-- All Dept--</option>"
                    $.each( data.results, function( key, val ) {
                        opt = opt+"<option value='"+val.buc+"'>"+val.dept_name+"</option>";
                    });
                    items='<select class="selectpicker show-tick form-control" data-live-search="true" data-width="100%" onchange="filter_data();" id="dept_filter" name="dept_filter">'+opt+'</select>';
                    $("#dept_select").html(items);
                }else{
                    
                    $("#dept_select").html("");
                }
                $('.selectpicker').selectpicker('refresh');
            }
        );
    }
}

function insert_task_fourdx(category,id){
    $.ajax({
        type: "GET",
        url: config.base+"fourdx/input_task",
        data: {category: category,id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.html);
            }else{}
        }
    });
}

function show_input_form(id,page,submodul, ownership_id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"file/show_input_form",
        data: {id: id,page: page, submodul: submodul, ownership_id: ownership_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               $(".loading_panel").hide();
               show_popup_modal(resp.html);
            }else{}
        }
    });
}

function delete_news(id,type){
$.confirm({
    title: 'Apa anda yakin?',
    content: '',
    confirmButton: 'Ya',
    confirm: function(){  
      $.ajax({
        type: "GET",
        url: config.base+"file/delete_news",
        data: {id:id, type:type},
        dataType: 'json',
        cache: false,
        success: function(resp){
          console.log(resp);
          if(resp.status==true){
            //$('#mysharing_'+id).animate({'opacity':'toggle'});
              $('#popup_Modal').modal('hide');


              $('#news_content_'+id).animate({'opacity':'toggle'});

              if(type=='compliance'){
                  location.reload(config.base+"compliance/index");
              }
              else if(type=='market'){
                  location.reload(config.base+"market/outlook");
              }
              else if(type=='product_knowledge'){
                  //location.reload(config.base+"product_knowledge/index");
                  $('#pknews_'+id).animate({'opacity':'toggle'});
              }
              else if(type=='hr'){
                  location.reload(config.base+"hr"); 
              }
              else if(type=='competition'){
                  location.reload(config.base+"competition"); 
              }
          }else{
              console.log('action after failed');
          }
        }
      });
    },
});
}

function vote_news(id,type){
$.confirm({
    title: 'Apa anda yakin?',
    content: '',
    confirmButton: 'Ya',
    confirm: function(){  
      $.ajax({
        type: "GET",
        url: config.base+"file/vote_news",
        data: {id:id, type:type},
        dataType: 'json',
        cache: false,
        success: function(resp){
          console.log(resp);
          if(resp.status==true){
            //$('#mysharing_'+id).animate({'opacity':'toggle'});
              $('#popup_Modal').modal('hide');


              $('#news_content_'+id).animate({'opacity':'toggle'});

              if(type=='compliance'){
                  location.reload(config.base+"compliance/index");
              }
              else if(type=='market'){
                  location.reload(config.base+"market/outlook");
              }
              else if(type=='product_knowledge'){
                  //location.reload(config.base+"product_knowledge/index");
                  $('#pknews_'+id).animate({'opacity':'toggle'});
              }
              else if(type=='hr'){
                  location.reload(config.base+"hr"); 
              }
              else if(type=='competition'){
                  location.reload(config.base+"competition"); 
              }
          }else{
              console.log('action after failed');
          }
        }
      });
    },
});
}

function show_rm(cust_id,cust){
    $.ajax({
        type: "GET",
        url: config.base+"customer_group/show_rm",
        data: {id: cust_id,cust: cust},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               $('#rm_customer_'+resp.id).html(resp.html);
               //show_popup_modal(resp.html);
            }else{}
        }
    });
}
    
function show_calendar_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"calendar/get_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.message);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_quote_of_the_day(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"updates/show_quote_of_the_day",
        dataType: 'json',
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.html);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_market_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"market/get_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.message);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_news_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"file/show_news_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.html);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_pk_news_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"product_knowledge/get_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.message);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_compliance_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"compliance/get_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.message);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_hr_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"hr/get_detail_hr",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.message);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_mysharing_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"sharing/show_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.html);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_user_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"hr/show_user_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $(".loading_panel").hide();

            if(resp.status==1){
                show_popup_modal(resp.html);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_popup_modal(resp){
    $('#popup_Modal').modal('hide');
    setTimeout(function(){
        $('#modal_finder').html(resp);
        $('.selectpicker').selectpicker('refresh');
        $('#popup_Modal').modal('show');
        $('[data-toggle="tooltip"]').tooltip();
    }, 500);
}

function show_popup_modal_static(resp){
    $('#popup_Modal').modal('hide');
    setTimeout(function(){
        $('#modal_finder').html(resp);
        $('.selectpicker').selectpicker('refresh');
        $('#popup_Modal').modal({backdrop: 'static', keyboard: false});
        $('[data-toggle="tooltip"]').tooltip();
    }, 500);
}

function show_popup_modal_no_div(resp,width){
    $('#popup_Modal').modal('hide');
    setTimeout(function(){
        $('#modal_finder').html(
            '<div class="modal fade" id="popup_Modal" tabindex="-13" role="dialog" aria-labelledby="myModalLabel">'+
                '<div class="modal-dialog" role="document" style="width:'+width+'%;">'+
                    '<div class="modal-content">'+
                       '<div class="modal-body">'+
                           '<div>'+
                               '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                           '</div>'+
                           resp+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'
        );
        $('.selectpicker').selectpicker('refresh');
        $('#popup_Modal').modal('show');
    }, 500);
}


function actived_summernote(id){
    $('#'+id).summernote({
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New','San Francisco','titillium','Times New Roman','Verdana']
    });
}

function delete_files_upload_div(id,div){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"file/delete_file",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $('#'+div+"_"+resp.file_id).animate({'opacity':'toggle'});
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function delete_files_upload(id){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"file/delete_file",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $('.file_'+resp.file_id).animate({'opacity':'toggle'});
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function delete_files_only_div(id,div){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"file/delete_file_only",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $('#'+div+"_"+resp.file_id).animate({'opacity':'toggle'});
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function delete_files_with_db_div(id,div){
    $.confirm({
        title: 'Apa anda yakin?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
            type: "GET",
            url: config.base+"file/delete_file_only_with_db",
            data: {id: id,div:div},
            dataType: 'json',
            cache: false,
            success: function(resp){
              console.log(resp);
              if(resp.status==true){
                $('#'+div+"_"+resp.file_id).animate({'opacity':'toggle'});
              }else{
                  console.log('action after failed');
              }
            }
          });
        },
    });
}

function fade_out_div(div){
    $('#'+div).animate({'opacity':'toggle'});
}

function menu_choice(choice){
    $.ajax({
        type: "GET",
        url: config.base+"home/menu_choice",
        data: {choice:choice},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                bootbox.dialog({
                    backdrop: true,
                    title: resp.title,
                    message: resp.message,
                        
                });
            }else{}
        }
    });
}

function ucwords_js(str) {
    str = str.toLowerCase();
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}
/*$(document).on('click', '.bootbox', function(){
    var classname = event.target.className;

    if(classname && !$('.' + classname).parents('.modal-dialog').length)
        bootbox.hideAll();
});*/

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function please_wait_msg(dom){
    $("#"+dom).html('Please wait. . .<br><img src='+config.base+'assets/img/general/loading.gif>');
}
var RESIZEABLE_CANVAS=true;

function toggle_visibility(id) {
    $('#'+id).animate({'height':'toggle','opacity':'toggle'});
}
function toggle_visibility_class(class_name) {
    $('.'+class_name).animate({'height':'toggle','opacity':'toggle'});
}
function toggle_visibility_cart(id) {
    if (!$('#'+id).is(":visible")){
    $('#'+id).show();}
    else{
        $('#'+id).hide();
    }
    //$($('#'+id)).animate({'height':'toggle','opacity':'toggle'});
    if($('#cart_header').hasClass('active')){$('#cart_header').removeClass('active');}
    else{$('#cart_header').addClass('active');}
}

function succeedMessage(msg){
    $('#succeed-message').text(msg);
    $('#succeed').animate({'height':'toggle','opacity':'toggle'});
    window.setTimeout( function(){$('#succeed').slideUp();}, 2500);   
}

function succeedMessageOwn(msg,div,label){
    $(label).text(msg);
    $(div).animate({'height':'toggle','opacity':'toggle'});
    window.setTimeout( function(){$(div).slideUp();}, 2500);   
}

function CKupdate(){
    CKEDITOR.instances.editor108.getData();
}

var fund_color="#007aff";
var fund_negative_color="#ffcc00";
var credit_color="#007aff";
var credit_negative_color="#ffcc00";
var url = window.location.pathname;
var url_arr = url.split("/");
var target_color="#c3c3c3";
var negative_color="#ffcc00";
var cbic_color="#189cb8";

function long_text_real(string,char){
    var words = string.substr(0,char); 
    if(string.length > char){words = words+" ...";}
    return words;
}

function currency_format(value){
    if(value>=0){
        return get_satuan(value);
    }else{
        return "-"+get_satuan(Math.abs(value));
    }
}

function get_bhd_comma(percentage){
    if((Math.abs(percentage)<10) && (Math.abs(percentage)>0.1)){return 1;}
    else if((Math.abs(percentage)>1) || Math.abs(percentage)==0 || (Math.abs(percentage)==1)){return 0;}
    else if(Math.abs(percentage)<0.1){return 2;}
}

function get_bhd_comma_val(value){
    if((Math.abs(value)<100) && (Math.abs(value)>10)){return 1;}
    else if(Math.abs(value)<10){return 2;}
    else {return 0;}
}

function get_show_number(value){
    if(Math.abs(value)>1000000000000){
        return value/1000000000000;
    }
    else if(Math.abs(value)>1000000000){
        return value/1000000000;
    }
    else if(Math.abs(value)>1000000){
        return value/1000000;
    }
    else{
        return value;
    }
}

function get_satuan(value){
    if(value >= 1000000000000){
        value = value/1000000000000;
        return addCommas((value).toFixed(get_bhd_comma_val(value)))+" T";
    }else if(value >= 1000000000){
        value = value/1000000000;
        return addCommas((value).toFixed(get_bhd_comma_val(value)))+" M";
    }else if(value >= 1000000){
        value = value/1000000;
        return addCommas((value).toFixed(get_bhd_comma_val(value)))+" Jt";
    }else if(value>0){
        return addCommas((value).toFixed(get_bhd_comma_val(value)));
    }
    else{
        return "-";
    }
}

function get_show_number_satuan(value){
    if(Math.abs(value)>1000000000000){
        return "T";
    }
    else if(Math.abs(value)>1000000000){
        return "M";
    }
    else if(Math.abs(value)>1000000){
        return "Jt";
    }
    else{
        return "";
    }
}

function get_show_number_satuan_full(value){
    if(Math.abs(value)>1000000000000){
        return "Triliun";
    }
    else if(Math.abs(value)>1000000000){
        return "Miliar";
    }
    else if(Math.abs(value)>1000000){
        return "Juta";
    }
    else{
        return "";
    }
}

/**
* ACTION STEP
*/

function show_form_activity_step(parent_object_id, page_type, array_param){
    var page_type = page_type;
    var parent_object_id = parent_object_id;
    var function_after = "refreshFilterPage();";
    var data = {
        parent_object_id : parent_object_id,
        page_type : page_type
    }

    //console.log('testing');
    if(page_type=='account_plan'){
        var obj = JSON.parse(array_param);
        data.customer_group = obj.customer_group;
    }
    //console.log(data);

    $.ajax({
        type: "POST",
        url: config.base+"activity_step/show_form",
        data: data,
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
               show_popup_modal(resp.html);
            }else{}
        }
    });
}

function add_form_as(){
        $.ajax({
            type: "GET",
            url: config.base+"activity_step/show_form_as",
            data: {id: null},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status==1){
                    $('#action_step_form').append(resp.message);
                    $('.selectpicker').selectpicker('refresh');
                }else{
                
                }
                
                $('.datepick').datepicker({dateFormat:"mm/dd/yy",
                                autoclose: true,
                                todayHighlight: true,
                                format: 'd M yy'});
            }
        });
}

function editActivityStep(id){
    $("#as_form").show();
    $("#box_list_of_childs").hide();
    if(id){
        $("#list_of_activities_div").hide();
        $.ajax({
            type: "POST",
            url: config.base+"activity_step/get_activity_detail",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                var data = resp[0];
                $("#act_id").val(data.id);
                $("#activity").val(data.activity);
                $("#deadline").val(data.deadline);
                $("#user_pic").val(data.user_pic);
                $("#as_status").val(data.status);
                $("#parent_act").val(data.parent_id);
                $('.selectpicker').selectpicker('refresh');

                $("#progress").val('');
                //$("#form_group_progress").hide();
            }
        });
    }
    else{
        setTimeout(function(){ 
            $("#activity").val("");
            $("#user_pic").val("");
            $("#as_status").val("");
            $("#act_id").val("");
            $('.selectpicker').selectpicker('refresh');

            $("#progress").val('');
            $("#form_group_progress").show();

        }, 300);
        
    }
}
    
function deleteActivityStep(id){
    $.confirm({
        title: 'Hapus activity step?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){
            delete_the_activity_step(id);
        },
    });
}

function delete_the_activity_step(id){
    $.ajax({
        type: "POST",
        url: config.base+"activity_step/deleteActivityStep",
        data: {id: id},
        dataType: 'html',
        cache: false,
        success: function(resp){
            refresh_activities_sidebar();
            toggle_visibility('activity_div_'+id);
            //resetAllActivity();
        }
    });
}

function add_subtask(){
    var call_report_id = $("#call_report_id").val();
    var act_id = $("#act_id").val();
    var activity = $("#activity").val();
    var user_pic = $("#user_pic").val();
    var deadline = $("#deadline").val();
    var as_status = $("#as_status").val();
    var parent_act = $("#parent_act").val();
    var parent_text = $("#parent_act option:selected").text();
    //alert(parent_text);
    if(!activity){
        alert("Please fill activity step");
        $("#activity").focus();
        return false;
    }
    if(!user_pic){
        alert("Please choose PIC");
        $("#user_pic").focus();
        return false;
    }
    if(!deadline){
        alert("Please pick deadline");
        $("#deadline").focus();
        return false;
    }
    if(parent_act){
        //checkprogres
        $.ajax({
            type: "POST",
            url: config.base+"activity_step/check_action_progress",
            data: {parent_act:parent_act},
            dataType: 'html',
            cache: false,
            success: function(resp){
                /*if(resp=="nok"){
                    $.confirm({
                        title: 'Pada action step '+parent_text.trim()+' sudah ada progress, apakah akan di replace?',
                        content: '',
                        confirmButton: 'Ya',
                        confirm: function(){  
                           insertActivityStep();
                        },
                    });
                }
                else{
                    insertActivityStep();
                }*/
                insertActivityStep();
            }
        });
    }
    else{
        insertActivityStep();
    }
    
}

function insertActivityStep(){
    $(".loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"activity_step/save_action_step",
        data: $("#activity_form").serialize(),
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status == 1){
                //alert("Activity Steps berhasil di input");
                $("#act_id").val("");
                $("#activity").val("");
                $("#user_pic").val("");
                $("#as_status").val("");
                //$("#parent_act").val("");
                
                $("#as_form").hide();
                refresh_activities_sidebar();
                $("#activities_sidebar_div").html("<h4 class='center_text third_font' style='padding:10px;'>Loading . . .</h4>");

                if(resp.popup == "true"){
                    show_activity_detail(resp.parent_id);
                }

                $("#box_list_of_childs").show();

                $("#general_info_div").html(resp.general_info);
                $("#list_of_childs_div").html(resp.list_of_childs);
                
                $(".loading_panel").hide(); 
            }
            if(resp.status == 0){
                alert("Input gagal, tidak dapat menambahkan activity step jika udah ada proses di dalam nya");
            }
        }
    });
}
    
function resetAllActivity(){
    var parent_object_id = $("#parent_object_id").val();
    var page_type = $("#page_type").val();
    $.ajax({
        type: "POST",
        url: config.base+"activity_step/getActivityList",
        data: {id: parent_object_id,source_type:page_type},
        dataType: 'html',
        cache: false,
        success: function(resp){
            var html_var = resp.split('#####');
            $("#ParentActivity").html(html_var[0]);
            $("#action_step_list").html(html_var[1]);
        }
    });
}






/************************* MY NEW ACTIVITY STEP FUNCTION ************************/
function refresh_activities_sidebar(){
    var parent_object_id = $("#parent_object_id").val();
    var page_type = $("#page_type").val();
    var source_date = $("#source_date").val();
    $.ajax({
        type: "POST",
        url: config.base+"activity_step/refresh_activities_sidebar",
        data: {parent_object_id: parent_object_id, page_type: page_type, source_date: source_date},
        dataType: 'json',
        cache: false,
        success: function(resp){
            $("#activities_sidebar_div").html(resp.html);
        }
    });
}

function refresh_progress_list(){
     var act_id = $("#activit_id").val();
     $.ajax({
        type: "POST",
        url: config.base+"activity_step/refresh_progress_list",
        data: {action_step_id: act_id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            //resetAllActivity();
            $("#list_of_progress_div").show();
            $("#list_of_progress_div").html(resp.html);
        }
    });
}

function show_activity_detail(id){
    $(".loading_panel").show();
    $.ajax({
        type: "POST",
        url: config.base+"activity_step/show_activity_detail",
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $(".loading_panel").hide();
                show_popup_modal(resp.html);
            }else{
            }
        }
    });
}

/************************* END OF MY NEW ACTIVITY STEP FUNCTION ************************/










function addProgress(){
    var progress = $("#progress_form_input").val();
    if(!progress){
        alert("Please fill action progress");
        $("#progress").focus();
        return false;
    }
    $.ajax({
        type: "POST",
        url: config.base+"activity_step/saveProgress",
        data: $("#progress_form").serialize(),
        dataType: 'html',
        cache: false,
        success: function(resp){
            if(resp){
                //alert("Data progress sukses di simpan");
                $("#progress").val("");
                $("#pg_status").val("");
                $("#pg_id").val("");
                $("#pg_form").hide();

                $("#list_of_progress_div").html("<h4 class='center_text third_font' style='padding:10px;'>Loading . . .</h4>");
                refresh_progress_list();
                refresh_activities_sidebar();
                refresh_activity_last_progress(resp);
            }
            else{
                alert("Input data error");
            }
        }
    });
    
}

function refresh_activity_last_progress(id){
    if(id){
        $.ajax({
            type: "POST",
            url: config.base+"activity_step/getActivityLastProgress",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                if(resp.status == 1){
                    $("#progress_for_act_"+id).html(resp.progress.progress);
                    $("#progress_date_for_act_"+id).html(resp.progress_date);
                    //$("#list_of_progress_div").html("<h4 class='center_text third_font' style='padding:10px;'>Loading . . .</h4>");
                }
            }
        });
    }
}

function editProgress(id){
    $("#pg_form").show();
    if(id){
        $.ajax({
            type: "POST",
            url: config.base+"activity_step/getProgressDetail",
            data: {id: id},
            dataType: 'json',
            cache: false,
            success: function(resp){
                var data = resp[0];
                $("#progress_form_input").val(data.progress);
                //$("#pg_status").val(data.status);
                $("#pg_id").val(data.id);
                $("#list_of_progress_div").hide();
            }
        });
    }
    else{
        $("#progress").val("");
        $("#pg_status").val("");
        $("#pg_id").val("");
        $("#savePGBtn").html("<span>Save</span>");
    }
}

function deleteProgress(id){
    $.confirm({
        title: 'Apakah Anda Yakin ?',
        content: '',
        confirmButton: 'Ya',
        confirm: function(){  
          $.ajax({
                type: "POST",
                url: config.base+"activity_step/deleteProgress",
                data: {id: id},
                dataType: 'html',
                cache: false,
                success: function(resp){
                    toggle_visibility('progress_div_'+id)
                    refresh_progress_list();
                    refresh_activities_sidebar();
                }
            });
        },
    });
}

function resetProgress(){
     var act_id = $("#cur_act_id").val();
     $.ajax({
        type: "POST",
        url: config.base+"activity_step/resetProgress",
        data: {id: act_id},
        dataType: 'html',
        cache: false,
        success: function(resp){
            //resetAllActivity();
            $("#pg_table").html(resp);
        }
    });
}

function viewActivityStep(id,page_id){
    var parent_object_id = $("#parent_object_id").val();
    var page_type = "call_report";
    $.ajax({
        type: "POST",
        url: config.base+"activity_step/show_activity_detail",
        data: {id: id,cur_id:parent_object_id,page_type:page_type},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                show_popup_modal(resp.message);
                $(".btacclose").click();
                $(".btpgview").click(function(){
                    showDetailPage(page_id,page_type);
                });
            }else{
            }
        }
    });
}

/**
*   News
*/ 

function isUrlExists(url, cb){
    jQuery.ajax({
        url:      url,
        dataType: 'text',
        type:     'GET',
        complete:  function(xhr){
            if(typeof cb === 'function')
               cb.apply(this, [xhr.status]);
        }
    });
}


function change_news_page(offset, length, modul, submodul){
    $("#loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base+"account_planning/update_news",
        data: {offset:offset, length: length, modul:modul, submodul:submodul},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==1){
                $("#list_news_views_div").html(resp.html);
                $("#loading_panel").hide();
            }else{}
        }
    });
}

function my_img_error(image){
    image.onerror = "";
    image.src = config.base+"/assets/img/general/profile.gif"; // assets/img/general/profile.gif
    return true;
}

function my_photo(profile_picture, nik){
    var url = ''; var link_img = '';
    if(profile_picture===null || profile_picture==''){
        url = config.base+"/assets/uploads/user_photo/thumb/"+nik+".jpg_thumbnail.jpg";

        // isUrlExists(url, function(status){
        //     if(status === 404){
        //        // 404 not found
        //        url = config.base+"/assets/img/general/profile.gif";
        //     }
        // });
        
    }else if(profile_picture=='activity_steps'){
        url = config.base+'/assets/img/icon/to do - office.png';
    }else{
        var arr_pp = profile_picture.split("/");
        url = config.base+'/assets/uploads/user_profile/thumb/'+arr_pp[arr_pp.length-1]+'_thumbnail.jpg';
    }
    link_img = "<img style='width:100%; margin:0 auto; margin-top:-1px; margin-left:0px;' src='"+url+"' onerror='my_img_error(this);'>";
    return link_img;
}

function get_relative_url(absolute_url){
    var arr = absolute_url.split("/");
    var rel_url = '';
    if(arr && arr.length){
        arr.splice(0,4);
        arr.forEach(function(el){
            if(arr[arr.length-1]==el){
                rel_url = rel_url + el; 
            }else{
                rel_url = rel_url + el + '/';    
            }
        });
    }
    return rel_url;
}


function check_session(){
    $.ajax({
        type: "GET",
        url: config.base+"mysession/check",
        data: {},
        dataType: 'json',
        cache: false,
        success: function(resp){
            if(resp.status==0){
                window.location.replace("user/login");
                socket_logout();
            }
        }
    });
}

function logout(){
    socket_logout();
    var url = config.base + 'user/logout';
    window.location.replace(url);
}