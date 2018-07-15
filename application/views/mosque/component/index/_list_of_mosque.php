<style type="text/css">
  .time_block{
    height: 10px;
  }
  .time_frame{
    height: 10px; border:1px solid gray;
    border-radius:3px; margin-bottom: 5px; overflow: hidden;
  }
  .time_block.used{
    background-color: grey;
    border-color: grey;
  }
  .time_block.requested{
    background-color: #ff9900;
    border-color:#ff9900;
  }
</style>
<div>
  <?php $user = $this->session->userdata('userbapekis');
  if(isset($mosques)){
  foreach($mosques as $mosque){?>
      <div class="room_<?=$mosque->mosque_id?> broventh_card" style="overflow: hidden; margin-bottom: 20px; padding: 0">    
        <div style="margin-bottom: 15px; padding:12px 20px 10px 20px;">
            <div class="row">
                <div class="col-md-3" style="">
                    <div style="width:180px; max-width: 100%; height: 130px; border-radius:5px; overflow: hidden;">
                      <img style="height: 100%" src="<?=get_thumbnail_src($mosque->full_url)?>">
                    </div>
                </div>
                <div class="col-md-7">
                    <div>
                        <h5 class="helper_text" style="margin-bottom: 5px;"><?=$mosque->region?></h5>
                        <h3 class="content_title"><a href="<?=base_url()?>mosque/show/<?=$mosque->mosque_id?>"><?=$mosque->name?></a></h3>
                        <h5 style="margin-top: 5px;"><?=$mosque->location?></h5>
                    </div>
                    <hr>
                    <div style="margin-top: 3px;">
                        <?=$mosque->note?>
                    </div>
                </div>
                <div class="col-md-2">
                    <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                    <div style="font-size: 10px;" class="right_text">
                        <a onclick="show_add_mosque_form(<?=$mosque->mosque_id?>)">
                            <span class="glyphicon glyphicon-pencil edit_color"></span>
                        </a>
                        <a onclick="delete_room(<?=$mosque->mosque_id?>)">
                            <span class="glyphicon glyphicon-trash delete_color"></span>
                        </a>
                    </div>
                    <?php }?>
                </div>
            </div>
            
        </div>
                
      </div>
  <?php }}?>
</div>