<?php

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->model('usuarios_model');
		$this->very_session();
	}

	public function index()
	{
		$data = array(
			'contenido' => 'admin/menu_view',
			'preguntas' => $this->preguntas(),
			);
		$this->load->view('plantilla', $data);
	}

	public function editar()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'admin');
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('nombre', 'Nombre Completo', 'required');
			$this->form_validation->set_rules('cedula', 'Cedula de Identidad', 'required|integer|callback_very_cedula|trim');
			$this->form_validation->set_rules('email', 'Correo Electrónico', 'required|valid_email|callback_very_email|trim');
			$this->form_validation->set_rules('username', 'Usuario', 'required|min_length[8]|callback_very_user');
			$this->form_validation->set_rules('preg', 'Pregunta de Seguridad', 'required');
			$this->form_validation->set_rules('respuesta', 'Respuesta secreta', 'required');
			// Messages
			/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			$this->form_validation->set_message('integer', '{field} debe estar compuesto solo por numeros enteros');
			$this->form_validation->set_message('valid_email', '{field} debe ser una direccion de correo electrónico valida');
			$this->form_validation->set_message('min_length', '{field} debe estar compuesto de al menos {param} caracteres');*/
			$this->form_validation->set_message('very_user', 'El {field} ya se encuentra en uso');
			$this->form_validation->set_message('very_cedula', 'La {field} ya se encuentra registrada en otro usuario');
			$this->form_validation->set_message('very_email', 'El {field} ya fue registrado en una cuenta de usuario');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>','</li>');
			}
			else
			{
				$id = $this->session->userdata('id');
				$this->admin_model->editar($id);
				$data = array(
					'nombre' => $this->input->post('nombre', true),
					'cedula' => $this->input->post('cedula', true),
					'email' => $this->input->post('email', true),
					'username' => $this->input->post('username', true),
					'preg' => $this->input->post('preg', true),
					'resp' => $this->input->post('respuesta', true),
					);
				$this->session->set_userdata($data);
				echo "guardo";
			}
		}
	}

	public function cambio_clave()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url().'admin');
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('actual', 'Contraseña actual', 'required|callback_very_clave');
			$this->form_validation->set_rules('nueva', 'Nueva Contraseña', 'required|min_length[8]|differs[actual]');
			$this->form_validation->set_rules('conf', 'Confirmar Contraseña', 'required|matches[nueva]');
			// Messages
			/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			$this->form_validation->set_message('min_length', '{field} debe contener al menos {param} caracteres');
			$this->form_validation->set_message('differs', '{field} debe ser diferente de {param}');
			$this->form_validation->set_message('matches', '{field} y {param} deben ser iguales');*/
			$this->form_validation->set_message('very_clave', '{field} no es correcto');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				$this->admin_model->cambiar_clave();
				$this->session->set_userdata('password', $this->input->post('conf'));
				echo "bien";
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

	function very_user($username)
	{
		$very = $this->usuarios_model->verificar('username', $username);
		if ($very == false)
		{
			return true;
		}
		else
		{
			if ($this->session->userdata('id') == $very->id)
			{
				return true;
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
			if ($this->session->userdata('id') == $very->id)
			{
				return true;
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
			if ($this->session->userdata('id') == $very->id)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function very_clave($password)
	{
		if ($password == $this->session->userdata('password'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
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