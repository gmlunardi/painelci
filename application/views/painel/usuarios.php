<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):
	case 'login':
		echo '<div class="small-5 small-centered columns">';
		echo form_open('usuarios/login', array('class' => 'custom loginform'));
		echo form_fieldset('Identifique-se');
		erros_validacao();
		get_msg('logoffok');
		get_msg('errologin');
		echo form_label('Usuário');
		echo form_input(array('name' => 'usuario'), set_value('usuario'), 'autofocus');
		echo form_label('Senha');
		echo form_password(array('name' => 'senha'), set_value('senha'));
		echo form_submit(array('name' => 'logar', 'class' => 'button radius right'), 'Login');
		echo '<p>'.anchor('usuarios/nova_senha', 'Esqueci minha senha').'</p>';
		echo form_fieldset_close();
		echo form_close();
		echo '</div>';
		break;
	case 'nova_senha':
		echo '<div class="small-5 small-centered columns">';
		echo form_open('usuarios/nova_senha', array('class' => 'custom loginform'));
		echo form_fieldset('Recuperação de senha');
		erros_validacao();
		get_msg('msgok');
		get_msg('msgerro');
		echo form_label('Seu e-mail');
		echo form_input(array('name' => 'email'), set_value('e-mail'), 'autofocus');
		echo form_submit(array('name' => 'novasenha', 'class' => 'button radius right'), 'Enviar nova senha');
		echo '<p>'.anchor('usuarios/login', 'Fazer Login').'</p>';
		echo form_fieldset_close();
		echo form_close();
		echo '</div>';
		break;
	case 'cadastrar':
		echo '<div class="twelve columns">';
		erros_validacao();
		get_msg('msgok');
		echo form_open('usuarios/cadastrar', array('class' => 'custom'));
		echo form_fieldset('Cadastrar novo usuário');
		echo form_label('Nome Completo');

		echo '<div class="row"> <div class="large-5 columns"> ';
		echo form_input(array('name' => 'nome'), set_value('nome'), 'autofocus');
		echo '</div></div>';

		echo form_label('Email');
		echo '<div class="row"> <div class="large-5 columns"> ';
		echo form_input(array('name' => 'email', 'class' => 'large-5 columns'), set_value('email'));
		echo '</div></div>';

		echo form_label('Login');
		echo '<div class="row"> <div class="large-4 columns"> ';
		echo form_input(array('name' => 'login', 'class' => 'three'), set_value('login'));
		echo '</div></div>';

		echo form_label('Senha');
		echo '<div class="row"> <div class="large-4 columns"> ';
		echo form_password(array('name' => 'senha', 'class' => 'three'), set_value('senha'));
		echo '</div></div>';

		echo form_label('Repita a Senha');
		echo '<div class="row"> <div class="large-4 columns"> ';
		echo form_password(array('name' => 'senha2', 'class' => 'three'), set_value('repita a senha'));
		echo '</div></div>';

		echo form_checkbox(array('name' => 'adm'), '1').' Dar poderes administrativos a este usuário <br/> <br/>';
		echo anchor('usuarios/gerenciar', 'Cancelar', array('class' => 'button radius alert'));
		echo '&nbsp';
		echo form_submit(array('name' => 'cadastrar', 'class' => 'button radius'), 'Guardar Usuário');
		echo form_fieldset_close();
		echo form_close();
		echo '</div>';
		break;
	default:
		echo '<div class="alert-box alert><p>A tela solicitada não existe</p></div>"';
		break;
endswitch;