<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function load_modulo($modulo=NULL, $tela=NULL, $diretorio='painel'){
	$CI =& get_instance();
	if($modulo != NULL):
		return $CI->load->view("$diretorio/$modulo", array('tela' => $tela), TRUE);
	else:
		return FALSE;
	endif;
}