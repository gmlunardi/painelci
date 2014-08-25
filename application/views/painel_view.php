<!doctype html>
<html class="no-js" lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php if (isset($titulo)): ?> {titulo} <?php endif; ?> {titulo_padrao}</title>

	{headerinc}
</head>
<body>

	<?php if(esta_logado(FALSE)): ?>
		<div class="row">
			<div class="large-3 columns">
				<h2>Painel ADM</h2>
			</div>
			<div class="large-9 columns">
				<p class="text-right">Logado como <strong><?php echo $this->session->userdata('username'); ?></strong></p>
				<p class="text-right">
					<?php echo anchor('usuarios/alterar_senha/'.$this->session->userdata('user_id'), 'Alterar senha', 'class="button radius tiny"'); ?>
					<?php echo anchor('usuarios/logoff', 'Sair', 'class="button radius tiny alert"'); ?>
				</p>
			</div>
		</div>

		<div class="row">

			<div class="large-12 columns">
			<nav class="top-bar" data-topbar role="navigation">
					<section class="top-bar-section">
						<!-- Left Nav Section -->
						<ul class="left">
							<li class="divider"></li>
							<li class=""><?php echo anchor('painel', 'Início'); ?></li>
							<li class="divider"></li>
							<li class="has-dropdown"><?php echo anchor('usuarios/gerenciar', 'Usuários') ?>
								<ul class="dropdown">
									<li class="divider"></li>
									<li><?php echo anchor('usuarios/cadastrar', 'Cadastrar'); ?></li>
									<li class="divider"></li>
									<li><?php echo anchor('usuarios/gerenciar', 'Gerenciar'); ?></li>
									<li class="divider"></li>
								</ul>
							</li>
							<li class="divider"></li>
							<li class="has-dropdown"><a href="#">Administração</a>
								<ul class="dropdown">
									<li class="divider"></li>
									<li><?php echo anchor('auditoria/gerenciar', 'Auditoria'); ?></li>
									<li class="divider"></li>
								</ul>
							</li>
							<li class="divider"></li>
						</ul>
					</section>
				</nav>
			</div>

		</div>

		<?php endif; ?>
		<div class="row paineladm">
			<div class="twelve columns conteudo">
				{conteudo}
			
			</div>
		</div>
		<div class="row">
			<div class="twelve columns text-center rodape">
					{rodape}
			</div>
		</div>
		{footerinc}


</body>

</html>