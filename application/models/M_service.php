<?php
class M_service extends CI_Model
{

	function fetch_data_service($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT
				(@row:=@row+1) AS nomor,
				a.`id_service`,
				a.`nama_service`,
				a.`harga_service`,
				a.`nama_konsumen`,
				a.`no_hp_konsumen`,
				a.`tgl_service`,
				b.`id_user`,
				b.`nama`
			FROM
				`service` AS a
				LEFT JOIN `pj_user` AS b ON a.`id_user` = b.`id_user`
				, (SELECT @row := 0) r WHERE 1=1
				AND a.`dihapus` = 'tidak'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if( ! empty($like_value))
		{
			$sql .= " AND ( ";
			$sql .= "
				a.`nama_service` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`tgl_service` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`nama_konsumen` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`nama_service`',
			2 => 'a.`harga_service`',
			3 => 'a.`nama_konsumen`',
			4 => 'a.`no_hp_konsumen`',
			5 => 'a.`tgl_service`',
			6 => 'b.`nama`'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function hapus_service($id_service)
	{
		$dt['dihapus'] = 'ya';
		return $this->db
				->where('id_service', $id_service)
				->update('service', $dt);
	}

	function tambah_baru($nama_service, $harga_service, $nama_konsumen, $no_hp_konsumen, $tgl_service)
	{
		$dt = array(
			'nama_service'	 => $nama_service,
			'harga_service'  => $harga_service,
			'nama_konsumen'  => $nama_konsumen,
			'no_hp_konsumen' => $no_hp_konsumen,
			'tgl_service' 	 => $tgl_service,
			'id_user'			   => $this->session->userdata('ap_id_user')
		);

		return $this->db->insert('service', $dt);
	}

	function get_baris($id_service)
	{
		$sql = "
			SELECT
				a.`id_service`,
				a.`nama_service`,
				a.`harga_service`,
				a.`nama_konsumen`,
				a.`no_hp_konsumen`,
				a.`tgl_service`,
				b.`nama`
			FROM
				`service` AS a
				LEFT JOIN `pj_user` AS b ON a.`id_user` = b.`id_user`
			WHERE
				a.`id_service` = '".$id_service."'
			LIMIT 1
		";

		return $this->db->query($sql);
	}

	function update_service($id_service, $nama_service, $harga_service, $nama_konsumen, $no_hp_konsumen)
	{
		$dt = array(
			'nama_service'	 => $nama_service,
			'harga_service'  => $harga_service,
			'nama_konsumen'  => $nama_konsumen,
			'no_hp_konsumen' => $no_hp_konsumen
		);
		return $this->db
			->where('id_service', $id_service)
			->update('service', $dt);
	}

}
