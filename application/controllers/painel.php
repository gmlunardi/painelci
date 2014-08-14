<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Painel extends CI_Controller {

	public function __construct(){
		parent::__construct();
		init_painel();
	}

	public function index(){
		$this->inicio();
	}

	public function inicio(){
		if (esta_logado(FALSE)):
			set_tema('titulo', 'Início');
			set_tema('conteudo', '<div class="twelve columns"><p>Escolha um menu para iniciar</p></div>');
			load_template();
		else:
			redirect('usuarios/login');
		endif;
	}
}