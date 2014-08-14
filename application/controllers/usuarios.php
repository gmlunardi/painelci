<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		init_painel();
	}

	public function index(){
		redirect('usuarios/login');
	}

	public function login(){
		$this->form_validation->set_rules('usuario', "USUÁRIO", 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('senha', "SENHA", 'trim|required|min_length[4]|strtolower');
		if ($this->form_validation->run() == TRUE):
			$usuario = $this->input->post('usuario', TRUE); //TRUE XSS CLEAN para eliminar chances de SQL injeqtions
			$senha = md5($this->input->post('senha', TRUE)); 
			if ($this->usuarios_model->do_login($usuario, $senha) == TRUE):
				$query = $this->usuarios_model->get_bylogin($usuario)->row();
				$dados = array('user_id' => $query->id, 'username' => $query->nome, 'user_admin' => $query->adm, 'user_logado' => TRUE);
				$this->session->set_userdata($dados);
				redirect('painel');
			else:
				$query = $this->usuarios_model->get_bylogin($usuario)->row();
				if (empty($query)):
					set_msg('errologin', 'Usuário Inexistente', 'erro');
				else:
					if ($query->senha != $senha):
						set_msg('errologin', 'Senha Incorreta', 'erro');
					elseif ($query->ativo != 1):
						set_msg('errologin', 'Usuário Inativo', 'erro');
					else:
						set_msg('errologin', 'Erro desconhecido, contate o suporte', 'erro');
					endif;
				endif;
				redirect('usuarios/login');
			endif;
		endif;
		set_tema('titulo','Login');
		set_tema('conteudo', load_modulo('usuarios','login'));
		set_tema('rodape', '');
		load_template();
	}

	public function logoff(){
		$this->session->unset_userdata(array('user_id' => '', 'username' => '', 'user_admin' => '', 'user_logado' => ''));
		$this->session->sess_destroy(); //não precisaria a linha de cima, mas podem ficar dados no navegador, por isso ela.
		$this->session->sess_create();
		set_msg('logoffok', 'Logoff efetuado com sucesso', 'sucesso');
		redirect('usuarios/login');
	}
}