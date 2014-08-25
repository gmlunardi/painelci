<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		init_painel();
	}

	public function index(){
		$this->gerenciar();
	}

	public function login(){
		if (esta_logado(FALSE)) redirect('painel'); 
		$this->form_validation->set_rules('usuario', "USUÁRIO", 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('senha', "SENHA", 'trim|required|min_length[4]|strtolower');
		if ($this->form_validation->run() == TRUE):
			$usuario = $this->input->post('usuario', TRUE); //TRUE XSS CLEAN para eliminar chances de SQL injeqtions
			$senha = md5($this->input->post('senha', TRUE)); 
			$redirect = $this->input->post('redirect', TRUE);
			if ($this->usuarios_model->do_login($usuario, $senha) == TRUE):
				$query = $this->usuarios_model->get_bylogin($usuario)->row();
				$dados = array('user_id' => $query->id, 'username' => $query->nome, 'user_admin' => $query->adm, 'user_logado' => TRUE);
				$this->session->set_userdata($dados);
				auditoria('Login no sistema', 'Login efetuado com sucesso');
				if ($redirect != ''):
					redirect($redirect);
				else:
					redirect('painel');
				endif;
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
		// esses sets do template devem ficar abaixo da lógica acima pois, senão, não funciona as msgs de erro/sucesso direito  
		set_tema('titulo','Login');
		set_tema('conteudo', load_modulo('usuarios','login'));
		set_tema('rodape', '');
		load_template();
	}

	public function logoff(){
		auditoria('Logout no sistema', 'Logout efetuado com sucesso');
		$this->session->unset_userdata(array('user_id' => '', 'username' => '', 'user_admin' => '', 'user_logado' => ''));
		$this->session->sess_destroy(); //não precisaria a linha de cima, mas podem ficar dados no navegador, por isso ela.
		$this->session->sess_create(); //em versoes anteriores a 2.1.3 o destroy terminava e logo criava a sessao automaticamente, mas depois dessa versão é preciso fazer isso, do contrário as flashdata não guardam os dados para a próxima requisição
		set_msg('logoffok', 'Logoff efetuado com sucesso', 'sucesso');
		redirect('usuarios/login');
	}

	public function nova_senha(){
		$this->form_validation->set_rules('email', "E-MAIL", 'trim|required|valid_email|strtolower');
		if ($this->form_validation->run() == TRUE):
			$email = $this->input->post('email');
			$query = $this->usuarios_model->get_byemail($email);
			if ($query->num_rows() == 1):
				$novasenha = substr(str_shuffle('qwertyuiopasdfghj0123456789'), 0, 6);
				$mensagem = "<p> Você solicitou uma nova senha para acesso ao painel de administração do site, a partir de agora use a seguinte senha para acesso: <strong>$novasenha</strong></p> Troque esta senha para uma senha segura e de sua preferência.</p>";
				if($this->sistema->enviar_email($email,'Nova senha de acesso', $mensagem)):
					$dados['senha'] = md5($novasenha);
					$this->usuarios_model->do_update($dados, array('email' => $email), FALSE);
					auditoria('Reset de senha', 'O usuário solicitou uma nova senha por e-mail', TRUE, $email);
					set_msg('msgok','Uma nova senha foi enviada para seu e-mail', 'sucesso');
					redirect('usuarios/nova_senha');
				else:
					set_msg('msgerro','Erro ao enviar nova senha', 'erro');
					redirect('usuarios/nova_senha');
				endif;
			else:
				set_msg('msgerro','E-mail não cadastrado no banco de dados', 'erro');
				redirect('usuarios/nova_senha');
			endif;
		endif;
		// esses sets do template devem ficar abaixo da lógica acima pois, senão, não funciona as msgs de erro/sucesso direito
		set_tema('titulo','Recuperar senha');
		set_tema('conteudo', load_modulo('usuarios','nova_senha'));
		set_tema('rodape', '');
		load_template();
	}

	public function cadastrar(){
		esta_logado();
		$this->form_validation->set_message('is_unique', 'Este %s já está cadastrado no sistema');
		$this->form_validation->set_message('matches', 'O campo %s está diferente do campo %s');
		$this->form_validation->set_rules('nome', 'NOME', 'trim|required|ucwords');
		$this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|is_unique[usuarios.email]|strtolower');
		$this->form_validation->set_rules('login', 'LOGIN', 'trim|required|min_length[4]|is_unique[usuarios.login]|strtolower');
		$this->form_validation->set_rules('senha', 'SENHA', 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('senha2', 'REPITA A SENHA', 'trim|required|min_length[4]|strtolower|matches[senha]');
		if ($this->form_validation->run() == TRUE):
			$dados = elements(array('nome', 'email', 'login'), $this->input->post());
			$dados['senha'] = md5($this->input->post('senha'));
			if (is_admin())
				$dados['adm'] = ($this->input->post('adm') == 1) ? 1 : 0;
			$this->usuarios_model->do_insert($dados);
		endif;

		set_tema('titulo','Criar novo Usuário');
		set_tema('conteudo', load_modulo('usuarios','cadastrar'));
		load_template();
	}

	public function gerenciar(){
		esta_logado();

		

		set_tema('titulo','Listagem de Usuários');
		set_tema('conteudo', load_modulo('usuarios','gerenciar'));
		load_template();
	}

	public function visualizar(){
		esta_logado();

		set_tema('titulo','Ver detalhes do usuário');
		set_tema('conteudo', load_modulo('usuarios','visualizar'));
		load_template();
	}

	public function alterar_senha(){
		esta_logado();
		$this->form_validation->set_message('matches', 'O campo %s está diferente do campo %s');
		$this->form_validation->set_rules('senha', 'SENHA', 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('senha2', 'REPITA A NOVA SENHA', 'trim|required|min_length[4]|strtolower|matches[senha]');
		if ($this->form_validation->run() == TRUE):
			$dados['senha'] = md5($this->input->post('senha'));
			$this->usuarios_model->do_update($dados, array('id' => $this->input->post('idusuario')));
		endif;
		set_tema('titulo','Alterar senha');
		set_tema('conteudo', load_modulo('usuarios','alterar_senha'));
		load_template();
	}

	public function editar(){
		esta_logado();
		$this->form_validation->set_rules('nome', 'NOME', 'trim|required|ucwords');
		if ($this->form_validation->run() == TRUE):

			$dados['nome'] = $this->input->post('nome');
			$dados['ativo'] = ($this->input->post('ativo') == 1 ? 1 : 0);
			if (is_admin()) $dados['adm'] = ($this->input->post('adm') == 1) ? 1 : 0;
			$this->usuarios_model->do_update($dados, array('id' => $this->input->post('idusuario')));
		endif;
		set_tema('titulo','Alterar Usuários');
		set_tema('conteudo', load_modulo('usuarios','editar'));
		load_template();
	}

	public function excluir(){
		esta_logado();
		if (is_admin(TRUE)):
			$iduser = $this->uri->segment(3);
			if ($iduser != NULL):
				$query = $this->usuarios_model->get_byid($iduser);
				if ($query->num_rows() == 1):
					$query = $query->row();
					if ($query->id != 1):
						$this->usuarios_model->do_delete(array('id' => $query->id), FALSE);
					else:
						set_msg('msgerro', 'Este usuário não pode ser excluído', 'erro');
					endif;
				else:
					set_msg('msgerro', 'Usuário não encontrado para a exclusão', 'erro');
				endif;
			else:
				set_msg('msgerro', 'Escolha um usuário para excluir', 'erro');
			endif;
		endif;
		redirect('usuarios/gerenciar');
	}

}
