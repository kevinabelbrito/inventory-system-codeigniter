<?php

class Usuarios_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function num_users()
	{
		$this->db->select('*');
		$this->db->from('usuarios');
		if ($this->input->get('campo'))
		{
			$this->db->like('nombre', $this->input->get('campo'));
			$this->db->or_like('cedula', $this->input->get('campo'));
			$this->db->or_like('username', $this->input->get('campo'));
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function listar_usuarios($per_page)
	{
		$this->db->select('*');
		$this->db->from('usuarios');
		if ($this->input->get('campo'))
		{
			$this->db->like('nombre', $this->input->get('campo'));
			$this->db->or_like('cedula', $this->input->get('campo'));
			$this->db->or_like('username', $this->input->get('campo'));
		}
		$this->db->order_by('nombre', 'asc');
		$this->db->limit($per_page, $this->uri->segment(3));
		$query = $this->db->get();
		return $query->result();
	}
	
	public function verificar($campo, $dato)
	{
		$where = array($campo => $dato);
		$query = $this->db->get_where('usuarios', $where);
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
			'nombre' => $this->input->post('nombre', true),
			'cedula' => $this->input->post('cedula', true),
			'email' => $this->input->post('email', true),
			'username' => $this->input->post('username', true),
			'tipo' => $this->input->post('tipo', true),
			'password' => $this->input->post('password', true),
			'preg' => $this->input->post('preg', true),
			'resp' => $this->input->post('respuesta', true),
			);
		$this->db->insert('usuarios', $data);
	}

	public function detalles($id)
	{
		$where = array('id' => $id);
		$query = $this->db->get_where('usuarios', $where);
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
			'nombre' => $this->input->post('nombre', true),
			'cedula' => $this->input->post('cedula', true),
			'email' => $this->input->post('email', true),
			'username' => $this->input->post('username', true),
			'tipo' => $this->input->post('tipo', true),
			);
		$condition = array('id' => $id);
		$this->db->update('usuarios', $set, $condition);
	}

	public function eliminar($id)
	{
		$this->db->delete('usuarios', array('id' => $id));
	}
}

?>