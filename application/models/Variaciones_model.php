<?php

/**
 * 
 */
class Variaciones_model extends CI_Model
{
	public $module = 'variaciones';
	public $key = 'id';
	public function __construct()
	{
		parent::__construct();
	}

	public function num_variaciones()
	{
		$this->db->select('*');
		$this->db->from($this->module);
		if ($this->input->get('campo'))
		{
			$this->db->like('descripcion', $this->input->get('campo'));
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function listar_variaciones($per_page = NULL)
	{
		$this->db->select('*');
		$this->db->from($this->module);
		if ($this->input->get('campo'))
		{
			$this->db->like('descripcion', $this->input->get('campo'));
		}
		$this->db->order_by('descripcion', 'asc');
		if ($per_page != NULL) {
			$this->db->limit($per_page, $this->uri->segment(3));
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function verificar($campo, $dato)
	{
		$where = array($campo => $dato);
		$query = $this->db->get_where($this->module, $where);
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function agregar()
	{
		$data = array(
			'descripcion' => $this->input->post('descripcion', true),
			'slug' => $this->input->post('slug', true),
		);
		$this->db->insert($this->module, $data);
	}

	public function detalles($id)
	{
		$where = array('id' => $id);
		$query = $this->db->get_where($this->module, $where);
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function editar($id)
	{
		$set = array(
			'descripcion' => $this->input->post('descripcion', true),
			'slug' => $this->input->post('slug', true),
		);
		$condition = array('id' => $id);
		$this->db->update($this->module, $set, $condition);
	}

	public function eliminar($id)
	{
		$this->db->delete($this->module, array('id' => $id));
	}
}

?>