<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('sistema');
		init_painel();
	}

	public function index(){
		$this->load->view('nomeview');
	}

	public function login(){
		set_tema('titulo','Login');
		set_tema('conteudo', load_modulo('usuarios','login'));
		//set_tema('rodape', '<p>novo rodapé</p>', FALSE);
		load_template();
	}
}