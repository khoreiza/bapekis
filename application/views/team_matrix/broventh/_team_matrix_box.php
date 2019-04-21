<?php 
    $user = $this->session->userdata('userdb');
    $modul_team=""; $sub_modul_team=""; $category_team=""; $ownership_id_team="";
    

    if(isset($ownership_id)) $ownership_id_team = $ownership_id;
    if(isset($category)) $category_team = $category;
    if(isset($modul)) $modul_team = $modul;
    if(isset($sub_modul)) $sub_modul_team = $sub_modul;

?>
<div>
    <div class="square_box_body" style="">
        <div class="right_text">
            <a onclick="show_team_matrix_form('');" class="btn btn-broventh btn-circle btn-first" style="height: 20px; width: 20px; font-size: 10px; padding: 3px 0 0 1px; margin-right: 3px;"><span class="glyphicon glyphicon-plus"></span></a>
            <a onclick="toggle_visibility_class('delete_button');" class="btn btn-broventh btn-circle btn-first" style="background-color:<?=array_color_new(4)?>; height: 20px; width: 20px; font-size: 10px; padding: 3px 0 0 0px;"><span class="glyphicon glyphicon-trash"></span></a>
        </div>
        <div id="team_matrix_list_view">
            <?=$list_teams_view?>    
        </div>
        
    </div>
</div>

<script type="text/javascript">
    function show_team_matrix_form(id){
        $(".loading_panel").show();
        $.ajax({
            type: "GET",
            url: config.base+"team_matrix/show_form",
            data: {id: id, ownership_id: "<?=$ownership_id_team?>", category: "<?=$category_team?>", modul: "<?=$modul_team?>", sub_modul: "<?=$sub_modul_team?>"},
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

    function delete_team_matrix(id){
        $.confirm({
            title: 'Apa anda yakin?',
            content: '',
            confirmButton: 'Ya',
            confirm: function(){  
              $.ajax({
                type: "GET",
                url: config.base+"team_matrix/delete_team_matrix",
                data: {id:id},
                dataType: 'json',
                cache: false,
                success: function(resp){
                  console.log(resp);
                  if(resp.status==true){
                    $('#team_matrix_div_'+id).animate({'opacity':'toggle'});
                  }else{
                      console.log('action after failed');
                  }
                }
              });
            },
        });
    }
</script>