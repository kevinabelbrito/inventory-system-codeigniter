<?php

class Orden_salida_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function num_facturas()
	{
		$this->db->select('*');
		$this->db->from('orden_salida');
		if ($this->input->get('campo'))
		{
			$this->db->like('fecha_actual', $this->input->get('campo'));
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function listar_facturas($per_page)
	{
		$this->db->select('c.nombre, c.documento, f.id, f.abono, f.total_final, f.fecha_actual, f.fecha_vencimiento');
		$this->db->from('orden_salida f');
		$this->db->join('cliente c', 'f.id_cliente = c.id');
		if ($this->input->get('campo'))
		{
			$this->db->like('fecha_actual', $this->input->get('campo'));
		}
		$this->db->order_by('f.id', 'desc');
		$this->db->limit($per_page, $this->uri->segment(3));
		$query = $this->db->get();
		return $query->result();
	}

	public function crear_factura()
	{
		$data = array(
			'id_cliente' => $this->input->post('id_cliente', true),
			'abono' => $this->input->post('abono', true),
			'total_final' => $this->cart->total(),
			'fecha_actual' => $this->input->post('fecha_actual', true),
			'fecha_vencimiento' => $this->input->post('fecha_vencimiento', true),
			);
		$this->db->insert('orden_salida', $data);
		$id_orden = $this->db->insert_id();
		// Agregamos el abono en caso de aplicar
		if ($this->input->post('abono') > 0)
		{
			$data = array(
				'id_orden' => $id_orden,
				'monto' => $this->input->post('abono', true),
				'fecha' => $this->input->post('fecha_actual', true),
				);
			$this->db->insert('abonos', $data);
		}
		foreach ($this->cart->contents() as $items)
		{
			// Agregarmos los productos en la tabla productos_orden
			$data = array(
				'id_orden' => $id_orden,
				'id_producto' => $items['id'],
				'cantidad' => $items['qty'],
				'precio' => $items['price'],
				'sub_total' => $items['subtotal'],
				);
			$this->db->insert('productos_orden', $data);
			// Restamos del stock los productos despachados
			$query = $this->db->get_where('productos', array('id' => $items['id']));
			$producto = $query->row();
			$restar_cantidad = $producto->stock - $items['qty'];
			$set = array('stock' => $restar_cantidad);
			$condicion = array('id' => $items['id']);
			$this->db->update('productos', $set, $condicion);
		}
	}

	public function cargar_ultima_factura()
	{
		$this->db->order_by('id', 'desc');
		$orden_salida = $this->db->get('orden_salida');
		return $orden_salida->row();
	}

	public function detalles_factura($id)
	{
		$this->db->join('cliente', 'orden_salida.id_cliente = cliente.id');
		$query = $this->db->get_where('orden_salida', array('orden_salida.id' => $id));
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function cargar_abonos_factura($id)
	{
		$this->db->order_by('fecha', 'asc');
		$query = $this->db->get_where('abonos', array('id_orden' => $id));
		return $query->result();
	}

	public function cargar_productos_factura($id)
	{
		$this->db->select('m.codigo, m.nombre, f.cantidad, f.precio, f.sub_total');
		$this->db->from('productos_orden f');
		$this->db->join('productos m', 'f.id_producto = m.id');
		$this->db->where('f.id_orden', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function very_abono($id)
	{
		$query = $this->db->get_where('orden_salida', array('id' => $id));
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function abonar($id_orden)
	{
		$data = array(
			'id_orden' => $id_orden,
			'monto' => $this->input->post('monto', true),
			'fecha' => $this->input->post('fecha', true),
			);
		$this->db->insert('abonos', $data);
	}

	public function actualizar_factura($id, $abono)
	{
		$set = array(
			'abono' => $abono,
			);
		$condicion = array('id' => $id);
		$this->db->update('orden_salida', $set, $condicion);
	}

	public function eliminar($id)
	{
		$this->db->delete('orden_salida', array('id' => $id));
	}
}

?>
