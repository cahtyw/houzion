<?php
	session_start();
	if(!$_SESSION['logged']) {
		require "../api/Modal.php";
		if(isset($_POST['email-or-user']) && isset($_POST['password'])) {
			$password = md5($_POST['password']);
			$login = $_POST['email-or-user'];
			$sql = "SELECT usuario.codigo, usuario.nome, usuario.codigo_acesso, usuario.codigo_familia, usuario.codigo_grupo FROM usuario WHERE (LOWER(email) = LOWER($1) OR LOWER(login) = LOWER($1)) AND senha = $2 AND exclusao IS NULL";
			$pgsql = new PostgreSQL();
			$params = [$login, $password];
			$array = $pgsql->QueryArray($sql, $params)[0];
			if($array) {
				$_SESSION['logged'] = TRUE;
				$_SESSION['user-code'] = $array['codigo'];
				$_SESSION['user-name'] = $array['nome'];
				$_SESSION['user-level'] = $array['codigo_acesso'];
				$_SESSION['user-group'] = $array['codigo_grupo'];
				$_SESSION['user-family'] = $array['codigo_familia'];
				$redirect = "../admin.php";
				echo '{"login":"sucesso"}';
				echo("<script type='text/javascript'>alert('Logou, ".$_SESSION['name']."')</script>");
			}
			else {
				$_SESSION['try-login'] = TRUE;
				$redirect = "../login.php";
				echo '{"login":"erro"}';
				echo("<script type='text/javascript'>alert('Não há nenhum usuário registrado')</script>");
			}
			$pgsql->DisconnectServer();

			header("Location: $redirect");
		}
	}
?>