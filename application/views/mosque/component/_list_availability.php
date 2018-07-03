<div id="list_of_rooms">
    <hr>
    <div class="right_text">
        <a onclick="toggle_visibility('list_of_rooms')">x close</a>
    </div>
    <div>
        <h4>Your Meeting Room</h4>
        <div style="margin-top: 20px" class="row">
            <?php foreach($rooms['rooms'] as $room){ $agendas = $room['agenda']; $room = $room['room']; $status = "oke";?>
                <div class="row shadow_box" style="overflow: hidden; margin-bottom: 20px; padding: 0;">
                    <div class="col-md-4" style="padding: 0px;">
                        <div style="width: 100%; height: 130px;">
                            <img style="width: 100%" src="<?=get_thumbnail_src($room->full_url)?>">
                        </div>
                    </div>
                    <div class="col-md-8" style="padding:10px;">
                        <h3 class="first_font"><?=$room->name?></h3>
                        <div>
                            <?=$room->pic_group?> &bull; for <?=$room->capacity?> People &bull; <?=$room->facility?> &bull; <?=$room->location?>
                        </div>
                        <div>
                            <?php 
                                if($status == "oke"){
                                    foreach($agendas as $agenda){
                                        $start_time = date(strtotime($agenda->start));
                                        $end_time = date(strtotime($agenda->end));
                                        if(($arr_time['start_time'] < $start_time && $arr_time['end_time']<=$start_time) || ($arr_time['start_time'] >= $end_time && $arr_time['end_time']>$end_time) || $agenda->agenda_id == $agenda_id) $status = "oke";
                                        else{$status = "cannot"; break;}
                                    }
                                }
                            ?>
                        </div>
                        <div style="margin-top: 35px;" class="right_text">
                            <?php if($status == "oke" ){?>
                                <a class="btn btn-brobot btn-tosca btn-full" onclick="pick_room('<?=$room->ownership_id?>','<?=$room->name?>')">
                                <span class="glyphicon glyphicon-pushpin"></span> BOOK</a>
                            <?php }else{?>
                                <label style=""><span class="glyphicon glyphicon-calendar"></span> In Use</label>
                            <?php }?>
                        </div>
                        <div>
                            <?php if($status == "cannot"){?>
                                    <h4 style="margin-bottom: 5px;" class="second_font">List Agenda</h4>
                                    <?php foreach($agendas as $agenda){?>
                                        <div>
                                            <?=date("H:i", strtotime($agenda->start))?> - <?=date("H:i", strtotime($agenda->end))?> &bull; <?=$agenda->title?> &bull; <?=$agenda->full_name?>
                                        </div>
                            <?php }}?>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
    <?php if(isset($rooms['others'])){?>
        <hr>
        <div>
            <h4>Others Meeting Room</h4>
            <div style="margin-top: 20px" class="row">
                <?php foreach($rooms['others'] as $room){?>
                    <div class="row shadow_box" style="overflow: hidden; margin-bottom: 20px;">
                        <div class="col-md-4" style="padding: 0px;">
                            <div style="width: 100%; height: 130px;">
                                <img style="width: 100%" src="<?=get_thumbnail_src($room->full_url)?>">
                            </div>
                        </div>
                        <div class="col-md-8" style="padding:10px;">
                            <h4><a><?=$room->name?></a></h4>
                            <div>
                                <?=$room->pic_group?> &bull; for <?=$room->capacity?> People &bull; <?=$room->facility?> &bull; <?=$room->location?>
                            </div>
                            <div style="margin-top: 35px;" class="right_text">
                                <a class="btn btn-brobot btn-blue">
                                <span class="glyphicon glyphicon-pencil"></span> REQUEST</a>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    <?php }?>
</div>