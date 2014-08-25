<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):

	case 'gerenciar':
		?>
			<div class="large-12 columns">
			
			<?php 
				echo breadcrumb();
				get_msg('msgerro'); 
				$modo = $this->uri->segment(3);
				if ($modo == 'all'):
					$limite = 0;
				else:
					$limite = 50;
					echo '<p>Mostrando os últimos 50 registros, para ver todo o histórico'.anchor('auditoria/gerenciar/all', ' clique aqui').'</p>';
				endif;
			?>
			
				<table class="tabela">
					<thead>
						<tr>
							<th>Usuário</th>
							<th>Data e Hora</th>
							<th>Operação</th>
							<th>Observação</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$query = $this->auditoria_model->get_all($limite)->result();
							foreach ($query as $linha):
								echo "<tr>";
								printf('<td>%s</td>', $linha->usuario);
								printf('<td>%s</td>', date('d/m/Y H:i:s', strtotime($linha->data_hora)));
								printf('<td>%s</td>', '<span data-tooltip aria-haspopup="true" class="has-tip" title="'.$linha->query.'">'.$linha->operacao.'</span>');
								printf('<td>%s</td>', $linha->observacao);
	
								echo "</tr>";
							endforeach;
						?>
					</tbody>
				</table>
			</div>
				
		<?php
		break;
	
	default:
		echo '<div class="alert-box alert><p>A tela solicitada não existe</p></div>"';
		break;
endswitch;