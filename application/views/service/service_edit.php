<?php echo form_open('service/edit/'.$user->id_service, array('id' => 'FormEditService')); ?>
<div class='form-group'>
	<label>Nama Service</label>
	<input type='text' name='nama_service' class='form-control' value="<?php echo $user->nama_service; ?>">
</div>
<div class='form-group'>
	<label>Harga Service</label>
	<input type='text' name='harga_service' class='form-control' onkeypress="return check_int(event)" value="<?php echo $user->harga_service; ?>">
</div>

<hr />

<div class='form-group'>
	<label>Nama Konsumen</label>
	<input type='text' name='nama_konsumen' class='form-control' value="<?php echo $user->nama_konsumen; ?>">
</div>
<div class='form-group'>
	<label>No. HP Konsumen</label>
	<input type='text' name='no_hp_konsumen' class='form-control' onkeypress="return check_int(event)" value="<?php echo $user->no_hp_konsumen; ?>">
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditService'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('#SimpanEditService').click(function(){
		$.ajax({
			url: $('#FormEditService').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormEditService').serialize(),
			dataType:'json',
			success: function(json){
				if(json.status == 1){
					$('#ResponseInput').html(json.pesan);
					setTimeout(function(){
				   		$('#ResponseInput').html('');
				    }, 3000);
					$('#my-grid').DataTable().ajax.reload( null, false );
				}
				else {
					$('#ResponseInput').html(json.pesan);
				}
			}
		});
	});
});
</script>
