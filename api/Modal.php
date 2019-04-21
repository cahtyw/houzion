<?php
	session_start();

	function check_family_permission(){
		if(!($_SESSION['logged'] && $_SESSION['user-level'] == 1)){
			http_response_code(403);
			echo "<h1>403 Forbbiden</h1>";
			echo "You do not have permission to access this page.";
			exit();
		}
	}

	function insert_layout_admin(){
		?>
		<div class="header">
			<nav class="navbar navbar-expand-lg navbar-light bg-hou-green-light">
				<div class="container-fluid">
					<a class="navbar-brand" href="../../../admin.php">
						<img src="../../../images/logo/logo_32.png" alt="" class="">
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
						<?php
							/*if(isset($_SESSION['is-control'])){
								$pg = new PostgreSQL();
								$array = $pg->QueryArray("SELECT ambiente.codigo, ambiente.nome FROM ambiente WHERE ambiente.codigo_familia = $1 ORDER BY ambiente.nome", [$_SESSION['user-family']]);
								?>
								<div class="dropdown" style="margin-left: 22vmin;">
									<button class="btn btn-light dropdown-toggle" type="button" id="amb-selector" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<?=(isset($_SESSION['is-control-amb'])?$_SESSION['is-control-amb']:'Selecione um ambiente')?>
									</button>
									<div class="dropdown-menu" aria-labelledby="amb-selector">
										<?php
											foreach ($array as $any) {
												?>
													<a class="dropdown-item" href="#<?=$any['codigo']?>"><?=$any['nome']?></a>
												<?php
											}
										?>
									</div>
								</div>
								<?php
							}*/
						?>
					</div> -->
				</div>
				<?php
					$pg = new PostgreSQL();
					$data = $pg->QueryArray("SELECT controle.status FROM controle INNER JOIN ambiente ON controle.codigo_ambiente = ambiente.codigo WHERE (controle.codigo_tipo = 1 OR controle.codigo_tipo = 2) AND ambiente.codigo_familia = $1 ORDER BY controle.codigo", [$_SESSION['user-family']]);
					$temp = $data[0]['status'];
					$hum = $data[1]['status'];
					if($temp <= 0)
						$icon = "thermometer-empty";
					else if($temp <= 10)
						$icon = "thermometer-quarter";
					else if($temp <= 20)
						$icon = "thermometer-half";
					else if($temp <= 30)
						$icon = "thermometer-three-quarters";
					else
						$icon = "thermometer-full";
				?>
				<a class="btn btn-light disabled" style="margin-right: 1vmin;">
					<?=$temp."°C"?>
					<i class="fas fa-<?=$icon?> "></i>
				</a>
				
				<a class="btn btn-light disabled" style="margin-right: 1vmin;">
					<?=$hum."%"?>
					<i class="fas fa-tint"></i>
				</a>

				<?php
					unset($array);
					unset($pg);
					$pg = new PostgreSQL();
					$array = $pg->QueryArray("SELECT COUNT(alerta.codigo) AS alertas FROM alerta WHERE NOT alerta.visto");
					if($array[0]['alertas']){
					?>
						<a href="../alert/main.php" class="btn btn-warning" style="margin-right: 1vmin;">
							Alertas <span class="badge badge-light"><?=$array[0]['alertas']?></span>
						</a>
					<?php
					}
					else{
						?>
						<a href="" class="btn btn-success disabled" style="margin-right: 1vmin;">
							Você está seguro
						</a>
						<?php
					}
				?>
				<a class="btn btn-danger my-2 my-sm-0" href="../logout.php"><i class="fa fa-times icons"></i> Sair</a>
			</nav>
		</div>
		<div class="row">
			<div class="col-md-2 left-sidebar .d-sm-none .d-md-block">
				<div class="sidebar-nav">
					<div class="sidebar-welcome">
						<div class="user-image text-center center-align">
							<?php
								switch($_SESSION['user-level']){
									case 1:
										$user_type = "administrador";
										break;
									case 2:
										$user_type = "moderador";
										break;
									case 3:
										$user_type = "usuário";
										break;
									case 4:
										$user_type = "visitante";
										break;
									default:
										$user_type = "error404";
										break;
								}
							?>
							<span class="sidebar-welcome-name">Olá, <b><?=$_SESSION['user-name']?></b>!</span><br>
							<span class="sidebar-welcome-type">Você é um <b><?=$user_type?></b>.</span>
						</div>
					</div>
					<div class="sidebar-divider"></div>
					<a href="../../../admin.php">
						<div class="sidebar-link">
							<i class="fa fa-home icons"></i>
							<span>Início</span>
						</div>
					</a>
					<a href="../alert/main.php">
						<div class="sidebar-link">
							<i class="fa fa-exclamation-triangle icons"></i>
							<span>Alertas</span>
						</div>
					</a>
					<div class="sidebar-divider"></div>
					<?php 
						if($_SESSION['user-level'] == 1){
					?>
							<a href="../control/main.php">
								<div class="sidebar-link">
									<i class="fas fa-gamepad icons"></i>
									<span>Controles</span>
								</div>
							</a>
							<div class="sidebar-divider"></div>
							<a href="../ambient/main.php">
								<div class="sidebar-link">
									<i class="fa fa-columns icons"></i>
									<span>Ambientes</span>
								</div>
							</a>
							<?php 
						}
					?>
					<a href="../schedules/main.php">
						<div class="sidebar-link">
							<i class="fa fa-calendar icons"></i>
							<span>Agendamentos</span>
						</div>
					</a>
					<a href="../scene/main.php">
						<div class="sidebar-link">
							<i class="fas fa-plug icons"></i>
							<span>Cenas</span>
						</div>
					</a>
					<?php 
						if($_SESSION['user-level'] == 1){
					?>
							<div class="sidebar-divider"></div>
							<a href="../family/main.php">
								<div class="sidebar-link">
									<i class="fa fa-users icons"></i>
									<span>Família</span>
								</div>
							</a>
							<a href="../group/main.php">
								<div class="sidebar-link">
									<i class="fas fa-people-carry icons"></i>
									<span>Grupos</span>
								</div>
							</a>
					<?php 
						}
					?>
					<a href="../user/main.php">
						<div class="sidebar-link">
							<i class="fa fa-user-circle icons"></i>
							<span>Usuários</span>
						</div>
					</a>
					<?php 
						if($_SESSION['user-level'] == 100){
					?>
							<a href="">
								<div class="sidebar-link">
									<i class="fas fa-hand-point-down icons"></i>
									<span><i>#Permissões</i></span>
								</div>
							</a>
							<?php 
						}
					?>
				</div>
			</div>
		<?php
	}

	function create_table($table, $actions, $names)
	{
		$names = $names ?: array_keys($table[0]);
		?>
			<div class="button-new-users">
				<a href="#" class="btn btn-dark mb-4 right align-right float-right" onclick="setOption(3, -1)"><b>Criar
						novo</b></a>
			</div>
			<div class="table-users">
				<table class="table table-sm table-hover bg-white">
					<thead class="thead-dark">
						<tr>
							<?php
								foreach($names as $key)
								{
									?>
										<th>
											<?= htmlspecialchars($key) ?>
										</th>
									<?php
								}
								
								if($actions)
								{
									echo "<th>Ações</th>";
								}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
							$cont = 0;
							foreach($table as $linha)
							{
								?>
									<tr>
										<?php
											foreach($names as $key)
											{
												?>
													<td>
														<?= htmlspecialchars($linha[$key]) ?>
													</td>
												<?php
											}
											echo "<td>";
											foreach($actions as $t => $button)
											{
												?>
													<button class="btn btn-<?= $button['type'] ?> btn-sm <?=($_SESSION['user-level'] > 2)?'disabled':''?>" onclick="setOption('<?= $t ?>', <?php echo $linha['#'] ?>)">
														<?= $button['text'] ?>
													</button>
											<?php
											}
											echo "</td>";
										?>
									</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			</div>
		<?php
	}

	class Modal {
		private $pgsql;

		public function __construct() {
			$this->pgsql = new PostgreSQL();
		}


		function GetTableContent($family, $_limit, $_start) {
			try {
				$cont = 0;
				$data = [];
				//$sql = "SELECT * FROM usuario WHERE codigo_familia = $1 ORDER BY codigo";
				$sql = "SELECT usuario.codigo, usuario.nome, usuario.sobrenome, usuario.login, to_char(usuario.data_adicionado, 'DD/MM/YYYY HH24:MI') AS data_adicionado , grupo.nome AS grupo_nome, nivel_acesso.nome as acesso_nome FROM usuario INNER JOIN grupo ON usuario.codigo_grupo = grupo.codigo INNER JOIN nivel_acesso ON usuario.codigo_acesso = nivel_acesso.codigo WHERE usuario.codigo_familia = $1 AND usuario.exclusao IS NULL ORDER BY usuario.codigo LIMIT $2 OFFSET $3";

				$params = [$family, $_limit, $_start];
				$this->pgsql->QueryOnly($sql, $params);
				while($array = $this->pgsql->FetchArray()) {
					$data[$cont] = $array;
					$cont++;
				}
			}
			catch(Exception $e){
				$data = false;
			}
			return $data;
		}

		function ChangeAccessLevel($u, $l){
			$sql = "UPDATE INTO usuario SET codigo_acesso = $1 WHERE codigo = $2";
			$params = [$sql, $l, $u];
			try{
				$this->pgsql->ConnectServer();
				$res = $this->pgsql->Query($sql, $params);
				if($res)
					$flag = TRUE;
				else
					$flag = FALSE;
			}
			catch(Exception $e){
				$flag = FALSE;
				die($e->getMessage());
			}
			$this->pgsql->DisconnectServer();
			return $flag;
		}
	}

	//draw.io -- banco
	class PostgreSQL {
		private $connection;
		private $errorMessage = "<script type='text/javascript'>alert('Oops! Algo de errado não está correto.')</script>";
		private $result;
		private $queryCount;
		private $last_query;

		/*Estabelece a conexão com o banco através de um vetor*/
		function ConnectServer(/*$database*/) {
			$database = array("localhost", "5432", "houzion", "houzion", "pass");
			try {
				$this->connection = pg_connect("host=$database[0] port=$database[1] dbname=$database[2] user=$database[3] password=$database[4]");
				if(!$this->connection) echo("<script type='text/javascript'>alert('A conexão com o PostgreSQL não foi estabelecida.')</script>");
			} catch(Exception $e) {
				die($e->getMessage());
			}
			if(!$this->connection) echo("MERDA\n");
		}

		function ConnectSharedServer(/*$database*/) {
			$database = array("localhost", "5432", "2017_cadastro_compartilhado", "alunocti", "alunocti");
			try {
				$this->connection = pg_connect("host=$database[0] port=$database[1] dbname=$database[2] user=$database[3] password=$database[4]");
				if(!$this->connection) echo("<script type='text/javascript'>alert('A conexão com o PostgreSQL não foi estabelecida.')</script>");
			} catch(Exception $e) {
				die($e->getMessage());
			}
			if(!$this->connection) echo("MERDA\n");
		}

		/*Fecha a conexão com o banco de dados*/
		function DisconnectServer() {
			pg_close($this->connection);
		}

		function create_log($text){
			/*$json = "{code-user: ".$_SESSION['user-code']."; user: ".$_SESSION['user-name']."; family: ".$_SESSION['user-family']."; level: ".$_SESSION['user-level']."}";
			$this->QueryOnly("INSERT INTO registro VALUES(DEFAULT, $1, $2, NOW())", [$text, $json]);*/
		}

		/*Executa um comando em SQL*/
		function Query($query, $array = []) {
			$this->ConnectServer();
			try {

				$this->result = pg_query_params($this->connection, $query, $array);
				$this->last_query = 1;
				if(!$this->result) {
					throw new Exception("ERROR SQL Syntax or Execution: (ID Query:$this->queryCount): $query");
					$this->last_query = 0;
				}
			} catch(Exception $e) {
				//echo $e->getMessage();
				$this->last_query = 0;
				echo("<script>alert('ERROR: Query: $query - Last error: ".pg_last_error()." - Terms: ".json_encode($array)."');</script>");
			}
			$this->queryCount++;
			$this->DisconnectServer();
			$this->result;
		}

		function QueryArray($query, $array = []) {
			$this->ConnectServer();
			try {
				$this->result = pg_query_params($this->connection, $query, $array);
				$this->last_query = 1;
				if(!$this->result) {
					throw new Exception("ERROR SQL Syntax or Execution: (ID Query:$this->queryCount): $query");
					$this->last_query = 0;
				}
			} catch(Exception $e) {
				//echo $e->getMessage();
				$this->last_query = 0;
				echo("<script>alert('ERROR: Query: $query - Last error: ".pg_last_error()." - Terms: ".json_encode($array)."');</script>");
			}
			$this->queryCount++;
			$this->DisconnectServer();
			//return $this->result;
			if($this->result)
				return $this->FetchFullArray();
			else
				return false;
		}

		function QueryOnly($query, $array = []) {
			$this->ConnectServer();
			try {
				$this->result = pg_query_params($this->connection, $query, $array);
				$this->last_query = 1;
				if(!$this->result) {
					$this->last_query = 0;
					throw new Exception("ERROR SQL Syntax or Execution: (ID Query:$this->queryCount): $query");
				}
			} catch(Exception $e) {
				$this->last_query = 0;
				echo("<script>alert('ERROR SQL Syntax or Execution - Query: $query');</script>");
			}
			$this->queryCount++;
			$ret = $this->AffectedRows();
			$this->DisconnectServer();
			return $ret;
			/*if($this->result)
				return $this->FetchArray();
			else
				return false;*/
		}

		function QueryWithoutReturn($query, $array = []) {
			try {
				$this->result = pg_query_params($this->connection, $query, $array);
				$this->last_query = 1;
				if(!$this->result) {
					//throw new Exception("<script>alert('ERROR SQL Syntax or Execution: <br>(ID Query:$this->queryCount): $query');</script>");
					//throw new Exception("A linha de comando falhou.".pg_last_error($this->result));
					throw new Exception("ERROR SQL Syntax or Execution: <br>(ID Query:$this->queryCount): $query");
					$this->last_query = 0;
				}

			} catch(Exception $e) {
				//echo $e->getMessage();
				$this->last_query = 0;
			}
			$this->queryCount++;

			return $this->result;
		}

		/*Determina o total de linhas afetadas por uma Query*/
		function AffectedRows() {
			$result = pg_affected_rows($this->result);
			return $result;
		}

		/*Determina o total de linhas retornadas por uma Query*/
		function NumRows() {
			$result = pg_num_rows($this->result);
			return $result;
		}

		/*Retorna uma linha de resultados como um objeto*/
		function FetchObject() {
			return pg_fetch_object($this->result);
		}

		/*Retorna uma linha de resultados como um array indexado*/
		function FetchRow() {
			return pg_fetch_row($this->result);
		}

		function FetchAssoc() {
			return pg_fetch_assoc($this->result);
		}
		
		function FetchAll() {
			return pg_fetch_all($this->result);
		}

		/*Retorna uma linha de resultados como um array associado*/
		function FetchArray() {
			$this->ConnectServer();
			$array = pg_fetch_array($this->result, NULL, PGSQL_ASSOC);
			$this->DisconnectServer();
			return $array;
		}

		function FetchFullArray(){
			$data = [];
			$cont = 0;
			while($array = pg_fetch_array($this->result, NULL, PGSQL_ASSOC)){
				$data[$cont++] = $array;
			}
			return $data;
		}

		function CheckLastRequest(){
			return $this->last_query;
		}

		/* Retorna a quantidade de comandos (queries) executadas durante o tempo de vida desse objeto*/
		function NumQueries() {
			return $this->querycount;
		}
	}

?>
