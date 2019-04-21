<?php
	session_start();
	require "api/Modal.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<base href="public/admin-panel/foo/">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Houzion - Painel Administrativo</title>
		<link rel="shortcut icon" type="image/png" href="../../../images/logo/logo_16.png"/>
		<link rel="stylesheet/less" href="../../../styles/less/style.less">
		<script src="../../../scripts/lib/less/less.min.js"></script>
		<script type="module" src="scripts/main.js"></script>
		<script type="module" src="scripts/bootstrap-mod.js"></script>
		<!--CDN Imports-->
		<script src="../../../scripts/lib/jquery/jquery.min.js"></script>
		<script src="../../../scripts/lib/popper/popper.min.js"></script>
		<script src="../../../scripts/lib/bootstrap/bootstrap.min.js"></script>
	</head>
	<body style="height: 100%; overflow-x: hidden;">
		<?php
			insert_layout_admin();
		?>
			<div class="col-md-10 sidebar-content">
				<div class="admin-index">
					<div class="admin-index">
						<div class="jumbotron-title">
							<div class="jumbotron jumbotron-fluid bg-hou-green-light-1">
								<div class="container">
									<h1 class="display-4 text-hou-green-dark-title">Seja bem-vindo ao painel.</h1>
									<p class="lead">Essas demonstrações abaixo lhe mostrarão <b>o que está acontecendo em sua casa agora.</b>
									</p>
								</div>
							</div>
						</div>
						<?php
							$pg = new PostgreSQL();
							$pg->QueryOnly("SELECT alerta.codigo, alerta.texto, controle.nome as controle_nome, controle.icone, ambiente.nome as ambiente_nome, tipo.cor, controle.status, alerta.visto, alerta.data FROM alerta INNER JOIN controle ON alerta.codigo_controle = controle.codigo INNER JOIN ambiente ON controle.codigo_ambiente = ambiente.codigo INNER JOIN tipo ON controle.codigo_tipo = tipo.codigo WHERE alerta.visto = FALSE LIMIT 8");
							 $cont = 0;
							 $alert = $pg->NumRows();
						?>
						<div class="row">
							<div class="col-md-12">
								<div class="jumbotron-check jumbotron jumbotron-fluid ">
									<div class="container">
										<div class="row">
											<div class="col-md-8">
												<h2 class="display-4 text-<?=(($alert > 0)? 'danger':'success')?>">Sua casa <?=(($alert > 0)? '<b>não</b>':'')?> está segura</h2>
											</div>
											<div class="col-md-4 text-right">
												<span class="fa fa-<?=(($alert > 0)? 'times':'check')?> text-<?=(($alert > 0)? 'danger':'success')?>" style="font-size: 13vh;"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
							while($array = $pg->FetchArray()){
								if(!$cont){
									?>
										<div class="row">
									<?php
								}
								$cont++;
								?>
									<div class="col-md-3">
										<div class="card bg-card-control-<?=$array['cor']?> mb-3" style="max-width: 18rem;">
											<div class="card-body">
												<span class="text-title text-card-control-<?=$array['cor']?>"><b><?=$array['controle_nome']?></b></span>
												<div class="row" style="margin-top: 10px; margin-bottom: 10px;">
													<div class="col-md-7 text-card-control-<?=$array['cor']?>">
														<span class="display-4 text-display"><?=$array['texto']?></span>
													</div>
													<div class="col-md-5 text-center text-card-control-<?=$array['cor']?>">
														<span class="fa fa-<?=$array['icone']?>" style="font-size: 9vh;"></span>
													</div>
												</div>
												<div class="row">
													<!-- <div class="col-md-3">
														<a href="../alert/main.php?type=view&code=" class="btn btn-sm btn-dark"><b>VER</b></a>
													</div> -->
													<div class="col-md-12">
														<form action="../alert/alert-op/alert-check.php" method="GET" accept-charset="utf-8">
															<input type="hidden" name="alert" value="<?=$array['codigo']?>">
															<input type="hidden" name="r" value="1">
															<button type="submit" class="btn btn-light btn-sm"><b>DESCARTAR</b></button>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
								if($cont == 4){
									$cont = 0;
									?>
									</div>
									<?php
								}
							}
							echo (($cont != 0)? "</div>":"");
							?>
						<!--<div class="row">
							<div class="col-md-3">
								<div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
									<div class="card-body">
										<span class="text-hou-white-title"><b>SENSOR DE CO<sup>2</sup></b></span>
										<div class="row" style="margin-top: 10px; margin-bottom: 10px;">
											<div class="col-md-7">
												<span class="display-4 text-display">Gás detectado na cozinha</span>
											</div>
											<div class="col-md-5 text-center">
												<span class="fa fa-fire" style="font-size: 9vh;"></span>
											</div>
										</div>
										<a href="#" class="card-link card-link-white"><b>Descartar</b></a>
										<a href="#" class="card-link card-link-white"><b>Emergência</b></a>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card text-danger bg-white mb-3" style="max-width: 18rem;">
									<div class="card-body">
										<span class="text-hou-red-title-upper"><b>Sensor de movimento</b></span>
										<div class="row" style="margin-top: 10px; margin-bottom: 10px;">
											<div class="col-md-7">
												<span class="display-4 text-black text-display">Alguém está na sua porta</span>
											</div>
											<div class="col-md-5 text-center">
												<span class="fa fa-user" style="font-size: 9vh;"></span>
											</div>
										</div>
										<a href="#" class="card-link text-black card-link-black"><b>Descartar</b></a>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card text-danger bg-white mb-3" style="max-width: 18rem;">
									<div class="card-body">
										<span class="text-hou-red-title-upper"><b>Alarme</b></span>
										<div class="row" style="margin-top: 10px; margin-bottom: 10px;">
											<div class="col-md-7">
												<span class="display-4 text-black text-display">9:45PM</span>
											</div>
											<div class="col-md-5 text-center">
												<span class="fa fa-bell" style="font-size: 9vh;"></span>
											</div>
										</div>
										<a href="#" class="card-link text-black card-link-black"><b>Descartar</b></a>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card text-danger bg-white mb-3" style="max-width: 18rem;">
									<div class="card-body">
										<span class="text-hou-red-title-upper"><b>Televisão</b></span>
										<div class="row" style="margin-top: 10px; margin-bottom: 10px;">
											<div class="col-md-7">
												<span class="display-4 text-black text-display">Ligada</span>
											</div>
											<div class="col-md-5 text-center">
												<span class="fa fa-tv" style="font-size: 9vh;"></span>
											</div>
										</div>
										<a href="#" class="card-link text-black card-link-black"><b>Desligar</b></a>
									</div>
								</div>
							</div>
							-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>