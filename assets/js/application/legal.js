function change_legal_view(div) {
    $(".legal_view").hide();
    $(".legal_" + div).show();
    $(".btn-legal-view").removeClass('active');
    $(".btn-legal-" + div).addClass('active');
}

function change_legel_menu(menu){
    $(".btn-legal-menu").removeClass('btn-third');
    $(".btn-legal-menu").removeClass('btn-first');

    $(".btn-legal-menu").addClass('btn-third');

    $("#btn-menu-"+menu).removeClass('btn-third');
    $("#btn-menu-"+menu).addClass('btn-first');
}

function show_filter(type){
    $(".loading_panel").show();
    //var data = $(".filter_advis_request").serializeArray();
    $.ajax({
        type: "GET",
        url: config.base + "legal/show_filter",
        cache: false,
        success: function(resp) {
            $(".loading_panel").hide();
            if(resp.status==1) {
                $("#legal_operating_filter").html(resp.html);
                if($('.selectpicker').removeClass('hide'))
                if(type=='first_load'){
                    get_list_advis('','first_load','');
                }
                $('.selectpicker').selectpicker('refresh');
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function get_list_advis(status,type,text,page) {
    var data = {};
    //data.push({ name: "status", value: status});
    data.start_date = $('#start_date').val();
    data.end_date = $('#end_date').val();
    data.media = $('#media').val();
    data.category = $('#category').val();
    data.group = $('#group').val();
    data.officer_id = $('#officer_id').val();
    data.status = status;

    if(text!==''){
        data.title = text;
    }
    $("#loading_panel").show();

    var url = '';
    if(page==''){
        var page = $('#active_page').val();
    }

    if(page=='summary'){
        url = config.base + "legal/get_advis_analysis";
    }else{
        url = config.base + "legal/get_list_advis";
    }
    //console.log(data);
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: 'json',
        cache: false,
        success: function(resp) {
            if (resp.status) {
                if(page=='summary'){
                    $("#list_advis_operating").html(resp.html);
                    change_legel_menu("summary");
                    $('#active_page').val('summary');
                }else{
                    $("#list_advis_operating").html(resp.html);
                    change_legel_menu("list");
                    $('#active_page').val('list');
                }
            }
            if(type != "first_load"){
                $(".hide_card").show();
            }

            if(resp.view_member_status){
                $("#legal_member_status").html(resp.view_member_status);
            }
            $("#loading_panel").hide();
        },
        error: function(resp) {
            $("#loading_panel").hide();
        }
    });
}

function show_add_advis(page_type) {
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base + "legal/add_advis",
        data: { page_type: page_type },
        dataType: 'json',
        cache: false,
        success: function(resp) {
            $(".loading_panel").hide();

            if (resp.status == "success") {
                show_popup_modal(resp.html);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_edit_advis(advis_id,type) {
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base + "legal/add_advis/" + advis_id,
        data: { page_type: "admin", form_type: type },
        dataType: 'json',
        cache: false,
        success: function(resp) {
            $(".loading_panel").hide();
            if (resp.status == "success") {
                show_popup_modal(resp.html);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_disposition_advis(advis_id) {
    $(".loading_panel").show();
    $.ajax({
        type: "GET",
        url: config.base + "legal/disposition_advis/" + advis_id,
        dataType: 'json',
        cache: false,
        success: function(resp) {
            $(".loading_panel").hide();

            if (resp.status == "success") {
                show_popup_modal(resp.html);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function show_detail_analysis(group,category,media,officer_id,complexity,status) {
    var data = {};
    //data.push({ name: "status", value: status});

    data.start_date = $('#start_date').val();
    data.end_date = $('#end_date').val();
    if(media!==null){
        if(media==''){
            data.media = $('#media').val();    
        }else{
            data.media = media;
        }    
    }
    if(category!==null){
        if(category==''){
            data.category = $('#category').val();
        }else{
            data.category = category;
        }    
    }
    if(group!==null){
        if(group==''){
            data.group = $('#group').val();    
        }else{
            data.group = group;
        }    
    }
    if(officer_id!==null){
        if(officer_id==''){
            data.officer_id = $('#officer_id').val();    
        }else{
            data.officer_id = officer_id;   
        }
    }
    if(complexity!==null){
        if(complexity==''){
            data.complexity = $('#complexity').val();    
        }else{
            data.complexity = complexity;   
        }
    }
    if(status!==null){
        data.status = status;
    }

    console.log(status);
    
    $(".loading_panel").show();
    $.ajax({
        data: data,
        type: "POST",
        url: config.base + "legal/get_detail_analysis/",
        dataType: 'json',
        cache: false,
        success: function(resp) {
            $(".loading_panel").hide();
            if (resp.status == 1) {
                show_popup_modal(resp.html);
            }
        },
        error: function() {
            $(".loading_panel").hide();
        }
    });
}

function search_advis(){
    var value = $('#search_filter').val();
    var active_page = $('#active_page').val();
    if(active_page=='list'){
        get_list_advis('','',value,'list');
    }
}

/*$('#search_filter').keyup(function(){
    var value = $('#search_filter').val();
    var active_page = $('#active_page').val();
    if(active_page=='list'){
        get_list_advis('','',value,'list');
    }
});*/