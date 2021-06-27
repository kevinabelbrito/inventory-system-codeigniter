<?php

class Categorias extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('categorias_model');
		$this->very_session();
	}

	public function index()
	{
		if ($this->input->get('campo'))
		{
			$campo = $this->input->get('campo');
			$mensaje = 'Su busqueda "'.$campo.'" no arrojo resultados';
		}
		else
		{
			$campo = "";
			$mensaje = "No hay categorías registradas en el sistema";
		}
		// Cargamos el numero de filas en nuestra tabla medicamentos
		$filas = $this->categorias_model->num_cat();
		// Indicamos la cantidad de links maximos por paginación
		$per_page = 10;
		// Configuramos la paginacion
		$config['base_url'] = base_url().'categorias/index';
		$config['total_rows'] = $filas;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$data = array(
			'titulo' => 'Categorías de Productos',
			'contenido' => 'categorias/index_view',
			'menu' => 'categorias',
			'num_cat' => $filas,
			'categorias' => $this->categorias_model->listar_cat($per_page),
			'pagination' => $this->pagination->create_links(),
			'campo' => $campo,
			'mensaje' => $mensaje,
			);
		$this->load->view('plantilla', $data);
	}

	public function agregar()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'categorias');
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
				$this->categorias_model->agregar();
				echo "guardo";
			}
		}
	}

	public function editar($id)
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'categorias');
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
				$this->categorias_model->editar($id);
				echo "guardo";
			}
		}
	}

	private function validar()
	{
		//Rules
		$this->form_validation->set_rules('descripcion', 'Descripción', 'required|min_length[4]|callback_very_descripcion');
		//Messages
		$this->form_validation->set_message('very_descripcion', '{field} ya se encuentra registrada en el sistema');
	}

	function very_descripcion($descripcion)
	{
		$very = $this->categorias_model->verificar('descripcion', $descripcion);
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

	public function eliminar($id)
	{
		$query = $this->categorias_model->detalles($id);
		if ($query != false)
		{
			$this->categorias_model->eliminar($id);
		}
		redirect('categorias');
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