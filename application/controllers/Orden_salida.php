<?php

class orden_salida extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('orden_salida_model');
		$this->load->model('clientes_model');
		$this->load->model('productos_model');
		$this->very_session();
	}

	public function index()
	{
		if ($this->input->get('campo'))
		{
			$campo = $this->input->get('campo');
		}
		else
		{
			$campo = "";
		}
		// Indicamos el numero de filas y links
		$filas = $this->orden_salida_model->num_facturas();
		$per_page = 10;
		// configuramos algunos parametros basicos de la paginacion
		$config['base_url'] = base_url().'orden_salida/index';
		$config['total_rows'] = $filas;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$data = array(
			'titulo' => 'Orden de Salida',
			'contenido' => 'orden_salida/index_view',
			'menu' => 'orden_salida',
			'num_facturas' => $filas,
			'facturas' => $this->orden_salida_model->listar_facturas($per_page),
			'pagination' => $this->pagination->create_links(),
			'campo' => $campo,
			);
		$this->load->view('plantilla', $data);
	}

	public function nueva()
	{
		if (!$this->input->is_ajax_request())
		{
			$this->cart->destroy();
			$data = array(
				'titulo' => 'Nueva Orden de Salida',
				'contenido' => 'orden_salida/nueva_view',
				'menu' => 'orden_salida',
				'clientes' => $this->obtenerClientes(),
				'productos' => $this->obtenerProductos()
				);
			$this->load->view('plantilla', $data);
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('abono', 'Monto a abonar', 'required|numeric|callback_very_numero|callback_very_monto');
			$this->form_validation->set_rules('fecha_actual', 'Fecha de la Factura', 'required');
			$this->form_validation->set_rules('fecha_vencimiento', 'Fecha de Vencimiento', 'required|callback_very_fecha');
			$this->form_validation->set_rules('id_cliente', 'Cliente', 'required|integer');
			// Messages
			/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			$this->form_validation->set_message('integer', '{field} solo debe contener numeros enteros');
			$this->form_validation->set_message('numeric', '{field} solo debe contener numeros');*/
			$this->form_validation->set_message('very_numero', '{field} no puede ser menor a 0');
			$this->form_validation->set_message('very_fecha', '{field} no puede ser menor a la fecha de la factura');
			$this->form_validation->set_message('very_monto', '{field} no puede ser mayor al precio total de la compra');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				if ($this->cart->total_items() == 0)
				{
					echo "productos";
				}
				else
				{
					$this->orden_salida_model->crear_factura();
					echo "bien";
				}
			}
		}
	}

	function very_numero($abono)
	{
		if ($abono < 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function very_monto($abono)
	{
		if ($abono > $this->cart->total())
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function very_fecha($fecha_vencimiento)
	{
		if ($this->input->post('fecha_actual'))
		{
			$fecha_actual = $this->input->post('fecha_actual');
			if ($fecha_actual > $fecha_vencimiento)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}

	public function validar()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect('404');
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('documento', 'Documento de Identidad', 'required|callback_very_cliente|trim');
			// Messages
			/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');*/
			$this->form_validation->set_message('very_cliente', 'El cliente no está registrado en la Base de datos');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				echo "bien";
			}
		}
	}

	public function cargar_cliente()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect('404');
		}
		else
		{
			$query = $this->clientes_model->verificar('documento', $this->input->get('documento'));
			$datos = new stdClass();
			$datos->id = $query->id;
			$datos->nombre = $query->nombre;
			$datos->tlf = $query->tlf;
			$datos->email = $query->email;
			$datos->direccion = $query->direccion;
			$json = json_encode($datos);
			echo $json;
		}
	}

	function very_cliente($documento)
	{
		$very = $this->clientes_model->verificar('documento', $documento);
		if ($very != false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function validar_medic()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect('404');
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('codigo', 'Codigo', 'required|callback_very_medic');
			// Messages
			/*$this->form_validation->set_message('required', '{field} es un campo requerido');
			$this->form_validation->set_message('integer', '{field} solo debe contener numeros enteros');*/
			$this->form_validation->set_message('very_medic', 'No se encontró el producto en la Base de datos');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				echo "bien";
			}
		}
	}

	public function cargar_medic()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect('404');
		}
		else
		{
			$query = $this->productos_model->validar($this->input->get('codigo'));
			$datos = new stdClass();
			$datos->id_medicamento = $query->id;
			$datos->codigo = $query->codigo;
			$datos->nombre_medic = $query->nombre;
			$datos->precio = $query->precio;
			$json = json_encode($datos);
			echo $json;
		}
	}

	function very_medic($codigo)
	{
		$very = $this->productos_model->validar($codigo);
		if ($very != false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function agregar_medic()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect('404');
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required|is_natural_no_zero|callback_very_cantidad');
			// Messages
			/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			$this->form_validation->set_message('is_natural_no_zero', '{field} debe ser mayor a 0');*/
			$this->form_validation->set_message('very_cantidad', 'La cantidad que trata de agregar es mayor a la existente');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				$data = array(
			        'id'      => $this->input->post('id_medicamento'),
			        'qty'     => $this->input->post('cantidad'),
			        'price'   => $this->input->post('precio'),
			        'name'    => $this->input->post('nombre'),
			        'options' => array('codigo' => $this->input->post('codigo'))
				);

				$this->cart->insert($data);
				echo "recargar";
			}
		}
	}

	function very_cantidad($cantidad)
	{
		$very = $this->productos_model->verificar('id', $this->input->post('id_medicamento'));
		if ($very == false)
		{
			return false;
		}
		else
		{
			$productos_carrito = 0;
			foreach ($this->cart->contents() as $items)
			{
				if ($items['id'] == $very->id)
				{
					$productos_carrito = $items['qty'];
				}
			}
			$cantidad_real = $very->stock - $productos_carrito;
			if ($cantidad_real < $cantidad)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	public function listar_productos()
	{
		$this->load->view('orden_salida/productos_view');
	}

	public function cargar_ultima_factura()
	{
		$orden_salida = $this->orden_salida_model->cargar_ultima_factura();
		echo $orden_salida->id;
	}

	function eliminar_producto($rowId)
	{
		$this->cart->remove($rowId);
	}

	function vaciar_carrito()
	{
		$this->cart->destroy();
		echo "vaciado";
	}

	public function detalles($id)
	{
		$detalles = $this->orden_salida_model->detalles_factura($id);
		if ($detalles == false)
		{
			redirect('404');
		}
		else
		{
			$data = array(
				'titulo' => 'Detalles de la Orden de Salida',
				'contenido' => 'orden_salida/orden_salida_view',
				'menu' => 'orden_salida',
				'id' => $id,
				'id_cliente' => $detalles->id_cliente,
				'documento' => $detalles->documento,
				'nombre' => $detalles->nombre,
				'total_final' => $detalles->total_final,
				'abono' => $detalles->abono,
				'fecha_actual' => $detalles->fecha_actual,
				'fecha_vencimiento' => $detalles->fecha_vencimiento,
				);
			$this->load->view('plantilla', $data);
		}
	}

	public function abonar()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect('404');
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('monto', 'Monto a Abonar', 'required|numeric|callback_very_monto_abonar');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required|callback_very_fecha_abono');
			// Messages
			/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			$this->form_validation->set_message('numeric', '{field} solo debe contener numeros');*/
			$this->form_validation->set_message('very_monto_abonar', '{field} es mayor al monto de la deuda');
			$this->form_validation->set_message('very_fecha_abono', '{field} no debe ser mayor a la fecha actual o menor a la fecha de la factura');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				$id = $this->input->post('id_factura');
				$abonado = $this->input->post('monto');
				$factura = $this->orden_salida_model->detalles_factura($id);
				$abono = $factura->abono + $abonado;
				$this->orden_salida_model->actualizar_factura($id, $abono);
				$this->orden_salida_model->abonar($id);
				echo "bien";
			}
		}
	}

	function very_monto_abonar($monto)
	{
		$id = $this->input->post('id_factura');
		$very = $this->orden_salida_model->very_abono($id);
		$deuda = $very->total_final - $very->abono;
		if ($deuda < $monto)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function very_fecha_abono($fecha)
	{
		if ($this->input->post('fecha_actual') > $fecha)
		{
			return false;
		}
		elseif ($fecha > date("Y-m-d"))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function imprimir_factura($id)
	{
		$detalles = $this->orden_salida_model->detalles_factura($id);
		if ($detalles == false)
		{
			redirect('404');
		}
		else
		{
			$name_doc = "Orden_nro_".$id."_".$detalles->nombre."_".$detalles->fecha_actual;
			$view = "orden_salida/imprimir_orden_salida_view";
			$data = array(
				'id' => $id,
				'id_cliente' => $detalles->id_cliente,
				'documento' => $detalles->documento,
				'nombre' => $detalles->nombre,
				'total_final' => $detalles->total_final,
				'abono' => $detalles->abono,
				'fecha_actual' => $detalles->fecha_actual,
				'fecha_vencimiento' => $detalles->fecha_vencimiento,
			);
			$this->reporte_pdf($name_doc, $view, $data);
		}
	}

	//Generar los reportes en formato PDF
	private function reporte_pdf($name_doc, $view, $data)
	{
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		set_time_limit(320);
		ob_start();
		$this->load->view($view, $data);
		$doc = $name_doc.'.pdf';
		$content = ob_get_clean();
		require_once(APPPATH.'third_party/html2pdf/html2pdf.class.php');
		//Si indicamos el valor P sale vertical y L seria horizontal
		$pdf = new HTML2PDF('P', 'A4', 'es', 'UTF-8');
		$pdf->writeHTML($content);
		//$pdf->pdf->IncludeJS('print(TRUE)');
		$pdf->output($doc);
	}

	function eliminar($id)
	{
		$detalles = $this->orden_salida_model->detalles_factura($id);
		if ($detalles == false)
		{
			redirect('404');
		}
		else
		{
			$this->orden_salida_model->eliminar($id);
			redirect('orden_salida');
		}
	}

	private function obtenerClientes()
	{
		$clientes = $this->clientes_model->listar_clientes();
		$options = ['' => 'Seleccione un cliente'];
		foreach ($clientes as $row) {
			$options += [$row->documento => $row->nombre.' - '.$row->documento];
		}
		return $options;
	}

	private function obtenerProductos()
	{
		$clientes = $this->productos_model->listar_medicamentos();
		$options = ['' => 'Seleccione un producto'];
		foreach ($clientes as $row) {
			$options += [$row->codigo => $row->codigo.' - '.$row->nombre];
		}
		return $options;
	}

	private function very_session()
	{
		if ($this->session->userdata('username') == '')
		{
			redirect(base_url());
		}
	}
}

?>
