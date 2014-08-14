<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model{

	public function do_login($usuario = NULL, $senha = NULL){
		if ($usuario && $senha):
			$this->db->where('login', $usuario);
			$this->db->where('senha', $senha);
			$this->db->where('ativo', 1);
			$query = $this->db->get('usuarios');
			if ($query->num_rows == 1):
				return TRUE;
			else:
				return FALSE;
			endif;
		else:
			return FALSE;
		endif;
	}

	public function get_bylogin($login = NULL){
		if ($login != NULL):
			$this->db->where('login', $login);
			$this->db->limit(1);
			return $this->db->get('usuarios');
		else:
			return FALSE;
		endif;
	}

}