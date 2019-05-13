<div style="margin-top: 60px;" classs="sub_menu_bapekis">
    <div class="title_sub_content">
        <div class="row">
            <div class="col-md-2 col-xs-3">
                <img src="<?=base_url()?>assets/img/submenu/eyd-drum.png" style="height:40px;">
            </div>
            <div class="col-md-10 col-xs-9">
                <div class="part_subtitle">Ramadhan Event</div>
                <div class="part_description"></div>
            </div>
        </div>
    </div>
    <div class="body_sub_content">
        <div class="row">
            <div class="col-md-8" style="margin-bottom: 20px">
                <div style="border: 5px solid #003366; padding: 10px;">
                    <div class="big_event">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?=base_url()?><?=$big_event->full_url?>" style="width: 100%;">
                            </div>
                            <div class="col-md-8">
                                <h4 class="news_title" style="">
                                    <a onclick="open_detail_content('event',<?=$big_event->calendar_id?>);"><?=$big_event->title?></a>
                                </h4>
                                <h5 style="margin-top: 10px;"><?=$big_event->location?></h5>
                                <h6 style="margin-top: 3px;"><?=date("j M",strtotime($big_event->start))?><?=(date('Y-m-d',strtotime($big_event->start)) != date('Y-m-d',strtotime($big_event->end))) ? " - ".date("j M",strtotime($big_event->end)) : ""?>, <?=date("H:i",strtotime($big_event->start));?> - <?=date("H:i",strtotime($big_event->end));?></h6>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <?php if($events){foreach($events as $event){?>
                            <div class="col-md-6">
                                <div class="broventh_card">
                                    <h5 class="news_title" style="">
                                        <a onclick="open_detail_content('event',<?=$event->calendar_id?>);"><?=$event->title?></a>
                                    </h5>
                                    <div class="small_text">
                                        <div><?=date("j M",strtotime($event->start))?><?=(date('Y-m-d',strtotime($event->start)) != date('Y-m-d',strtotime($event->end))) ? " - ".date("j M",strtotime($event->end)) : ""?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }}?>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-bottom: 20px">
                <div class="broventh_card" style="padding: 10px 5px;">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?=base_url()?>assets/img/submenu/adhan-call.png" style="height:32px;">
                        </div>
                        <div class="col-md-9">
                            <h5 class="news_title"><a href="<?=base_url()?>ramadhan/lomba">Lomba Ramadhan</a></h5>
                            <div style="margin-top: 5px;" class="small_text helper_text">MTQ, Adzan, Ucapan Hari Raya</div>
                        </div>
                    </div>
                </div>
                <div class="broventh_card" style="padding: 10px 5px;">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?=base_url()?>assets/img/general/ig-logo.png" style="height:32px;">
                        </div>
                        <div class="col-md-9">
                            <h5 class="news_title">Quiz Ramadhan</h5>
                            <div style="margin-top: 5px;" class="small_text helper_text">Dapatkan Hadiah Menarik, dengan menjawab pertanyaan di IG Bapekis</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>