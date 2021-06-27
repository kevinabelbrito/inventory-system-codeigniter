<?php

class Admin_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		$where = array(
			'username' => $this->input->post('username', true),
			'password' => $this->input->post('password', true),
			);
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
			'preg' => $this->input->post('preg', true),
			'resp' => $this->input->post('respuesta', true),
			);
		$condition = array('id' => $id);
		$this->db->update('usuarios', $set, $condition);
	}

	public function recuperar()
	{
		$where = array(
			'cedula' => $this->input->post('cedula'),
			'preg' => $this->input->post('preg'),
			'resp' => $this->input->post('respuesta'),
			);
		$query = $this->db->get_where('usuarios', $where);
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function cambiar_clave()
	{
		$set = array('password' => $this->input->post('nueva'));
		$condition = array('id' => $this->session->userdata('id'));
		$this->db->update('usuarios', $set, $condition);
	}
}

?>