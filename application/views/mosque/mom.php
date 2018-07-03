<style type="text/css">
    #chartdiv_growth{
        width:100%;
        height:148px !important;
    }
    .agenda_info .glyphicon{padding-right: 5px; color:#df756c; font-size: 12px;}
</style>
<?php $user = $this->session->userdata('userbapekis');?>

<div id="" class="container_broventh container_broventh_small">

    <?php $user = $this->session->userdata('userbapekis');?>

    <div style="padding: 20px 0 0 0;">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?=base_url()?>meeting/agenda/<?=$mom->meeting_id?>"><span class="glyphicon glyphicon-chevron-left"></span> AGENDA PAGE</a>
                    </div>
                    <div class="col-md-6 right_text">
                        <a class="btn btn-broventh btn-second" onclick="take_screenshot('mom_content_print',1)" style="margin-right: 5px;">
                            <span class="glyphicon glyphicon-print"></span> PRINT
                        </a>
                    </div>
                </div>
                <div class="broventh_card" style="margin-top: 20px;">
                    <div id="mom_content_print">
                        <div style="padding: 40px;">
                            <div style="padding-bottom: 10px; margin-bottom: 20px; border-bottom: 2px solid #727272">
                                <div class="right_text">
                                    <img style="height: 30px;" src="<?=base_url()?>assets/img/general/mandiri - logo.png">
                                </div>
                                <div class="center_text news_title">
                                    <h4>MINUTES OF MEETING</h4>
                                </div>
                            </div>
                            <div style="padding-bottom: 20px; margin-bottom: 15px; border-bottom: 2px solid #e2e2e2">
                                <div class="row">
                                    <div class="col-md-2"><i>Meeting Name:</i></div>
                                    <div class="col-md-10"><b><?=$mom->meeting_title?></b></div>
                                </div>
                                <div class="row" style="margin-top: 5px;">
                                    <div class="col-md-2"><i>Date:</i></div>
                                    <div class="col-md-5"><b><?=date("l, j M Y",strtotime($mom->start))?></b></div>
                                    <div class="col-md-1"><i>Venue:</i></div>
                                    <div class="col-md-3"><b><?=$mom->room_name?></b></div>
                                </div>
                                <div class="row" style="margin-top: 5px;">
                                    <div class="col-md-2"><i>Meeting Agenda:</i></div>
                                    <div class="col-md-10"><b><?=$mom->title?></b></div>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <h4 class="news_title">A. Latar Belakang</h4>
                                    <?php if($mom->background){?> <div style="margin: 5px 0 10px;"><?=$mom->background?></div><?php }?>
                                </div><hr>
                                <div>
                                    <h4 class="news_title">B. Pembahasan</h4>
                                    <?php if($mom->content){?> <div style="margin: 5px 0 10px;"><?=$mom->content?></div><?php }?>
                                </div><hr>
                                <div>
                                    <h4 class="news_title">C. Kesimpulan & Tindak Lanjut</h4>
                                    <?php if($mom->result){?> <div style="margin: 5px 0 10px;"><?=$mom->result?></div><?php }?>

                                    <div style="margin-top: 20px;">
                                        <table class="table table-striped">
                                            <thead>
                                                <th>No.</th>
                                                <th>PIC</th>
                                                <th>Activity</th>
                                                <th>Deadline</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach($list_activity_steps as $k => $las){ ?>
                                                    <tr>
                                                        <td><?=$k+1?></td>
                                                        <td><?=$las->full_name?></td>
                                                        <td><?=$las->activity?></td>
                                                        <td><?=date("d-M-Y", strtotime($las->deadline))?></td>
                                                    </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    
                                    
                                </div>
                                <div class="col-md-2">
                                    <div style="margin-top: 20px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/application/meeting_new.js"></script>