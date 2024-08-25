<?php

require_once __DIR__ . '/../core/conectaDatabase.php';
require_once __DIR__ . '/../model/Evento.php';

class EventoController {

    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function listar() {
        $stmt = $this->conexao->prepare("SELECT * FROM eventos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Evento');
    }

    public function buscar($id) {
        $stmt = $this->conexao->prepare("SELECT * FROM eventos WHERE idevento = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('Evento');
    }

    public function criar($evento) {
        $stmt = $this->conexao->prepare("INSERT INTO eventos (nome, descricao, conteudo, data_inicio, data_fim) VALUES (:nome, :descricao, :conteudo, :data_inicio, :data_fim)");
        $stmt->bindParam(':nome', $evento->nome);
        $stmt->bindParam(':descricao', $evento->descricao);
        $stmt->bindParam(':conteudo', $evento->conteudo);
        $stmt->bindParam(':data_inicio', $evento->data_inicio);
        $stmt->bindParam(':data_fim', $evento->data_fim);
        return $stmt->execute();
    }

    public function atualizar($evento) {
        $stmt = $this->conexao->prepare("UPDATE eventos SET nome = :nome, descricao = :descricao, conteudo = :conteudo, data_inicio = :data_inicio, data_fim = :data_fim WHERE id = :id");
        $stmt->bindParam(':id', $evento->id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $evento->nome);
        $stmt->bindParam(':descricao', $evento->descricao);
        $stmt->bindParam(':conteudo', $evento->conteudo);
        $stmt->bindParam(':data_inicio', $evento->data_inicio);
        $stmt->bindParam(':data_fim', $evento->data_fim);
        return $stmt->execute();
    }

    public function deletar($idevento) {
        // Excluir as participações associadas ao evento
        $stmt = $this->conexao->prepare("DELETE FROM participacoes WHERE idevento = :idevento");
        $stmt->bindParam(':idevento', $idevento, PDO::PARAM_INT);
        $stmt->execute();
    
        // Agora excluir o evento
        $stmt = $this->conexao->prepare("DELETE FROM eventos WHERE idevento = :idevento");
        $stmt->bindParam(':idevento', $idevento, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
