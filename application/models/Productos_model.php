<?php

class Productos_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function num_medicamentos()
	{
		$this->db->select('p.id, p.codigo, p.nombre, p.id_categoria, c.descripcion, p.precio, p.stock');
		$this->db->from('productos p');
		$this->db->join('categorias c', 'p.id_categoria = c.id');
		if ($this->input->get('campo'))
		{
			$this->db->like('p.nombre', $this->input->get('campo'));
			$this->db->or_like('p.codigo', $this->input->get('campo'));
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function listar_medicamentos($per_page = NULL)
	{
		$this->db->select('p.id, p.codigo, p.nombre, p.id_categoria, c.descripcion, p.precio, p.stock');
		$this->db->from('productos p');
		$this->db->join('categorias c', 'p.id_categoria = c.id');
		if ($this->input->get('campo'))
		{
			$this->db->like('p.nombre', $this->input->get('campo'));
			$this->db->or_like('p.codigo', $this->input->get('campo'));
		}
		$this->db->order_by('p.nombre', 'asc');
		if ($per_page != NULL) {
			$this->db->limit($per_page, $this->uri->segment(3));
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function verificar($campo, $dato)
	{
		$where = array($campo => $dato);
		$query = $this->db->get_where('productos', $where);
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function validar($codigo)
	{
		$this->db->select('*');
		$this->db->from('productos');
		$this->db->where('codigo', $codigo);
		$this->db->or_where('nombre', $codigo);
		$query = $this->db->get();
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
			'codigo' => $this->input->post('codigo', true),
			'nombre' => $this->input->post('nombre', true),
			'id_categoria' => $this->input->post('categoria', true),
			'precio' => $this->input->post('precio', true),
			'stock' => $this->input->post('stock', true),
			);
		$this->db->insert('productos', $data);
	}

	public function detalles($id)
	{
		$where = array('id' => $id);
		$query = $this->db->get_where('productos', $where);
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
			'codigo' => $this->input->post('codigo', true),
			'nombre' => $this->input->post('nombre', true),
			'id_categoria' => $this->input->post('categoria', true),
			'precio' => $this->input->post('precio', true),
			'stock' => $this->input->post('stock', true),
			);
		$condition = array('id' => $id);
		$this->db->update('productos', $set, $condition);
	}

	public function eliminar($id)
	{
		$this->db->delete('productos', array('id' => $id));
	}

	public function cargar_cat()
	{
		$this->db->order_by('descripcion', 'asc');
		$query = $this->db->get('categorias');
		return $query->result();
	}
}

?>