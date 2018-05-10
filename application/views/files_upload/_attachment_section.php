
<?php foreach($attachments as $file){?>
  <?php 
    if($file->ext == ".doc" || $file->ext == ".docx"){$img = "word";}
    elseif($file->ext == ".xls" || $file->ext == ".xlsx"){$img = "xlx";}
    elseif($file->ext == ".ppt" || $file->ext == ".pptx"){$img = "ppt";}
    else{$img = "pdf";}
  ?>
  <div>
    <div style="float:left; width:80%; overflow:hidden; padding-right:10px;">
      <span><img style="height:18px" src="<?php echo base_url()?>assets/img/icon/<?php echo $img?> - color.png"></span>
      <?php echo $file->title?>
    </div>
    <div style="float:right; padding-right:10px;">
      <a href="<?php echo base_url()?>assets/uploads/customer_knowledge/attachments/<?php echo $file->file_name;?>">
        <span class="glyphicon glyphicon glyphicon-cloud-download" aria-hidden="true" style="color:#007aff"></span>
      </a>
      <?php if(($user['id'] == $file->user_id) || $user['role']=="SYSTEM ADMINISTRATOR"){?> 
        <a href="<?php echo base_url()?>compliance/add_publication/<?php echo $file->id?>">
          <span class="glyphicon glyphicon-pencil" style="color:#f0ad4e"></span>
        </a>
        <a href="<?php echo base_url()?>compliance/delete_publication/<?php echo $file->id?>">
          <span class="glyphicon glyphicon-trash" style="color:#c9302c"></span>
        </a>
      <?php }?>
    </div><div style="clear:both"></div>
  </div>
<?php }?>