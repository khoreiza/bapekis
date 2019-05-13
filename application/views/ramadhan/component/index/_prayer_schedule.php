<style type="text/css">
    .box_subpart_small{
        background-color: transparent !important;
        border-right: 1px solid #b89914;
        padding: 10px;
    }
</style>


<div style="min-height: 180px;">
    <h1 style="color:#b89914">
        <script type="text/javascript">
            document.write(writeIslamicDate(-1));
        </script>
    </h1>
    <h3 style="margin-top: 10px;"><?=date('j M Y')?></h3>
    <div style="margin-top: 20px">
        <div class="row prayer_scedule" style="text-align: center">
            <div class="col-md-2 col-xs-4">
                <div class="box_subpart_small">
                    <h4 class="prayer_time"><?=$jadwalsholat[1]?></h3>
                    <h5 class="news_title">Subuh</h4>
                </div>
            </div>
            <div class="col-md-2 col-xs-4">
                <div class="box_subpart_small">
                    <h4 class="prayer_time"><?=$jadwalsholat[2]?></h3>
                    <h5 class="news_title">Terbit</h4>
                </div>
            </div>
            <div class="col-md-2 col-xs-4">
                <div class="box_subpart_small">
                    <h4 class="prayer_time"><?=$jadwalsholat[4]?></h3>
                    <h5 class="news_title">Dzuhur</h4>
                </div>
            </div>
            <div class="col-md-2 col-xs-4">
                <div class="box_subpart_small">
                    <h4 class="prayer_time"><?=$jadwalsholat[5]?></h3>
                    <h5 class="news_title">Ashar</h4>
                </div>
            </div>
            <div class="col-md-2 col-xs-4">
                <div class="box_subpart_small">
                    <h4 class="prayer_time"><?=$jadwalsholat[6]?></h3>
                    <h5 class="news_title">Magrib</h4>
                </div>
            </div>
            <div class="col-md-2 col-xs-4">
                <div class="box_subpart_small" style="border-right: 0px;">
                    <h4 class="prayer_time"><?=$jadwalsholat[7]?></h3>
                    <h5 class="news_title">Isya</h4>
                </div>
            </div>
        </div>
        <div class="right_text helper_text" style="margin-top: 5px;">
            <h6>*Untuk wilayah DKI Jakarta & sekitarnya</h6>
        </div>  
    </div>
</div>
        