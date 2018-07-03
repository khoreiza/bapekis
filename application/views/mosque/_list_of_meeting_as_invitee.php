<?php if($my_meeting_as_invitee){?>
  <div class="flat_box">
      <div class="flat_box_header">
          <div class="fbh_logo">
              <span class="glyphicon glyphicon-briefcase"></span>
          </div>
          <div class="fbh_title">
              List meeting which you are invited
          </div>
          <div style="clear: both"></div>
      </div>
      <div class="flat_box_content">
          <?php foreach($my_meeting_as_invitee as $request){?>
            <div style="border-bottom:1px solid #e2e2e2; padding: 10px;" class="row" id="my_request_<?=$request->id?>">
              <div class="col-md-12">
                <div><a onclick="show_agenda(<?=$request->calendar_id?>,'calendar')"><span><?=$request->title?></span></a></div>
                <div style="font-size: 12px;"><?=$request->room_name?></div>
                <div style="font-size: 12px;"><?=date("j M y, H:i",strtotime($request->start))." - ".date("H:i",strtotime($request->end))?></div>
                <div style="margin-top: 10px">
                  
                </div>
              </div>
            </div>
          <?php }?>
      </div>
  </div>
<?php }?>