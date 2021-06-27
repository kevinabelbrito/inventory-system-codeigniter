<?php

/**
 * 
 */
class Variaciones extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('variaciones_model');
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
			$mensaje = "No hay variaciones registradas en el sistema";
		}
		// Cargamos el numero de filas en nuestra tabla medicamentos
		$filas = $this->variaciones_model->num_variaciones();
		// Indicamos la cantidad de links maximos por paginación
		$per_page = 10;
		// Configuramos la paginacion
		$config['base_url'] = base_url().'variaciones/index';
		$config['total_rows'] = $filas;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$data = array(
			'titulo' => 'Variaciones para Productos',
			'contenido' => 'variaciones/index_view',
			'menu' => 'variaciones',
			'num_cat' => $filas,
			'categorias' => $this->variaciones_model->listar_variaciones($per_page),
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
			redirect(base_url().'variaciones');
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
				$this->variaciones_model->agregar();
				echo "guardo";
			}
		}
	}

	public function editar($id)
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'variaciones');
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
				$this->variaciones_model->editar($id);
				echo "guardo";
			}
		}
	}

	private function validar()
	{
		//Rules
		$this->form_validation->set_rules('descripcion', 'Descripción', 'required|min_length[4]|max_length[50]|callback_very_descripcion');
		$this->form_validation->set_rules('slug', 'Slug', 'required|min_length[4]|max_length[50]|callback_very_slug');
		//Messages
		$this->form_validation->set_message('very_descripcion', '{field} ya se encuentra registrada en el sistema');
		$this->form_validation->set_message('very_slug', '{field} ya se encuentra registrada en el sistema');
	}

	function very_descripcion($descripcion)
	{
		$very = $this->variaciones_model->verificar('descripcion', $descripcion);
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

	function very_slug($slug)
	{
		$very = $this->variaciones_model->verificar('slug', $slug);
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
		$query = $this->variaciones_model->detalles($id);
		if ($query != false)
		{
			$this->variaciones_model->eliminar($id);
		}
		redirect('variaciones');
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