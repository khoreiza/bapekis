<div>
	<?php if($sharing->full_url){?>
        <div style="width: 300px; margin: 0 auto; margin-bottom: 40px;">
            <img id="<?=$sharing->id?>_banner_sharing" style="width: 100%;" src="<?=base_url().$sharing->full_url?>">
        </div>
    <?php }?>
    <div >
    	<div>
    		<h3><?=$sharing->title?></h3>
    		<h6 style="margin-top: 8px">
    			<?=date("D, j M y", strtotime($sharing->created_at))?>
    			<?=dot_devider()?>
    			<?=$sharing->category?>
    		</h6>
    	</div>
    	<div style="margin-top: 40px">
    		<p><?=$sharing->description?></p>
    	</div>
    </div>
</div>