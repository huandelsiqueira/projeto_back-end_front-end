<?php

function conectaDatabase() {
    try {
        $conexao = new PDO("mysql:host=localhost; dbname=projeto; charset=utf8", "root", "");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexao;
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        exit;
    }
}

?>
