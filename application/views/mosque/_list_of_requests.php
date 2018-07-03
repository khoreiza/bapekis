
<?php if($requests){?>
  <div class="flat_box">
      <div class="flat_box_header">
          <div class="fbh_logo">
              <span class="glyphicon glyphicon-check"></span>
          </div>
          <div class="fbh_title">
              Need to be Approved
          </div>
          <div style="clear: both"></div>
      </div>
      <div class="flat_box_content">
          <?php foreach($requests as $request){?>
              <div style="border-bottom:1px solid #e2e2e2; padding: 10px;" class="row" id="my_request_<?=$request->id?>">
                <div class="col-md-2">
                  <div style="overflow:hidden; width: 100%; max-width: 40px; height: 40px; border-radius: 10px;">
                    <?php employee_photo($request)?>
                  </div>
                </div>
                <div class="col-md-7">
                  <div><?=$request->title?></div>
                  <div style="font-size: 12px;"><?=$request->room_name?></div>
                  <div style="font-size: 12px;"><?=date("j M y, H:i",strtotime($request->start))." - ".date("H:i",strtotime($request->end))?></div>
                  <div style="font-size: 12px;"><a onclick="show_user_detail(<?=$request->created_by?>)"><?=$request->full_name?></a></div>
                </div>
                <div class="col-md-3">
                  <div style="margin-bottom: 5px;"><a onclick="proceed_request(<?=$request->id?>,'Approved')" class="btn btn-brobot btn-tosca btn-xs"><span class="glyphicon glyphicon-ok-circle"></span> Approve</a></div>
                  <div><a onclick="proceed_request(<?=$request->id?>,'Rejected')" class="btn btn-brobot btn-gray btn-full btn-xs"><span class="glyphicon glyphicon-remove-circle"></span> Reject</a></div>
                </div>
              </div>
          <?php }?>
      </div>
  </div>
<?php }if($my_reqs){?>
  <div class="flat_box">
      <div class="flat_box_header">
          <div class="fbh_logo">
              <span class="glyphicon glyphicon-briefcase"></span>
          </div>
          <div class="fbh_title">
              Your Request for Room Booking
          </div>
          <div style="clear: both"></div>
      </div>
      <div class="flat_box_content">
          <?php foreach($my_reqs as $request){?>
            <div style="border-bottom:1px solid #e2e2e2; padding: 10px;" class="row" id="my_request_<?=$request->id?>">
              <div class="col-md-12">
                <div><?=$request->title?></div>
                <div style="font-size: 12px;"><?=$request->room_name?></div>
                <div style="font-size: 12px;"><?=date("j M y, H:i",strtotime($request->start))." - ".date("H:i",strtotime($request->end))?></div>
                <div style="margin-top: 10px">
                  <?=$request->status?> 
                    <?php if($request->status != "Pending"){?>
                    by 
                    <a onclick="show_user_detail(<?=$request->created_by?>)"><?=$request->full_name?></a>
                    <div style="font-size: 12px;"> at <?=date("j M y, H:i",strtotime($request->approved_at))?></div>
                  <?php }?>
                  
                </div>
              </div>
            </div>
          <?php }?>
      </div>
  </div>
<?php }?>

<script type="text/javascript">
  function proceed_request(id,status){
    $.confirm({
      title: 'Apa anda yakin?',
      content: '',
      confirmButton: 'Ya',
      confirm: function(){  
        $.ajax({
        type: "GET",
        url: config.base+"meeting/proceed_request",
        data: {id:id, status:status},
        dataType: 'json',
        cache: false,
        success: function(resp){
          console.log(resp);
          if(resp.status==true){
              $('#my_request_'+id).animate({'opacity':'toggle'});
              change_date_for_room();
          }else{
            console.log('action after failed');
          }
        }
        });
      },
    });
  }

</script>