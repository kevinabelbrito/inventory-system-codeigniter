<?php

class Usuarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuarios_model');
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
		$filas = $this->usuarios_model->num_users();
		$per_page = 10;
		// Configuramos la paginacion
		$config['base_url'] = base_url().'usuarios/index';
		$config['total_rows'] = $filas;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$data = array(
			'titulo' => 'Usuarios de Sistema',
			'contenido' => 'usuarios/index_view',
			'menu' => 'usuarios',
			'num_users' => $filas,
			'usuarios' => $this->usuarios_model->listar_usuarios($per_page),
			'pagination' => $this->pagination->create_links(),
			'campo' => $campo,
			'preguntas' => $this->preguntas(),
			'tipos' => $this->tipos(),
			);
		$this->load->view('plantilla', $data);
	}

	public function agregar()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'usuarios');
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('nombre', 'Nombre Completo', 'required');
			$this->form_validation->set_rules('cedula', 'Cedula de Identidad', 'required|integer|callback_very_cedula|trim');
			$this->form_validation->set_rules('email', 'Correo Electrónico', 'required|valid_email|callback_very_email|trim');
			$this->form_validation->set_rules('username', 'Usuario', 'required|min_length[8]|callback_very_user');
			$this->form_validation->set_rules('tipo', 'Tipo', 'required');
			$this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[8]');
			$this->form_validation->set_rules('conf', 'Confirmar', 'required|matches[password]');
			$this->form_validation->set_rules('preg', 'Pregunta de Seguridad', 'required');
			$this->form_validation->set_rules('respuesta', 'Respuesta secreta', 'required');
			// Messages
			$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			$this->form_validation->set_message('integer', '{field} debe estar compuesto solo por numeros enteros');
			$this->form_validation->set_message('valid_email', '{field} debe ser una direccion de correo electrónico valida');

			$this->form_validation->set_message('matches', 'Las contraseñas no coinciden entre si');
			$this->form_validation->set_message('min_length', '{field} debe estar compuesto de al menos {param} caracteres');
			$this->form_validation->set_message('very_user', 'El {field} ya se encuentra en uso');
			$this->form_validation->set_message('very_cedula', 'La {field} ya se encuentra registrada en otro usuario');
			$this->form_validation->set_message('very_email', 'El {field} ya fue registrado en una cuenta de usuario');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>','</li>');
			}
			else
			{
				$this->usuarios_model->agregar();
				echo "guardo";
			}
		}
	}

	public function editar($id)
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'usuarios');
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('nombre', 'Nombre Completo', 'required');
			$this->form_validation->set_rules('cedula', 'Cedula de Identidad', 'required|integer|callback_very_cedula|trim');
			$this->form_validation->set_rules('email', 'Correo Electrónico', 'required|valid_email|callback_very_email|trim');
			$this->form_validation->set_rules('username', 'Usuario', 'required|min_length[8]|callback_very_user');
			$this->form_validation->set_rules('tipo', 'Tipo', 'required');
			// Messages
			$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			$this->form_validation->set_message('integer', '{field} debe estar compuesto solo por numeros enteros');
			$this->form_validation->set_message('valid_email', '{field} debe ser una direccion de correo electrónico valida');
			$this->form_validation->set_message('min_length', '{field} debe estar compuesto de al menos {param} caracteres');
			$this->form_validation->set_message('very_user', 'El {field} ya se encuentra en uso');
			$this->form_validation->set_message('very_cedula', 'La {field} ya se encuentra registrada en otro usuario');
			$this->form_validation->set_message('very_email', 'El {field} ya fue registrado en una cuenta de usuario');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>','</li>');
			}
			else
			{
				$this->usuarios_model->editar($id);
				echo "guardo";
			}

		}
	}

	private function preguntas()
	{
		$options = array(
			'' => '-',
			'¿Cuál es su clave más utilizada en redes sociales?' => '¿Cuál es su clave más utilizada en redes sociales?',
			'¿Una Fecha a recordar?' => '¿Una Fecha a recordar?',
			'¿Cuál es su número de calzado?' => '¿Cuál es su número de calzado?',
			'¿Cuál es su secreto jamás contado?' => '¿Cuál es su secreto jamás contado?',
			'¿Cómo se apellidaba su maestro (a)  de 4to Grado?' => '¿Cómo se apellidaba su maestro (a)  de 4to Grado?',
			'¿Cuál es el 4to número de su clave secreta bancaria mas utilizada?' => '¿Cuál es el 4to número de su clave secreta bancaria mas utilizada?',
			);
		return $options;
	}

	private function tipos()
	{
		$options = array(
			'' => '-',
			'Administrador' => 'Administrador',
			'Editor' => 'Editor',
			);
		return $options;
	}

	function very_user($username)
	{
		$very = $this->usuarios_model->verificar('username', $username);
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

	function very_email($email)
	{
		$very = $this->usuarios_model->verificar('email', $email);
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

	function very_cedula($cedula)
	{
		$very = $this->usuarios_model->verificar('cedula', $cedula);
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
		$detalles = $this->usuarios_model->detalles($id);
		$this->usuarios_model->eliminar($id);
		redirect(base_url().'usuarios');
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