<?php

session_start();
require_once __DIR__ . '/../core/conectaDatabase.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$evento_id = $_GET['id'];

$stmt = $conexao->prepare("INSERT INTO participacoes (idUsuario, idEvento) VALUES (:usuario_id, :evento_id)");
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->bindParam(':evento_id', $evento_id, PDO::PARAM_INT);
$stmt->execute();

header('Location: paginaEvento.php');
exit();

?>
