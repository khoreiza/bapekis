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
  if(isset($rooms['rooms'])){
  foreach($rooms['rooms'] as $room){ $requests = $room['request']; $agendas = $room['agenda']; $room = $room['room']; $status = "oke"; $arr_req_user = "";?>
      <div class="room_<?=$room->room_id?> broventh_card" style="overflow: hidden; margin-bottom: 20px; padding: 0">
            <div class="row">
                <div class="col-md-3" style="padding: 0px;">
                  <div style="width: 100%; height: 130px; overflow: hidden;">
                      <img style="width: 100%" src="<?=get_thumbnail_src($room->full_url)?>">
                  </div>
                  <div style="padding: 10px 0 10px 10px;">
                    <h4 class="first_font"></h4>
                    <div style="font-size: 12px; margin-top: 5px;">
                        for <?=$room->capacity?> People &bull; <?=$room->facility?>
                    </div>
                    <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                      
                    <?php }?>
                    <?php if($room->need_request){ $arr_req_user = explode(";",$room->need_request);?>
                      <div style="margin-top: 10px; font-size: 12px;" class="second_font">
                        *need an approval
                      </div>
                    <?php }?>
                  </div>
                </div>
                <div class="col-md-9" style="padding:12px 20px 20px 20px;">
                    <div style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-10">
                                <h3 class="news_title"><?=$room->name?></h3>
                                <div style="margin-top: 3px;">
                                    <?=$room->note?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <?php if(is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                <div style="font-size: 10px;" class="right_text">
                                    <a onclick="show_add_room_form(<?=$room->room_id?>)">
                                        <span class="glyphicon glyphicon-pencil edit_color"></span>
                                    </a>
                                    <a onclick="delete_room(<?=$room->room_id?>)">
                                        <span class="glyphicon glyphicon-trash delete_color"></span>
                                    </a>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        
                    </div>
                    <div>
                        <div class="row">
                            <?php $arr_block = array(); $x=0; $st_part_col = array(); $ed_part_col = array();
                            foreach($agendas as $agenda){
                                $hour_st = intval(date('H',strtotime($agenda->start))); $min_st = date('i',strtotime($agenda->start));
                                $hour_ed = intval(date('H',strtotime($agenda->end))); $min_ed = date('i',strtotime($agenda->end));
                                $sum_hours = $hour_ed - $hour_st;
                                $start = $hour_st;
                                if($min_st!=0) $start = $hour_st+1;
                                for($z=$start; $z<$hour_ed; $z++){
                                    $arr_block[$z] = $z;
                                    $ed_part_col[$z] = 100;
                                }
                                //if($min_st != 0){$st_part_col = $min_st/60*100;}
                                //elseif($z == $hour_ed && $min_ed!=0;){$arr_block$ed_part_col = $min_ed/60*100;}
                                if($min_st != 0){
                                    $st_part_col[$hour_st] = $min_st/60*100;
                                    if(!isset($arr_block[$hour_st])) $arr_block[$hour_st] = $hour_st;
                                }
                                if($min_ed != 0){
                                    $ed_part_col[$hour_ed] = $min_ed/60*100;
                                    if(!isset($arr_block[$hour_ed])) $arr_block[$hour_ed] = $hour_ed;
                                }
                            }?>
                            <?php $arr_req = array(); $y=0; 
                            foreach($requests as $request){
                                $hour_st = date('H',strtotime($request->start));
                                $hour_ed = date('H',strtotime($request->end)); $sum_hours = $hour_ed - $hour_st;
                                for($z=$hour_st; $z<$hour_ed; $z++){
                                    $arr_req[$y] = $z; $y++;
                                }
                            }?>
                            <?php for($i=8;$i<20; $i++){?>
                                <div class="col-sm-1 col-xs-2 center_text">
                                  <div style="font-size: 12px;">
                                    <?php if(!in_array($i, $arr_block)){?>
                                      <a onclick="show_book_room_form(<?=$i?>,<?=$room->room_id?>)"><?=$i?>:00</a>
                                    <?php }else{echo "$i:00";}?>
                                  </div>
                                  <!--<div class="time_block <?php if(in_array($i, $arr_block)){echo "used";} if(in_array($i, $arr_req)){echo "requested";}?>"></div>-->
                                  <?php $width_frame = 0; $pull="";
                                      if(isset($ed_part_col[$i]) && !isset($st_part_col[$i])){
                                        $width_frame = $ed_part_col[$i]; $pull=""; 
                                      }
                                      if(isset($st_part_col[$i]) && (!isset($ed_part_col[$i]) || $ed_part_col[$i]==100)){
                                        $width_frame = $st_part_col[$i]; $pull="pull-right";
                                      }
                                      if(isset($st_part_col[$i]) && isset($ed_part_col[$i])){
                                        $width_frame = 100;
                                      }
                                  ?>
                                  <div class="time_frame" style="width: 100%;">
                                    <div class="time_block <?php if(in_array($i, $arr_block)){echo "used";} echo " ".$pull;/*if(in_array($i, $arr_req)){echo "requested";}*/?> " style="width: <?=$width_frame?>%;"></div>
                                  </div>
                                </div>    
                            <?php }?>
                        </div>

                        <?php if($requests){?>
                            <div style="margin-top: 20px;">
                              <h5 style="margin-bottom: 5px;" class="second_font">
                                <span style="font-size: 12px;" class="glyphicon glyphicon-calendar"></span>  List Request
                              </h5>
                              <?php foreach($requests as $request){?>
                                  <div class="row" id="request_<?= $request->request_id?>">
                                      <div class="col-xs-11">
                                        <?=date("H:i", strtotime($request->start))?> - <?=date("H:i", strtotime($request->end))?> <?=dot_devider()?> 
                                        <a onclick="show_agenda(<?=$request->request_id?>,'meeting_room_request')">
                                          <span title="<?=$request->title?>"><?php long_text_real($request->title,30)?></span>
                                        </a> <?=dot_devider()?> 
                                        <a onclick="show_user_detail('<?=$request->calendar_created?>')"><?php long_text_real($request->full_name,20)?></a>
                                      </div>
                                      <div class="col-xs-1">
                                        <?php if(($user['id'] == $request->calendar_created) || is_user_role($user,"SYSTEM ADMINISTRATOR")){?>
                                          <a onclick="show_book_room_form('','',<?=$request->request_id?>,'meeting_room_request')">
                                            <span class="glyphicon glyphicon-pencil edit_color"></span>
                                          </a>
                                          <?php }?>
                                          <a onclick="delete_booking_agenda(<?=$request->request_id?>,'meeting_room_request')">
                                            <span class="glyphicon glyphicon-trash delete_color"></span>
                                          </a>
                                      </div>
                                  </div>
                              <?php }?>
                            </div>
                        <?php }?>

                        <div style="margin-top: 20px;">
                          <?php if($agendas){echo "<hr>"; foreach($agendas as $agenda){?>
                              
                              <div class="row" id="agenda_<?= $agenda->agenda_id?>">
                                  <div class="col-xs-11">
                                    <?=date("H:i", strtotime($agenda->start))?> - <?=date("H:i", strtotime($agenda->end))?> <?=dot_devider()?> 
                                    <a onclick="show_agenda(<?=$agenda->agenda_id?>,'calendar')" title="<?=$agenda->title?>"><?php long_text_real($agenda->title,30)?></a> <?=dot_devider()?> 
                                    <a onclick="show_user_detail('<?=$agenda->calendar_created?>')"><?php long_text_real($agenda->full_name,20)?></a>
                                  </div>
                                  <div class="col-xs-1" style="font-size: 10px;">
                                    <?php if(($user['id'] == $agenda->calendar_created) || is_user_role($user,"SYSTEM ADMINISTRATOR") || (strtoupper($user['position']) == "SEKRETARIS") && strtoupper($user['group']) == strtoupper($room->pic_group) || ($arr_req_user && in_array($user['id'], $arr_req_user))){?> 
                                      <a onclick="show_book_room_form('',<?=$agenda->meeting_room_id?>,<?=$agenda->agenda_id?>,'calendar')">
                                        <span class="glyphicon glyphicon-pencil edit_color"></span>
                                      </a>
                                      <a onclick="delete_booking_agenda(<?=$agenda->agenda_id?>,'calendar')">
                                        <span class="glyphicon glyphicon-trash delete_color"></span>
                                      </a>
                                    <?php }?>
                                  </div>
                              </div>
                          <?php }}else{?>
                            <h4 style="margin-top: 30px;" class="helper_text center_text">No Agenda</h4>
                          <?php }?>
                        </div>
                    </div>
                </div>
            </div>
      </div>
  <?php }}?>
</div>