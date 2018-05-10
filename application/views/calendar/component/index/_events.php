<?php 
    $user = $this->session->userdata('userbapekis');
?>

<div id="list_of_events" style="margin-top: 10px;">
    <?php 
        $prev_date = ""; $arr_event_date = array();
        if(isset($events) && $events){
            foreach($events as $event){
                $start_day = date("j",strtotime($event->start));
                
                if($event->end) $end_day = date("j",strtotime($event->end));
                else $end_day = "";

                if(!$end_day || (date("Y-m-d",strtotime($event->start)) == date("Y-m-d",strtotime($event->end)))){
                    if(!in_array($start_day, $arr_event_date)) $arr_event_date[count($arr_event_date)+1] = $start_day;
                }else{
                    if(date("m",strtotime($event->start)) == date("m",strtotime($event->end))){
                        for($z=$start_day;$z<=$end_day;$z++){
                            if(!in_array($z, $arr_event_date)) $arr_event_date[count($arr_event_date)+1] = $z;
                        }
                    }else{
                        $end_of_month = $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        for($z=$start_day;$z<=$end_of_month;$z++){
                            if(!in_array($z, $arr_event_date)) $arr_event_date[count($arr_event_date)+1] = $z;
                        }
                    }
                }
            ?>
            <div class="row" style="margin-top: <?=($prev_date != date("Y-m-d",strtotime($event->start))) ? "40px" : "5px"?>;">
                <div class="col-sm-2 col-md-1">
                    <?php if($prev_date != date("Y-m-d",strtotime($event->start))){?>
                        <h2><?=date("j",strtotime($event->start));?></h2>
                        <h5><?=date("D",strtotime($event->start));?></h5>
                    <?php
                         $prev_date = date("Y-m-d",strtotime($event->start));
                    }?>
                </div>
                <div class="col-sm-10 col-md-11">
                    <div class="broventh_card" style="padding: 0px;">
                        <?php 
                            if($event->full_url){
                                $img_url = $event->full_url;
                            }else{
                                $img_url = get_calendar_category($event->category,date("H",strtotime($event->start)));
                            }
                        ?>
                        <div class="row" style="background-image: url(<?=$img_url?>); background-size: 100%;">
                            
                            <div class="col-sm-10">
                                <div class="event_info" style="max-width: 300px; padding: 10px; background-color: white; margin-top: 50px; opacity:0.95">
                                    <h4 class="news_title">
                                        <a href="<?=base_url()?>calendar/show/<?=$event->id?>"><?=$event->title?></a>
                                    </h4>
                                    <h5 style="margin-top: 10px;"><?=date("H:i",strtotime($event->start));?> - <?=date("H:i",strtotime($event->end));?></h5>
                                    <h5><?=$event->location?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php }}?>
</div>

<script type="text/javascript">
</script>
