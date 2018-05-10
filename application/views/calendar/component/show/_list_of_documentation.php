<?php 
	$photo_folder = "assets/uploads/calendar/documentation/";
?>
<script>
	$(function(){
	  $('a[rel=lightbox]').lightBox({
		containerResizeSpeed: 250,
		fixedNavigation: true,
		maxHeight: 800,
		maxWidth: 800
	  });
	});
</script>
<div>
	<div style="margin-bottom:10px;">
	<?php foreach($documentations as $row){?>
		<div style="width:18%; height:120px; overflow:hidden; float:left; padding:5px;">
		<a href="<?php echo base_url().$photo_folder.$row->ownership_id."/".$row->file_name?>" rel="lightbox" >
			<img style="width:100%;"src="<?php echo base_url().$photo_folder?><?php echo $row->ownership_id."/thumb/".$row->file_name?>_thumbnail.jpg">
		</a>
		</div>
	<?php }?>
	<div style="clear:both"></div>
	</div>
</div>