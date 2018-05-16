<script>
    function adjust_img_size_div(div, type){
        setTimeout(function(){
            var img = $('#'+div);
            var width = img.width();
            var height = img.height();

            var parent = $('#'+div+"_parent");
            if((width > height) || (width/height > 1.6)){
                //alert('lebar');
                img.height('100%');
                img.width('');

                if(img.width() < parent.width()){
                   // alert('lebargakad');
                    img.height('');
                    img.width('100%');
                }
            }
        }, 40);
    }
</script>




<div class="main-container-6 ">
    <div class="container">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="text-center">
                    <h2 class="title-text">Bapekis Sharing</h2>
                    <div class="wave-line wave-center"></div>
                    <p class="paragraph-white"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach($sharings as $sharing){?>
                <div class="col-md-3">
                    <div style="height: 225px; overflow: hidden; padding: 0px;" id="<?=$sharing->id?>_banner_sharing_parent">
                        <img id="<?=$sharing->id?>_banner_sharing" style="width: 100%;" src="<?=base_url().$sharing->full_url?>">
                    </div>
                    <script type="text/javascript">
                        //or however you get a handle to the IMG
                        adjust_img_size_div('<?=$sharing->id?>_banner_sharing','');
                    </script>


                    <div class="person-content">
                        <h3 style="height: 80px; overflow: hidden;"><?=get_long_text_real($sharing->title,50)?></h3>
                        <span><?=date("M j, Y")?></span>
                        <p><?=long_text_real(strip_tags($sharing->description),290)?></p>
                    </div>
                    <div class="buttons">
                        <a href="#" class="red-btn red-btn-news">Read More</a>
                    </div>
                </div>

            <?php }?>
        </div>
    </div>
</div>