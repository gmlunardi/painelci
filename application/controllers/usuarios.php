<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('sistema');
	}

	public function index(){
		$this->load->view('nomeview');
	}

	public function login(){
		$tema['titulo'] = 'Login';
		$tema['conteudo'] = load_modulo('usuarios','login');
		$this->load->view('painel_view', $tema);
	}
}