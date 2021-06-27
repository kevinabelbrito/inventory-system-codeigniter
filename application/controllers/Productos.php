<?php

class Productos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('productos_model');
		$this->very_session();
	}

	public function index()
	{
		if ($this->input->get('campo'))
		{
			$campo = $this->input->get('campo');
			$mensaje = 'La busqueda "'.$campo.'" no arrojo resultados';
		}
		else
		{
			$campo = "";
			$mensaje = "No hay productos registrados en el sistema";
		}
		// Cargamos el numero de filas en nuestra tabla medicamentos
		$filas = $this->productos_model->num_medicamentos();
		// Indicamos la cantidad de links maximos por paginación
		$per_page = 10;
		// Configuramos la paginacion
		$config['base_url'] = base_url().'productos/index';
		$config['total_rows'] = $filas;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$data = array(
			'titulo' => 'Productos',
			'contenido' => 'productos/index_view',
			'menu' => 'productos',
			'num_medicamentos' => $filas,
			'medicamentos' => $this->productos_model->listar_medicamentos($per_page),
			'pagination' => $this->pagination->create_links(),
			'campo' => $campo,
			'mensaje' => $mensaje,
			'categorias' => $this->categorias(),
			);
		$this->load->view('plantilla', $data);
	}

	public function agregar()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'productos');
		}
		else
		{
			$this->validar();
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				$this->productos_model->agregar();
				echo "guardo";
			}
		}
	}

	public function editar($id)
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'productos');
		}
		else
		{
			$this->validar();
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				$this->productos_model->editar($id);
				echo "guardo";
			}
		}
	}

	private function validar()
	{
		// Rules
		$this->form_validation->set_rules('codigo', 'Código', 'required|alpha_numeric|callback_very_codigo|trim');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('categoria', 'Categoría', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('precio', 'Precio Unitario', 'required|numeric');
		$this->form_validation->set_rules('stock', 'Stock', 'required|integer|is_natural');
		//Messages
		/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');
		$this->form_validation->set_message('integer', '{field} debe contener solo numeros enteros');
		$this->form_validation->set_message('numeric', '{field} debe contener solo numeros');
		$this->form_validation->set_message('is_natural', '{field} no puede ser menor a 0');*/
		$this->form_validation->set_message('very_codigo', 'El {field} ya se encuentra asignado a un producto');
	}

	private function categorias()
	{
		$options = array('' => '-',);
		$categorias = $this->productos_model->cargar_cat();
		foreach ($categorias as $cat)
		{
			$options += array($cat->id => $cat->descripcion,);
		}
		return $options;
	}

	function very_codigo($codigo)
	{
		$very = $this->productos_model->verificar('codigo', $codigo);
		if ($very == false)
		{
			return true;
		}
		else
		{
			if ($this->input->post('id'))
			{
				if ($this->input->post('id') == $very->id)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
	}

	function eliminar($id)
	{
		$detalles = $this->productos_model->detalles($id);
		if ($detalles =! false)
		{
			$this->productos_model->eliminar($id);
		}
		redirect('productos');
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