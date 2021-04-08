<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div id="content" class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='ion-ios-pulse-strong'></i> Data Service</h5>
			<hr />

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Nama Service</th>
							<th>Harga Service</th>
							<th>Nama Konsumen</th>
							<th>No. Hp Konsumen</th>
							<th>Tgl. diinput</th>
							<th>Diinput Oleh</th>
							<th class='no-sort'>Edit</th>
							<th class='no-sort'>Hapus</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<?php
$tambahan = nbs(2)."<a href='".site_url('service/tambah')."' class='btn btn-default' id='TambahService'><i class='fa fa-plus fa-fw'></i> Input Service</a>";
$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
?>

<script type="text/javascript" language="javascript" >
	$(document).ready(function() {
		var dataTable = $('#my-grid').DataTable( {
			"serverSide": true,
			"stateSave" : false,
			"bAutoWidth": true,
			"oLanguage": {
				"sSearch": "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman <?php echo $tambahan; ?>",
				"sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				"sInfoFiltered": "(difilter dari _MAX_ total data)",
				"sZeroRecords": "Pencarian tidak ditemukan",
				"sEmptyTable": "Data kosong",
				"sLoadingRecords": "Harap Tunggu...",
				"oPaginate": {
					"sPrevious": "Prev",
					"sNext": "Next"
				}
			},
			"aaSorting": [[ 0, "desc" ]],
			"columnDefs": [
				{
					"targets": 'no-sort',
					"orderable": false,
				}
	        ],
			"sPaginationType": "simple_numbers",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 20, 50, 100, 150, 20, 50], [10, 20, 50, 100, 150, 20, 50]],
			"ajax":{
				url :"<?php echo site_url('service/service-json'); ?>",
				type: "post",
				error: function(){
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="9">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
	});

	$(document).on('click', '#HapusService', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');

		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus <br /><b>'+$(this).parent().parent().find('td:nth-child(3)').html()+'</b> ?');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='YesDelete' data-url='"+Link+"'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDelete', function(e){
		e.preventDefault();
		$('#ModalGue').modal('hide');

		$.ajax({
			url: $(this).data('url'),
			type: "POST",
			cache: false,
			dataType:'json',
			success: function(data){
				$('#Notifikasi').html(data.pesan);
				$("#Notifikasi").fadeIn('fast').show().delay(3000).fadeOut('fast');
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
		});
	});

	$(document).on('click', '#TambahService, #EditService', function(e){
		e.preventDefault();
		if($(this).attr('id') == 'TambahService')
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').removeClass('modal-sm');
			$('#ModalHeader').html('Input Service');
		}
		if($(this).attr('id') == 'EditService')
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').removeClass('modal-sm');
			$('#ModalHeader').html('Edit Service');
		}
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

	function check_int(evt) {
		var charCode = ( evt.which ) ? evt.which : event.keyCode;
		return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
	}
</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>
