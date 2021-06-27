<?php

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->very_session();
	}

	public function index()
	{
		$data = array(
			'titulo' => 'Iniciar Sesion',
			'contenido' => 'home/login_view',
			);
		$this->load->view('plantilla', $data);
	}

	public function login()
	{
		if (!$this->input->is_ajax_request())
		{
			redirect(base_url());
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('username', 'Usuario', 'required|trim');
			$this->form_validation->set_rules('password', 'Contraseña', 'required|trim');
			// Messages
			//$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				$user = $this->admin_model->login();
				if ($user == false)
				{
					echo "fallo";
				}
				else
				{
					$data = array(
						'id' => $user->id,
						'nombre' => $user->nombre,
						'cedula' => $user->cedula,
						'email' => $user->email,
						'username' => $user->username,
						'tipo' => $user->tipo,
						'password' => $user->password,
						'preg' => $user->preg,
						'resp' => $user->resp,
						);
					$this->session->set_userdata($data);
					echo "entrada";
				}
			}
		}
	}

	public function recuperar()
	{
		if (!$this->input->is_ajax_request())
		{
			$data = array(
				'titulo' => 'Recuperar Contraseña',
				'contenido' => 'home/recuperar_view',
				'preguntas' => $this->preguntas(),
				);
			$this->load->view('plantilla', $data);
		}
		else
		{
			// Rules
			$this->form_validation->set_rules('cedula', 'Cedula de Identidad', 'required|integer|trim');
			$this->form_validation->set_rules('preg', 'Pregunta de Seguridad', 'required');
			$this->form_validation->set_rules('respuesta', 'Respuesta Secreta', 'required');
			// Messages
			/*$this->form_validation->set_message('required', '{field} es un campo obligatorio');
			$this->form_validation->set_message('integer', '{field} solo debe contener numeros enteros');*/
			if ($this->form_validation->run() == false)
			{
				echo validation_errors('<li>', '</li>');
			}
			else
			{
				$very = $this->admin_model->recuperar();
				if ($very == false)
				{
					echo "fallo";
				}
				else
				{
					//Configuracion del correo
					$this->load->library('email');
					$email = $very->email;
					$asunto = "Restablecimiento de la Contraseña";
					$msj = "<h1>Restablecimiento de la Contraseña</h1><br>";
					$msj .= "<p>Reciba un cordial saludo estimado <strong>". $very->nombre."</strong>, hemos recibido una solicitud para restablecer su contraseña la cual fue verificada con resultados satisfactorios. Dejamos nota de sus credenciales para que pueda acceder nuevamente al sistema:</p><br>";
					$msj .= "<strong>Usuario: </strong>".$very->username."<br>";
					$msj .= "<strong>Contraseña: </strong>".$very->password."<br><br>";
					//Inicializamos la libreria
					$config['mailtype'] = "html";
					$this->email->initialize($config);
					//Indicamos los parametros para el email
					$this->email->from('cattleyasystems@gmail.com', 'Nombre de la empresa');
					$this->email->to($email);
					$this->email->subject($asunto);
					$this->email->message($msj);
					//$this->email->send();
					echo "bien";
				}
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

	private function very_session()
	{
		if ($this->session->userdata('username') != '')
		{
			redirect(base_url().'admin');
		}
	}
}

?>