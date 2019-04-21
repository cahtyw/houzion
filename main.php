<?php
	session_start();
	$login_name = $_SESSION['name'];
	
	$pageInfos = [
		'index.php' => ['name' => 'Home', 'false' => true],
		'app.php' => ['name' => 'Aplicativo', 'visible' => true],
		'contact.php' => ['name' => 'Contato', 'visible' => true],
		'about.php' => ['name' => 'Quem somos', 'visible' => true],
		'mistake.php' => ['name' => 'Não Encontrado'],
		'agendamento_index.php' => ['name' => 'Agendamento']
	];
	
	list(, $page, $path) = explode('/', $_SERVER['PATH_INFO'], 3);
	
	if(!$page)
	{
		$page = 'index.php';
	}
	
	$pageInfo = $pageInfos[$page];
	
	if(!$pageInfo)
	{
		$page = 'mistake.php';
		$pageInfo = $pageInfos[$page];
		http_response_code(404);
	}
	
	function links($tag, $class = '')
	{
		global $pageInfos;
		global $page;
		
		if($class)
		{
			$classAttr = ' class="'.$class.'"';
		}
		else
		{
			$classAttr = '';
		}
		foreach($pageInfos as $p=>$info)
		{
			if($p === $page)
			{
				$hrefAttr = '';
			}
			else
			{
				$hrefAttr = ' href="main.php/'.$p.'"';
			}
			
			$dataAttr = ' data-href="main.php/'.$p.'"';
			
			if($info['visible'])
			{
				echo '<'.$tag.'><a'.$dataAttr.$classAttr.$hrefAttr.'>'.$info['name'].'</a></'.$tag.'>';
			}
		}
	}
	
	$base = dirname($_SERVER['SCRIPT_NAME']);
	if(substr($base, -1) !== '/')
	{
		$base .= '/';
	}
?>
<!doctype html>
<html lang="pt">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Houzion &mdash; <?php echo $pageInfo['name']; ?></title>
		<base href="<?php echo $base; ?>"/>
		<link rel="shortcut icon" type="image/png" href="images/logo/logo_16.png"/>
		<link rel="stylesheet/less" href="styles/less/style.less">
		<script src="./scripts/lib/less/less.min.js"></script>
		<script type="module" src="scripts/main.js"></script>
		<script type="module" src="scripts/bootstrap-mod.js"></script>
		<script src="./scripts/lib/jquery/jquery.min.js"></script>
		<script src="./scripts/lib/popper/popper.min.js"></script>
		<script src="./scripts/lib/bootstrap/bootstrap.min.js"></script>
		<script type="text/plain" id="pagenames"><?php foreach($pageInfos as $pcode=>$pinfo) echo $pcode.'::'.$pinfo['name'].'::'.$pinfo['subfolder'].';;'; ?></script>
	</head>
	<body class="scroller">
		<div>
			<div class="header">
				<div class="bg-hou-green-light-1 sticky-top">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<a href="main.php">
									<img src="images/logo/logo_64.png" alt="" class="header-logo">
								</a>
							</div>
						</div>
					</div>
					<?php
						if($page != 'login.php') {
							?>
							<nav class="navbar navbar-expand-lg navbar-light bg-hou-green-light">
								<div class="container">
									<a class="navbar-brand" href="main.php">
										Início
									</a>
									<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
										<span class="navbar-toggler-icon"></span>
									</button>
									<div class="collapse navbar-collapse" id="navbarSupportedContent">
										<ul class="navbar-nav mr-auto">
											<?php
												links('li', 'nav-link');
											?>
										</ul>
										<a class="btn bg-hou-green-light-1 text-lighter" href="login.php">Ir para o painel</a>
									</div>
								</div>
							</nav>
							<?php
						}
					?>
				</div>
			</div>
			<div id="main">
				<?php
					require 'public/'.$page;
				?>
			</div>
		</div>
		<script> ('oieeee'); </script>
		<div class="footer">
			<?php
				if($page != 'login.php') {
					?>
					<footer class="page-footer font-small bg-hou-green-dark pt-0">
						<div class="bg-hou-green">
							<div class="container">
								<div class="row d-flex align-items-center">
									<div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
										<h6 class="mb-0 white-text">Siga <b class="text-black">Houzion</b> nas redes
											sociais!</h6>
									</div>
									<div class="col-md-6 col-lg-7 text-center text-md-right">
										<a class="" href="#">
											<img src="images/svg/logo_facebook.svg" width="32px">
										</a>
										<a class="" href="#">
											<img src="images/svg/logo_twitter.svg" width="32px">
										</a>
										<a class="" href="#">
											<img src="images/svg/logo_googleplus.svg" width="32px">
										</a>
										<a class="" href="#">
											<img src="images/svg/logo_linkedin.svg" width="32px">
										</a>
										<a class="" href="#">
											<img src="images/svg/logo_github.svg" width="32px">
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="container text-center text-md-left">
							<div class="row mt-3">
								<div class="col-md-3 col-lg-4 col-xl-3">
									<h6 class="text-uppercase font-weight-bold">
										<strong>Equipe</strong>
									</h6>
									<div>
										<p>
											Caio Lucas Teixeira Ferraz de Oliveira
										</p>
										<p>
											Gabriel dos Santos Gonçalves
										</p>
										<p>
											Gisele Reis de Almeida
										</p>
										<p>
											José Almino de Araújo Júnior
										</p>
										<p>
											José Rogério Fernandes Mirandola
										</p>
										<p>
											Pedro Martins Zamboni
										</p>
									</div>
								</div>
								<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
									<h6 class="text-uppercase font-weight-bold">
										<strong>Links úteis</strong>
									</h6>
									<?php
										links('p');
									?>
								</div>
								<div class="col-md-4 col-lg-3 col-xl-3">
									<h6 class="text-uppercase font-weight-bold">
										<strong>Contato</strong>
									</h6>
									<p>
										<a href="mailto:cti73c@gmail.com" class="text-hou-green"><i class="fa fa-envelope mr-3"></i>
											cti73c@gmail.com</a>
									</p>
								</div>
							</div>
						</div>
						<div class="footer-copyright py-3 text-center">
							&copy; 2018 Todos os direitos reservados a
							<a>
								<b class="text-hou-green">Houzion Group</b>
							</a>
						</div>
					</footer>
					<?php
				}
			?>
		</div>
	</body>
</html>
