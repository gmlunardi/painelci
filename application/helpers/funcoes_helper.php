<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function load_modulo($modulo=NULL, $tela=NULL, $diretorio='painel'){
	$CI =& get_instance();
	if($modulo != NULL):
		return $CI->load->view("$diretorio/$modulo", array('tela' => $tela), TRUE);
	else:
		return FALSE;
	endif;
}

//seta valores ao array $tema da classe sistema
function set_tema($prop, $valor, $replace=TRUE){
	$CI =& get_instance();
	$CI->load->library('sistema');
	if($replace):
		$CI->sistema->tema[$prop] = $valor;
	else:
		if(!isset($CI->sistema->tema[$prop])) $CI->sistema->tema[$prop] = '';
		$CI->sistema->tema[$prop] .= $valor;
	endif;
}

//retorna os valores do array tema da classe sistema
function get_tema(){
	$CI =& get_instance();
	$CI->load->library('sistema');
	return $CI->sistema->tema;
}

//inicializar o painel ADM carregando os recursos necessários
function init_painel(){
	$CI =& get_instance();
	$CI->load->library(array('sistema','session','form_validation'));
	$CI->load->helper(array('form','url','array','text'));
	//carregamento dos models
	$CI->load->model('usuarios_model');

	set_tema('titulo_padrao', 'Painel ADM');
	set_tema('rodape', '<p>&copy; 2014 | Todos os direitos reservados para RBTech.Info');
	set_tema('template', 'painel_view');
	
	set_tema('headerinc', load_css(array('foundation.min', 'app', 'foundation-icons')), FALSE);
	set_tema('footerinc', load_js(array('foundation.min')), FALSE);
}

//carrega um template passando o array $tema como parametro
function load_template(){
	$CI =& get_instance();
	$CI->load->library('sistema');
	$CI->parser->parse($CI->sistema->tema['template'], get_tema());
}

//carrega um ou vários arquivos .css de uma pasta
function load_css($arquivo=NULL, $pasta='css', $media='all'){
	if ($arquivo != NULL):
		$CI =& get_instance();
		$CI->load->helper('url');
		$retorno = '';
		if (is_array($arquivo)):
			foreach ($arquivo as $css) 
				$retorno .= '<link rel="stylesheet" type="text/css" href="'.base_url("$pasta/$css.css").'" media="'.$media.'" />';
		else:
			$retorno = '<link rel="stylesheet" type="text/css" href="'.base_url("$pasta/$arquivo.css").'" media="'.$media.'" />';
		endif;
	endif;
	return $retorno;
}

//carrega um ou vários arquivos .js de uma pasta ou servidor remoto. 
function load_js($arquivo=NULL, $pasta='js', $remoto=FALSE){
	if ($arquivo != NULL):
		$CI =& get_instance();
		$CI->load->helper('url');
		$retorno = '';
		if (is_array($arquivo)):
			foreach ($arquivo as $js):
				if ($remoto):
					$retorno .= '<script type="text/javascript" src="'.$js.'"></script>';
				else:
					$retorno .= '<script type="text/javascript" src="'.base_url("$pasta/$js.js").'"></script>';
				endif;
			endforeach;
		else:
			if ($remoto):
				$retorno .= '<script type="text/javascript" src="'.$arquivo.'"></script>';
			else:
				$retorno .= '<script type="text/javascript" src="'.base_url("$pasta/$arquivo.js").'"></script>';
			endif;
		endif;
	endif;
	return $retorno;
}

//função que exibe erros em formulários
function erros_validacao(){
	if (validation_errors()) echo '<div class="alert-box alert">'.validation_errors('<p>','</p>').'</div>';
}

//verifica se o usuário está logado no sistema
function esta_logado($redir = TRUE){
	$CI =& get_instance();
	$CI->load->library('session');
	$user_status = $CI->session->userdata('user_logado');
	if (!isset($user_status) || $user_status != TRUE):
		if ($redir):
			set_msg('errologin', 'Acesso Restrito, você deve possuir um cadastro antes de prosseguir!', 'erro');
			redirect('usuarios/login');
		else:
			return FALSE;
		endif;
	else:
		return TRUE;
	endif;
}

//define uma mensagem para ser exibida na próxima tela carregada. 
function set_msg($id = 'erro', $msg = NULL, $tipo = 'erro'){
	$CI =& get_instance();
	switch ($tipo) {
		case 'erro':
			$CI->session->set_flashdata($id, '<div class="alert-box alert"><p>'.$msg.'</p></div>');
			break;

		case 'sucesso':
			$CI->session->set_flashdata($id, '<div class="alert-box success"><p>'.$msg.'</p></div>');
			break;
		
		default:
			$CI->session->set_flashdata($id, '<div class="alert-box"><p>'.$msg.'</p></div>');
			break;
	}
}

function get_msg($id, $printar = TRUE){
	$CI =& get_instance();
	if ($CI->session->flashdata($id)):
		if ($printar):
			echo $CI->session->flashdata($id);
		else:
			return $CI->session->flashdata($id);
		endif;
	endif;
}

// verifica se o usuario atual é administrador
function is_admin($set_msg = FALSE){
	$CI =& get_instance();
	$user_admin = $CI->session->userdata('user_admin');
	if (!isset($user_admin) || $user_admin != TRUE):
		if ($set_msg)
			set_msg('msgerro', 'Seu usuário não tem permissão para executar esta operação!', 'erro');
		return FALSE;
	else:
		return TRUE;
	endif;
}