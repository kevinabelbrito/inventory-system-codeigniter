<?php

class Clientes_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function num_clientes()
	{
		$this->db->select('*');
		$this->db->from('cliente');
		if ($this->input->get('campo'))
		{
			$this->db->like('nombre', $this->input->get('campo'));
			$this->db->or_like('documento', $this->input->get('campo'));
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function listar_clientes($per_page = NULL)
	{
		$this->db->select('*');
		$this->db->from('cliente');
		if ($this->input->get('campo'))
		{
			$this->db->like('nombre', $this->input->get('campo'));
			$this->db->or_like('documento', $this->input->get('campo'));
		}
		$this->db->order_by('nombre', 'asc');
		if ($per_page != NULL) {
			$this->db->limit($per_page, $this->uri->segment(3));
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function verificar($campo, $dato)
	{
		$where = array($campo => $dato);
		$query = $this->db->get_where('cliente', $where);
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
			'documento' => $this->input->post('documento', true),
			'nombre' => $this->input->post('nombre', true),
			'email' => $this->input->post('email', true),
			'tlf' => $this->input->post('tlf', true),
			'direccion' => $this->input->post('direccion', true),
			);
		$this->db->insert('cliente', $data);
	}

	public function detalles($id)
	{
		$where = array('id' => $id);
		$query = $this->db->get_where('cliente', $where);
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
			'documento' => $this->input->post('documento', true),
			'nombre' => $this->input->post('nombre', true),
			'email' => $this->input->post('email', true),
			'tlf' => $this->input->post('tlf', true),
			'direccion' => $this->input->post('direccion', true),
			);
		$condition = array('id' => $id);
		$this->db->update('cliente', $set, $condition);
	}

	public function eliminar($id)
	{
		$this->db->delete('cliente', array('id' => $id));
	}
}

?>