<div class="menuBar">
	<nav class="navbar navbar-default ">
		<div class="container p0">
			<div class="navbar-header">
				<div class="logo">
					<a href="<?=base_url()?>" class="navbar-brand">
						<img src="<?=base_url()?>assets/img/logo.png" height="100px" alt="Homepage logo">
					</a>
				</div>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
						data-target="#navbar-menu">
					<i class="fa fa-bars" aria-hidden="true"></i>
				</button>
			</div>
			<div class="navbar-right">

				<div id="navbar-menu" class="collapse navbar-collapse ">
					<ul class="nav navbar-nav" data-in="fadeInDown" data-out="fadeOutUp">
						<li><a href="<?=base_url()?>" class="contact" title="home">HOME</a></li>
						<li><a href="general" class="contact" title="general">GENERAL INFO</a></li>
						<li><a href="financial" class="contact" title="financial">FINANCIAL INFO</a></li>
						<li><a href="gallery" class="contact" title="gallery">EVENT & GALLERY</a></li>
						<li class="last"><a href="profile" class="contact" title="profile">PROFILE</a></li>
					</ul>
				</div>

			</div>
		</div>
	</nav>
</div>

<script>
    "use strict";
    // ===================== Menu Bar ======================
     $(document).ready(function(){
    var pathname = window.location.pathname;
    var page = pathname.split(/[/ ]+/).pop();
    var menuItems = $('#navbar-menu a');
    menuItems.each(function(){
        var mi = $(this);
        var miHrefs = mi.attr("href");
        var miParents = mi.parents('li');
        if(page == miHrefs) {
            miParents.addClass("active").siblings().removeClass('active');
        }
    });
     });
</script>

