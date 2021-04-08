<?php echo form_open('service/tambah', array('id' => 'FormTambahServis')); ?>
<div class='form-group'>
	<label>Nama Service</label>
	<input type='text' name='nama_service' class='form-control'>
</div>
<div class='form-group'>
	<label>Harga Service</label>
	<input type='text' name='harga_service' class='form-control' onkeypress="return check_int(event)">
</div>

<hr />

<div class='form-group'>
	<label>Nama Konsumen</label>
	<input type='text' name='nama_konsumen' class='form-control'>
</div>
<div class='form-group'>
	<label>No. HP Konsumen</label>
	<input type='text' name='no_hp_konsumen' class='form-control' onkeypress="return check_int(event)">
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahService()
{
	$.ajax({
		url: $('#FormTambahServis').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahServis').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Sukses !');
				$('#ModalContent').html(json.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal'>Ok</button>");
				$('#ModalGue').modal('show');
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahService'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahService").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahService').click(function(e){
		e.preventDefault();
		TambahService();
	});

	$('#FormTambahServis').submit(function(e){
		e.preventDefault();
		TambahService();
	});
});
</script>
