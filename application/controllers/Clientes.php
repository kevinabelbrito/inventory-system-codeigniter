<?php

class Clientes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('clientes_model');
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
		$filas = $this->clientes_model->num_clientes();
		$per_page = 10;
		// Configuramos la paginacion
		$config['base_url'] = base_url().'clientes/index';
		$config['total_rows'] = $filas;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$data = array(
			'titulo' => 'Clientes',
			'contenido' => 'clientes/index_view',
			'menu' => 'clientes',
			'num_clientes' => $filas,
			'clientes' => $this->clientes_model->listar_clientes($per_page),
			'pagination' => $this->pagination->create_links(),
			'campo' => $campo,
			);
		$this->load->view('plantilla', $data);
	}

	public function agregar()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'clientes');
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
				$this->clientes_model->agregar();
				echo "guardo";
			}
		}
	}

	public function editar($id)
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'clientes');
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
				$this->clientes_model->editar($id);
				echo "guardo";
			}
		}
	}

	private function validar()
	{
		// Rules
		$this->form_validation->set_rules('documento', 'Cedula/RIF', 'required|callback_very_documento|trim');
		$this->form_validation->set_rules('nombre', 'Nombre/Razón Social', 'required');
		$this->form_validation->set_rules('tlf', 'Teléfono', 'required|integer|trim');
		$this->form_validation->set_rules('email', 'Correo Electrónico', 'valid_email|trim');
		$this->form_validation->set_rules('direccion', 'Dirección', 'required');
		// Messages
		/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');
		$this->form_validation->set_message('integer', '{field} debe contener solo numeros enteros');
		$this->form_validation->set_message('valid_email', '{field} debe ser una direccion de correo electrónico valida');*/
		$this->form_validation->set_message('very_documento', '{field} ya se encuentra registrado');
	}

	function very_documento($documento)
	{
		$very = $this->clientes_model->verificar('documento', $documento);
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
		$detalles = $this->clientes_model->detalles($id);
		$this->clientes_model->eliminar($id);
		redirect(base_url().'clientes');
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