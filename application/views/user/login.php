<style type="text/css">
    .banner{
        background-image: url("https://images7.alphacoders.com/398/thumb-1920-398458.jpg");
        height: auto;
    }
    .form-control{
    	max-width: 600px;
    }
</style>

<div class="banner">
    <div class="shadow-main">
        <div id="col-side" class="login-form animated fadeIn">		
			<div id="loginContainer" style="width: 400px; margin:0 auto; padding-top: 170px; margin-bottom: 300px">
				<form id="loginForm" role="form" action="<?php echo base_url();?>user/login_action" method="post" style="background-color:#e2e2e2; padding:30px; border-radius: 20px; opacity:0.8">
					<div class="form-group">
						<label for="userid" class="text-field-label-horizontal-empty">Username</label>
						<input type="text" class="form-control" id="usname" name="username" style="-webkit-box-shadow: inset 0 0 0 2em #fff !important; color: black;">
					</div>
					<div class="form-group">
						<label for="pwd" class="text-field-label-horizontal-empty">Password</label>
						<input type="password" class="form-control" id="pwd" name="password" style="-webkit-box-shadow: inset 0 0 0 2em #fff !important; color: black">
					</div>
					<button style="opacity:2" class="btn btn-lg btn-info btn-block" type="submit" style="background-color:#0B0A51; border-color:#0B0B61;">Log In</button>		
				</form>	
			</div>
		</div>
    </div>
</div>