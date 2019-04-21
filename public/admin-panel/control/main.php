<?php
	session_start();
	require "../../../api/Modal.php";

	if(!isset($_GET['p'])) {
		$_GET['p'] = 1;
	}
	$_page = $_GET['p'];
	$_limit = 10;
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Houzion - Painel Administrativo</title>
		<link rel="shortcut icon" type="image/png" href="../../../images/logo/logo_16.png"/>
		<link rel="stylesheet/less" href="../../../styles/less/style.less">
		<script src="../../../scripts/lib/less/less.min.js"></script>
		<script type="module" src="../../../scripts/main.js"></script>
		<script type="module" src="../../../scripts/bootstrap-mod.js"></script>
		<script src="../../../scripts/lib/admin-operation/script.js"></script>
		<script src="../../../scripts/lib/jquery/jquery.min.js"></script>
		<script src="../../../scripts/lib/popper/popper.min.js"></script>
		<script src="../../../scripts/lib/bootstrap/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../../../styles/libs/bootstrap-slider/bootstrap-slider.min.css">
		<script src="../../../scripts/lib/bootstrap/bootstrap-slider.min.js"></script>
		<link rel="stylesheet/scss" type="text/css" href="../../../styles/switch.scss">
	</head>
	<body style="height: 100%; overflow-x: hidden;">
		<?php
			// $_SESSION['is-control'] = TRUE;
			insert_layout_admin();
			// unset($_SESSION['is-control']);
		?>
			<div class="col-md-10 sidebar-content">
				<div class="row" style="min-height: 100%;">
					<div class="col-md-3">
						<div class="help-control-amb" style="margin: 20vmin 0 0 0;">
						</div>
						<div class="list-group" style="margin: 30vmin 0 0 3vmin;">
							<a href="main.php" class="list-group-item list-group-item-action">Início</a>
							<a href="#" class="list-group-item list-group-item-action bg-dark" role="button" data-toggle="popover" data-trigger="focus" title="Olá!" data-content="Caso queira realizar algum controle, escolha um dos filtros abaixo ou utilize a página inicial para ter total acesso."><b>Precisa de ajuda?</b></a>
							<?php
								$pg = new PostgreSQL();
								$array = $pg->QueryArray("SELECT ambiente.codigo, ambiente.nome FROM ambiente WHERE ambiente.codigo_familia = $1 ORDER BY ambiente.nome", [$_SESSION['user-family']]);
								foreach($array as $any){
									?>
										<a href="?amb=<?=$any['codigo']?>" class="list-group-item list-group-item-action <?=($any['codigo']==$_SESSION['is-control-page'])?'disabled':''?>"><?=$any['nome']?></a>
									<?php
								}
							?>
						</div>
					</div>
					<div class="col-md-9 bg-white" style="border-radius: 5px; margin-top: 2vmin;">
						<div class="row" style="margin-top: 2vmin;">
							<div class="col-md-12">
								<?php
									if(isset($_GET['amb'])){
									?>
										<div class="jumbotron jumbotron-fluid">
											<div class="container">
												<h1 class="display-4">Bem-vindo ao sistema de controles</h1>
												<hr>
												<div>
													<span class="lead">Clique em um botão de um card para acessar o controle do componente.</span><a id="btn-question" tabindex="0" class="btn btn-dark float-right" role="button" data-toggle="popover" data-trigger="focus" title="O que é?" data-content="Essa é uma versão inicial ao sistema de controles, aqui você poderá escolher qual controle deseja manipular e clicar no botão logo abaixo. Logo de cara você terá um resumo baseado nas cores apresentadas e no estado atual do componente, exibido logo abaixo do nome."><span class="fa fa-question"></span></a>
												</div>
											</div>
										</div>
									<?php
									}
									else{
										?>
										<div class="jumbotron jumbotron-fluid">
											<div class="container">
												<h1 class="display-4">Bem-vindo ao sistema de controles</h1>
												<hr>
												<div>
													<span class="lead">Escolha um ambiente ao lado esquerdo para poder acessar todos os controles do seu sistema.</span><a id="btn-question" tabindex="0" class="btn btn-dark float-right" role="button" data-toggle="popover" data-trigger="focus" title="O que é?" data-content="Você pode adicionar novos controles nessa página, excluir e também editar os já existentes, além de possuir um resumo básico de tudo."><span class="fa fa-question"></span></a>
												</div>
											</div>
										</div>
										<nav>
											<div class="nav nav-tabs" id="nav-table-control" role="tablist">
											<a class="nav-item nav-link text-hou-green active" id="nav-table-tab" data-toggle="tab" href="#nav-table" role="tab" aria-controls="nav-table" aria-selected="true">Tabela</a>
											<a class="nav-item nav-link text-hou-green" id="nav-control-tab" data-toggle="tab" href="#nav-control" role="tab" aria-controls="nav-control" aria-selected="false">Todos os Controles</a>
											</div>
										</nav>
										<div class="tab-pane fade show active" id="nav-table" role="tabpanel" aria-labelledby="nav-table-tab">
											<div style="margin-top: 4vmin;">
												<?php
													//try
													$pgsql = new PostgreSQL();
													//$pgsql->ConnectServer();
													$sql = "SELECT controle.codigo FROM controle";
													$pgsql->QueryOnly($sql);

													$_total = $pgsql->NumRows();
													$_total_pages = ceil($_total / $_limit);
													$_start = ($_page * $_limit) - $_limit;

													$pgsql->QueryOnly('SELECT controle.codigo AS "#", controle.nome AS "Controle", ambiente.nome AS "Ambiente",  controle.status AS "Status" FROM controle INNER JOIN ambiente ON controle.codigo_ambiente = ambiente.codigo INNER JOIN tipo ON controle.codigo_tipo = tipo.codigo ORDER BY controle.codigo LIMIT $1 OFFSET $2', [$_limit, $_start]);
													create_table($pgsql->FetchAll(), ['1' => ['type' => 'warning', 'text' => 'Editar'], '2' => ['type' => 'danger', 'text' => 'Excluir']]);
													?>
											</div>
											<div>
												<nav>
													<ul class="pagination justify-content-center">
														<li class="page-item <?php echo(($_page == 1) ? 'disabled' : '') ?> ">
															<a class="page-link" href="main.php?p=<?php echo($_page - 1) ?>">Anterior</a>
														</li>
														<?php
															for($i = 1; $i <= $_total_pages; $i++) {
																?>
																<li class="page-item  <?php echo ($i == $_page) ? 'active pagination-green' : '' ?>">
																	<a class="page-link" href="main.php?p=<?php echo $i ?>"><?php echo $i ?></a>
																</li>
																<?php
															}
														?>
														<li class="page-item <?php echo(($_page == $_total_pages) ? 'disabled' : '') ?>">
															<a class="page-link" href="main.php?p=<?php echo($_page + 1) ?>">Próxima</a>
														</li>
													</ul>
												</nav>
											</div>
										</div>
										<div class="tab-content" id="nav-tabContent">
											<div class="tab-pane fade" id="nav-control" role="tabpanel" aria-labelledby="nav-control-tab">
											<span class="display-4 display-6"><b>Últimos alertas ativos</b></span>
								<?php
									$pg = new PostgreSQL();
									$pg->QueryOnly("SELECT alerta.codigo, alerta.texto, alerta.data, alerta.visto, controle.nome, controle.icone, tipo.cor FROM alerta INNER JOIN controle ON alerta.codigo_controle = controle.codigo INNER JOIN tipo ON controle.codigo_tipo = tipo.codigo WHERE alerta.visto = FALSE LIMIT 10");
									$cont = 0;
									while($array = $pg->FetchArray()){
										$cont++;
										?>
											<div class="row text-white list-control-active bg-danger">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-8">	
															<div class="row">
																<div class="col-md-12">
																	<b>
																		<?=$array['nome']?>
																	</b>
																</div>
															</div>
															<div class="row">
																<div class="col-md-12">
																	<?=$array['texto']?>
																</div>
															</div>
														</div>
														<div class="col-md-4 text-right">
															<div class="row">
																<div class="col-md-7 text-right">
																	<i class="alert-icon fas fa-<?=$array['icone']?>"></i>
																</div>
																<div class="col-md-5">
																	<?php
																		$codigo = $array['codigo'];
																	?>
																	<i class="alert-icon-close fas fa-times" onclick="window.location.href='./alert-op/alert-check.php?alert=<?=$codigo?>&r=2'"></i>
																</div>
															</div>
															
														</div>
													</div>
												</div>
											</div>
										<?php
									}
									if(!$cont){
										?>
											<div class="row">
												<div class="col-md-12">
													<span>Nenhum alerta ativo foi encontrado.</span>
												</div>
											</div>
										<?php
									}
								?>
												<?php
													/*unset($pg);
													$pg = new PostgreSQL();
													$array = $pg->QueryArray("SELECT controle.codigo, UPPER(controle.nome) AS nome, ambiente.codigo AS codigo_ambiente, ambiente.nome AS ambiente, controle.icone, tipo.cor, tipo.codigo AS codigo_tipo, controle.status FROM controle INNER JOIN ambiente ON controle.codigo_ambiente = ambiente.codigo INNER JOIN tipo ON controle.codigo_tipo = tipo.codigo WHERE ambiente.codigo_familia = $1 ORDER BY tipo.codigo", [$_SESSION['user-family']]);
													$cont = 0;
													$cont2 = 0;
													$flag = TRUE;
													foreach($array as $any){
														$amb_act = $any['codigo_ambiente'];
														if($flag && $any['codigo_tipo'] > 2){
															?>
																</div>
															<?php
															$flag = FALSE;
															$cont = 0;
														}
														$cont2++;
														if($cont === 0){
															?>
																<div class="row" style="margin-top: 2vmin;">
																	<div class="col-md-12">
																		<span class="side-color"><?=$any['ambiente']?></span>
																	</div>
																</div>
																<div class="row">
																	
															<?php
														}
														?>
														<div class="col-md-3">
															<div class="card text-center bg-card-control-<?=$any['cor']?>" style="width: 100%;">
																<div class="card-body">
																	<div>
																		<span class="card-title text-card-control-<?=$any['cor']?> fa fa-<?=$any['icone']?>" style="font-size: 10vmin;"></span>
																	</div>
																	<div class="text-card-control-<?=$any['cor']?>" style="font-size: 2vmin;">
																		<span><?=$any['nome']?></span>
																	</div>
																	<div>
																		<a href="main.php?code=<?=$any['codigo']?>&type=<?=$any['codigo_tipo']?>" class="btn btn-sm btn-light" style="margin-top: 2vmin;">Abrir</a>
																	</div>
																</div>
															</div>
														</div>
														<?php
														if($cont++ === 2 || ($amb_act != $amb_ant) ){
															$cont = 0;
															?>
																</div>
															<?php
														}
														$amb_ant = $any['codigo_ambiente'];
													}
													if(!$cont2){
														?>
															<div class="alert alert-warning" role="alert">
																Não foi encontrado nenhum registro nesse ambiente, adicione um para que possa assumir o controle.
															</div>
														<?php
													}*/
												?>
											</div>
										</div>
										<?php
									}
								?>
							</div>
						</div>
						<?php
						if(isset($_GET['amb'])){
							unset($pg);
							$pg = new PostgreSQL();
							$array = $pg->QueryArray("SELECT controle.codigo, controle.nome, ambiente.nome AS ambiente, controle.icone, tipo.cor, tipo.codigo AS codigo_tipo, controle.status FROM controle INNER JOIN ambiente ON controle.codigo_ambiente = ambiente.codigo INNER JOIN tipo ON controle.codigo_tipo = tipo.codigo WHERE controle.codigo_ambiente = $1", [$_GET['amb']]);
							$cont = 0;
							$cont2 = 0;
							foreach($array as $any){
								$cont2++;
								if($cont === 0){
									?>
										<div class="row" style="margin-top: 2vmin;">
									<?php
								}
								?>
								<div class="col-md-3">
									<div class="card text-center bg-card-control-<?=$any['cor']?>" style="width: 100%;">
										<div class="card-body">
											<div>
												<span class="card-title text-card-control-<?=$any['cor']?> fa fa-<?=$any['icone']?>" style="font-size: 10vmin;"></span>
											</div>
											<div class="text-card-control-<?=$any['cor']?>" style="font-size: 2vmin; font-variant: small-caps;">
												<div>
													<span><?=$any['nome']?></span>
												</div>
												<div>
													<?php
														switch($any['codigo_tipo']){
															case 1:
																$status = $any['status'].'°C';
																break;
															case 2:
																$status = $any['status'].'%';
																break;
															case 3:
																$status = ['Apagado', 'Aceso'];
																break;
															case 4:
																$status = ['Fechado', 'Aberto'];
																break;
															case 5:
																$status = ['Desligado', 'Ligado'];
																break;
														}
													?>
													<span><b><?=($any['codigo_tipo'] < 3) ? $status : (($any['status'] > 0)? $status[1] : $status[0])?></b></span>
												</div>
											</div>
											<div>
												<?php 
													if($any['codigo_tipo'] > 2){
														?>
														<a href="main.php?amb=<?=$_GET['amb']?>&code=<?=$any['codigo']?>&type=<?=$any['codigo_tipo']?>" class="btn btn-sm btn-light" style="margin-top: 2vmin;">Abrir</a>
														<?php
													}
													else{
														?>
														<a href="#" class="btn btn-sm btn-light disabled" style="margin-top: 2vmin;">Atualizar</a>
														<?php
													}
												?>
											</div>
										</div>
									</div>
								</div>
								<?php
								if($cont++ === 3){
									$cont = 0;
									?>
										</div>
									<?php
								}
							}
							if(!$cont2){
								?>
									<div class="alert alert-warning" role="alert">
										Não foi encontrado nenhum registro nesse ambiente, adicione um para que possa assumir o controle.
									</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
			require_once './control-op/modal.php';

			if(isset($_GET['t'])){
				switch($_GET['t']){
					case 1:
						?>
							<script>
								console.log('a');
								$('#modal-editar').modal({
									show: true,
								});
							</script>
						<?php
						break;
					case 2:
						?>
							<script>
								console.log('a');
								$('#delete-modal').modal({
									show: true,
								});
							</script>
						<?php
						break;
					case 3:
						?>
							<script>
								console.log('a');
								$('#modal-cadastro').modal({
									show: true,
								});
							</script>
						<?php
						break;
				}
			}

			if(isset($_GET['type'])){
				switch($_GET['type']){
					case 3:
						$request = 'control-lamp.php';
						break;
					case 4:
					case 5:
						$request = 'control-door.php';
						break;
					default:
						$request = '../main.php';
				}
				$_SESSION['control-code'] = $_GET['code'];
				include "control-op/$request";
			}
		?>
		<script>
			$(document).ready(function(){
				$('[data-toggle="popover"]').popover();
			});

			$('#nav-table-control').on('click', function (e) {
				e.preventDefault()
				$(this).tab('show')
			});
		</script>
	</body>
</html>
