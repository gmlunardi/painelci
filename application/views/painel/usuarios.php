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
	case 'gerenciar':
		?>
			<div class="large-12 columns">
			<?php get_msg('msgerro'); ?>
				<table class="tabela">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Login</th>
							<th>E-mail</th>
							<th>Ativo / Adm</th>
							<th class="text-center">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$query = $this->usuarios_model->get_all()->result();
							foreach ($query as $linha):
								echo "<tr>";
								printf('<td>%s</td>', $linha->nome);
								printf('<td>%s</td>', $linha->login);
								printf('<td>%s</td>', $linha->email);
								printf('<td>%s / %s</td>', ($linha->ativo == 0) ? 'Não' : 'Sim', ($linha->adm == 0) ? 'Não' : 'Sim');
								printf('<td class="text-center">%s%s%s</td>', 
									anchor("usuarios/editar/$linha->id", ' ', array('class' => 'fi-page-edit size-18')),  
									anchor("usuarios/excluir/$linha->id", ' ', array('class' => 'fi-trash size-18')),               
									anchor("usuarios/visualizar/$linha->id", ' ', array('class' => 'fi-social-skillshare size-18')));
								echo "</tr>";
							endforeach;
						?>
					</tbody>
				</table>
			</div>
				
		<?php
		break;
	case 'visualizar':
		echo '<div class="large-12 columns">';
		$id = $this->uri->segment(3);
		$query = $this->usuarios_model->get_byid($id)->row();

		$ativo = ($query->ativo == 0) ? 'Não' : 'Sim';
		$adm = ($query->adm == 0) ? 'Não' : 'Sim';

		echo form_fieldset('Detalhes do Usuário');
		echo '<div class="row"><div class="small-3 large-5 columns">';
		echo form_label('Nome do Usuário');
		echo form_input(array('name' => 'nome', 'disabled' => 'disabled'), set_value('nome', $query->nome));
		echo "</div></div>";
		echo '<div class="row"><div class="small-3 large-5 columns">';
		echo form_label('E-mail');
		echo form_input(array('name' => 'email', 'disabled' => 'disabled'), set_value('email', $query->email));
		echo "</div></div>";
		echo '<div class="row"><div class="small-3 large-3 columns">';
		echo form_label('Login');
		echo form_input(array('name' => 'login', 'disabled' => 'disabled'), set_value('login', $query->login));
		echo "</div></div>";
		echo '<div class="row"><div class="small-2 large-1 columns">';
		echo form_label('Ativo');
		echo form_input(array('name' => 'ativo', 'disabled' => 'disabled'), set_value('ativo', $ativo));
		echo "</div></div>";
		echo '<div class="row"><div class="small-2 large-1 columns">';
		echo form_label('Administrador');
		echo form_input(array('name' => 'adm', 'disabled' => 'disabled'), set_value('adm', $adm));
		echo "</div></div>";
		echo '</div>';
		echo form_fieldset_close();
		break;
	case 'alterar_senha':
		$id_user = $this->uri->segment(3);
		if ($id_user == NULL):
			set_msg('msgerro', 'Você precisa de um usuário para alterar a senha');
			redirect('usuarios/gerenciar');
		endif;
		echo '<div class="large-12 columns">';
			if (is_admin() || $id_user == $this->session->userdata('user_id')):
				$query = $this->usuarios_model->get_byid($id_user)->row();
				erros_validacao();
				get_msg('msgok');

				echo form_open(current_url(), array('class' => 'custom'));
				echo form_fieldset('Alterar Senha');
				echo form_label('Nome Completo');

				echo '<div class="row"> <div class="large-5 columns"> ';
				echo form_input(array('name' => 'nome', 'disabled' => 'disabled'), set_value('nome', $query->nome));
				echo '</div></div>';

				echo form_label('Email');
				echo '<div class="row"> <div class="large-5 columns"> ';
				echo form_input(array('name' => 'email', 'disabled' => 'disabled'), set_value('email', $query->email));
				echo '</div></div>';

				echo form_label('Login');
				echo '<div class="row"> <div class="large-4 columns"> ';
				echo form_input(array('name' => 'login', 'disabled' => 'disabled'), set_value('login', $query->login));
				echo '</div></div>';

				echo form_label('Nova Senha');
				echo '<div class="row"> <div class="large-4 columns"> ';
				echo form_password(array('name' => 'senha'), set_value('senha'), 'autofocus');
				echo '</div></div>';

				echo form_label('Repita a nova Senha');
				echo '<div class="row"> <div class="large-4 columns"> ';
				echo form_password(array('name' => 'senha2'), set_value('repitaasenha'));
				echo '</div></div>';

				echo anchor('usuarios/gerenciar', 'Cancelar', array('class' => 'button radius alert'));
				echo '&nbsp';
				echo form_submit(array('name' => 'alterar_senha', 'class' => 'button radius'), 'Salvar nova senha');
				echo form_hidden('idusuario', $id_user);
				echo form_fieldset_close();
				echo form_close();
				echo '</div>';
			else:
				set_msg('msgerro', 'Seu usuário não tem permissão para executar esta operação!', 'erro');
				redirect('usuarios/gerenciar');
			endif;
		echo '</div>';
		break;
	case 'editar':
		$id_user = $this->uri->segment(3);
		if ($id_user == NULL):
			set_msg('msgerro', 'Você precisa de um usuário para alterar');
			redirect('usuarios/gerenciar');
		endif;
		echo '<div class="large-12 columns">';
			if (is_admin() || $id_user == $this->session->userdata('user_id')):
				$query = $this->usuarios_model->get_byid($id_user)->row();
				erros_validacao();
				get_msg('msgok');

				echo form_open(current_url(), array('class' => 'custom'));
				echo form_fieldset('Alterar Usuário');
				
				echo form_label('Nome Completo');
				echo '<div class="row"> <div class="large-5 columns"> ';
				echo form_input(array('name' => 'nome'), set_value('nome', $query->nome), 'autofocus');
				echo '</div></div>';

				echo form_label('Email');
				echo '<div class="row"> <div class="large-5 columns"> ';
				echo form_input(array('name' => 'email', 'disabled' => 'disabled'), set_value('email', $query->email));
				echo '</div></div>';

				echo form_label('Login');
				echo '<div class="row"> <div class="large-4 columns"> ';
				echo form_input(array('name' => 'login', 'disabled' => 'disabled'), set_value('login', $query->login));
				echo '</div></div>';

				echo '<div class="row"> <div class="large-5 columns"> ';
				echo form_checkbox(array('name' => 'ativo'), '1', $query->ativo == 1 ? TRUE : FALSE).' Permitir o acesso deste usuário ao sistema. ';
				echo '</div></div>';
				echo '<div class="row"> <div class="large-5 columns"> ';
				echo form_checkbox(array('name' => 'adm'), '1', $query->adm == 1 ? TRUE : FALSE).' Dar poderes administrativos a este usuário.<br />';
				echo '</div></div>';

				echo anchor('usuarios/gerenciar', 'Cancelar', array('class' => 'button radius alert'));
				echo '&nbsp';
				echo form_submit(array('name' => 'alterar_senha', 'class' => 'button radius'), 'Alterar Usuário');
				echo form_hidden('idusuario', $id_user);
				echo form_fieldset_close();
				echo form_close();
				echo '</div>';
			else:
				set_msg('msgerro', 'Seu usuário não tem permissão para executar esta operação!', 'erro');
				redirect('usuarios/gerenciar');
			endif;
		echo '</div>';
		break;
	default:
		echo '<div class="alert-box alert><p>A tela solicitada não existe</p></div>"';
		break;
endswitch;