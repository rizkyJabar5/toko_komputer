<?php $this->load->view('include/header'); ?>

<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade">
		<!-- begin login -->
			<div class="login bg-black animated fadeInDown">
					<!-- begin brand -->
					<div class="login-header">
							<div class="brand">
									<span class="logo"><i class="ion-ios-monitor"></i></span> Toko Komputer
									<small>Aplikasi Penjualan Toko Komputer</small>
							</div>
							<div class="icon">
									<i class="ion-ios-locked"></i>
							</div>
					</div>
					<!-- end brand -->
					<div class="login-content">
							<?php echo form_open('secure', array('id' => 'FormLogin')); ?>
									<div class="form-group m-b-20">
										<?php
										echo form_input(array(
											'name' => 'username',
											'class' => 'form-control input-lg inverse-mode no-border',
											'placeholder' => 'Username',
											'autocomplete' => 'off',
											'autofocus' => 'autofocus'
										));
										?>
											<!-- <input type="text" class="form-control input-lg inverse-mode no-border" placeholder="Email Address" required /> -->
									</div>
									<div class="form-group m-b-20">
										<?php
										echo form_password(array(
											'name' => 'password',
											'class' => 'form-control input-lg inverse-mode no-border',
											'placeholder' => 'Password',
											'id' => 'InputPassword'
										));
										?>
											<!-- <input type="password" class="form-control input-lg inverse-mode no-border" placeholder="Password" required /> -->
									</div>
									<div class="login-buttons">
											<button type="submit" class="btn btn-primary btn-block btn-lg">Sign me in</button>
											<button type="reset" class="btn btn-default btn-block btn-lg">Reset</button>
									</div>
									<div id='ResponseInput'></div>
							<?php echo form_close(); ?>
					</div>
					<div style="background-color:#e4e7e8;color:#222;">
						<br>
						<p align="center"><?php echo config_item('web_footer'); ?></p>
						<hr style='border-color:#999; border-style:dashed;'/>
						<center>
						LIST AKSES<br /><br />
						<div class='col-sm-12' style="background-color:#e4e7e8;color:#222;">
							<div class='col-sm-3'><b>Admin</b> <br />Username : admin<br />Password : admin <br><br> </div>
							<div class='col-sm-3'><b>Kasir</b> <br />Username : kasir<br />Password : kasir <br><br> </div>
							<div class='col-sm-3'><b>Gudang</b> <br />Username : jaka<br />Password : jaka <br><br> </div>
							<div class='col-sm-3'><b>Keuangan</b> <br />Username : joko<br />Password : joko <br><br> </div>
						</div>
						</center>
					</div>
			</div>
			<!-- end login -->
</div>
<!-- end page container -->

<script>
$(function(){
	//------------------------Proses Login Ajax-------------------------//
	$('#FormLogin').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			cache: false,
			data: $(this).serialize(),
			dataType:'json',
			success: function(json){
				//response dari json_encode di controller

				if(json.status == 1){ window.location.href = json.url_home; }
				if(json.status == 0){ $('#ResponseInput').html(json.pesan); }
				if(json.status == 2){
					$('#ResponseInput').html(json.pesan);
					$('#InputPassword').val('');
				}
			}
		});
	});

	//-----------------------Ketika Tombol Reset Diklik-----------------//
	$('#ResetData').click(function(){
		$('#ResponseInput').html('');
	});
});
</script>

<?php $this->load->view('include/footer'); ?>
