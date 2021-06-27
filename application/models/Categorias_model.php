<?php

class Categorias_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function num_cat()
	{
		$this->db->select('*');
		$this->db->from('categorias');
		if ($this->input->get('campo'))
		{
			$this->db->like('descripcion', $this->input->get('campo'));
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function listar_cat($per_page)
	{
		$this->db->select('*');
		$this->db->from('categorias');
		if ($this->input->get('campo'))
		{
			$this->db->like('descripcion', $this->input->get('campo'));
		}
		$this->db->order_by('descripcion', 'asc');
		$this->db->limit($per_page, $this->uri->segment(3));
		$query = $this->db->get();
		return $query->result();
	}

	public function verificar($campo, $dato)
	{
		$where = array($campo => $dato);
		$query = $this->db->get_where('categorias', $where);
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
		$data = array('descripcion' => $this->input->post('descripcion', true));
		$this->db->insert('categorias', $data);
	}

	public function detalles($id)
	{
		$where = array('id' => $id);
		$query = $this->db->get_where('categorias', $where);
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
		$set = array('descripcion' => $this->input->post('descripcion', true));
		$condition = array('id' => $id);
		$this->db->update('categorias', $set, $condition);
	}

	public function eliminar($id)
	{
		$this->db->delete('categorias', array('id' => $id));
	}
}

?>