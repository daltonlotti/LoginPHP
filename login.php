<?php
	
	// Validações
	$usuario 	= isset($_POST['txtUsuario']) ? $_POST['txtUsuario'] : '';
	$senha		= isset($_POST['txtSenha']) ? $_POST['txtSenha'] : ''; 

	if (empty($usuario) || empty($senha)) {
		echo "<script>alert('Existe algum campo em branco. Verique!');</script>";
		echo "<script>window.location.href = 'index.php';</script>";
		exit;
	}

	// Connection String
		$strConn = 'mysql:host=localhost;dbname=db_tutoria';
		$db_usuario = 'root';
		$db_senha = 'root';

		try {
			$conexao = new pdo($strConn, $db_usuario, $db_senha);

		} catch (PDOException $erro) {
			echo $erro->getMessage();
			exit;
		}

		$sql = 'SELECT * FROM usuarios WHERE usuario=:usuario AND senha=:senha';
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(':usuario', $usuario);
		$stmt->bindParam(':senha', $senha);
		$stmt->execute();
		$dados = $stmt->fetch(PDO::FETCH_ASSOC);


	// Processando usuário e senha
	if (is_array($dados)) {
		session_start();
		$_SESSION['logado'] = true;
		$_SESSION['id_usuario'] = $dados['id_usuario'];
		$_SESSION['nome'] = $dados['nome'];
		$_SESSION['tipo'] = $dados['tipo'];
		
		
		// Redirecionando
		header('LOCATION: sistema.php');
	} else {
		echo "<script>alert('Usuário ou senha incorreto!');</script>";
		echo "<script>window.location.href = 'index.php';</script>";
	}
