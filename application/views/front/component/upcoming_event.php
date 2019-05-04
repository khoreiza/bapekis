<div class="events black">
    <div class="main-container-3 shadow">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <h2 class="title-text">Bapekis Events</h2>
                    <div class="wave-line wave-center"></div>
                    <p class="paragraph-black"></p>
                </div>
            </div>

            <?php if($events){foreach($events as $event){?>
                <div class="col-md-6 events_column">
                    <div class="events-line">
                        <div class="col-md-2 col-sm-2 col-xs-3 height100 events_column">
                            <div class="events-title text-center">
                                <p>
                                    <a href="#"><?=date("d",strtotime($event->start))?>
                                        <span><?=date("M",strtotime($event->start))?></span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-9 pl events_column">
                            <h6>
                                <a href="features.html#event-1" class="white"> <?=$event->title?> </a>
                            </h6>
                            <ul class="gb-list">
                                <li>
                                    <a href="#"><i class="icon-clock" aria-hidden="true"></i>
                                        <?=date("M j, Y",strtotime($event->start))?></a>
                                </li>
                                <li><i class="icon-location-1"></i>
                                    <a href="#"> <?=$event->location?> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php }}?>
        </div>
    </div>
</div>