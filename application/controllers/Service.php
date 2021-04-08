<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------
 * CLASS NAME : Service
 * ------------------------------------------------------------------------
 *
 * @author     Muhammad Akbar <muslim.politekniktelkom@gmail.com>
 * @copyright  2016
 * @license    http://aplikasiphp.net
 *
 */

class Service extends MY_Controller
{
	public function index()
	{
		$level = $this->session->userdata('ap_level');
		if($level !== 'admin' AND $level !== 'kasir')
		{
			exit();
		}
		else
		{
			$this->load->view('service/service_data');
		}
	}

	public function service_json()
	{
		$this->load->model('m_service');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_service->fetch_data_service($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nama_service'];
			$nestedData[]	= "Rp. ".number_format($row['harga_service'],0,',','.');
			$nestedData[]	= $row['nama_konsumen'];
			$nestedData[]	= $row['no_hp_konsumen'];
			$nestedData[]	= date('d-m-Y H:i:s', strtotime($row['tgl_service']));
			$nestedData[]	= $row['nama'];

			if($row['id_user'] == $this->session->userdata('ap_id_user'))
			{
				$nestedData[]	= "<a href='".site_url('service/edit/'.$row['id_service'])."' id='EditService'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('service/hapus/'.$row['id_service'])."' id='HapusService'><i class='fa fa-trash-o'></i> Hapus</a>";
			}else {
				$nestedData[]	= "";
				$nestedData[]	= "";
			}

			// if($row['label'] == 'admin')
			// {
			// 	$nestedData[]	= '';
			// }

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data
			);

		echo json_encode($json_data);
	}

	public function hapus($id_service)
	{
		$level = $this->session->userdata('ap_level');
		if($level !== 'admin' AND $level !== 'kasir')
		{
			exit();
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('m_service');
				$hapus = $this->m_service->hapus_service($id_service);
				if($hapus)
				{
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Data berhasil dihapus !</font>
					"));
				}
				else
				{
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"));
				}
			}
		}
	}

	public function tambah()
	{
		$level = $this->session->userdata('ap_level');
		if($level !== 'admin' AND $level !== 'kasir')
		{
			exit();
		}
		else
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama_service','nama_service','trim|required|max_length[100]');
				$this->form_validation->set_rules('harga_service','Harga Konsumen','trim|required|max_length[100]|alpha_numeric');
				$this->form_validation->set_rules('nama_konsumen','Nama Konsumen','trim|required|max_length[100]|alpha_spaces');
				$this->form_validation->set_rules('no_hp_konsumen','No. HP Konsumen','trim|required|max_length[20]|alpha_numeric');

				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('alpha_spaces', '%s harus alphabet');
				$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('m_service');

					$nama_service 	= $this->input->post('nama_service');
					$harga_service 	= $this->input->post('harga_service');
					$nama_konsumen	= $this->input->post('nama_konsumen');
					$no_hp_konsumen	= $this->input->post('no_hp_konsumen');
					$tgl_service		= date('Y-m-d H:i:s');

					$insert = $this->m_service->tambah_baru($nama_service, $harga_service, $nama_konsumen, $no_hp_konsumen, $tgl_service);

					if($insert > 0)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data Service berhasil dismpan."
						));
					}
					else
					{
						$this->query_error("Oops, terjadi kesalahan, coba lagi !");
					}
				}
				else
				{
					$this->input_error();
				}
			}
			else
			{
				$this->load->model('m_akses');
				$dt['akses'] 	= $this->m_akses->get_all();
				$this->load->view('service/service_tambah', $dt);
			}
		}
	}


	public function edit($id_service = NULL)
	{
		$level = $this->session->userdata('ap_level');
		if($level !== 'admin' AND $level !== 'kasir')
		{
			exit();
		}
		else
		{
			if( ! empty($id_service))
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('m_service');

					if($_POST)
					{
						$this->load->library('form_validation');

						$this->form_validation->set_rules('nama_service','nama_service','trim|required|max_length[100]');
						$this->form_validation->set_rules('harga_service','Harga Konsumen','trim|required|max_length[100]|alpha_numeric');
						$this->form_validation->set_rules('nama_konsumen','Nama Konsumen','trim|required|max_length[100]|alpha_spaces');
						$this->form_validation->set_rules('no_hp_konsumen','No. HP Konsumen','trim|required|max_length[20]|alpha_numeric');

						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_spaces', '%s harus alphabet');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$nama_service 	= $this->input->post('nama_service');
							$harga_service 	= $this->input->post('harga_service');
							$nama_konsumen	= $this->input->post('nama_konsumen');
							$no_hp_konsumen	= $this->input->post('no_hp_konsumen');

							$update = $this->m_service->update_service($id_service, $nama_service, $harga_service, $nama_konsumen, $no_hp_konsumen);

							if($update)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data Service berhasil diupdate.</div>"
								));
							}
							else
							{
								$this->query_error();
							}
						}
						else
						{
							$this->input_error();
						}
					}
					else
					{
						$this->load->model('m_akses');
						$dt['user'] 	= $this->m_service->get_baris($id_service)->row();
						$dt['akses'] 	= $this->m_akses->get_all();
						$this->load->view('service/service_edit', $dt);
					}
				}
			}
		}
	}

}
