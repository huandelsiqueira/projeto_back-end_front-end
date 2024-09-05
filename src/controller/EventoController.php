<?php

require_once __DIR__ . '/../core/conectaDatabase.php';
require_once __DIR__ . '/../model/Evento.php';

class EventoController {

    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function buscar($idevento) {
        $stmt = $this->conexao->prepare("SELECT * FROM eventos WHERE idevento = :id");
        $stmt->bindParam(':id', $idevento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('Evento');
    }

    public function criar($evento) {
        if (empty($evento->data_fim)) {
            throw new Exception("Data de fim não pode ser nula");
        }
    
        // Verifique se a data está no formato correto antes de inserir
        $stmt = $this->conexao->prepare("INSERT INTO eventos (idUsuario, nome, descricao, conteudo, data_inicio, data_fim) VALUES (:idUsuario, :nome, :descricao, :conteudo, :data_inicio, :data_fim)");
        $stmt->bindParam(':idUsuario', $evento->idUsuario);
        $stmt->bindParam(':nome', $evento->nome);
        $stmt->bindParam(':descricao', $evento->descricao);
        $stmt->bindParam(':conteudo', $evento->conteudo);
        $stmt->bindParam(':data_inicio', $evento->data_inicio);
        $stmt->bindParam(':data_fim', $evento->data_fim);
        return $stmt->execute();
    }
    
    public function atualizar($evento) {
        $stmt = $this->conexao->prepare("UPDATE eventos SET nome = :nome, descricao = :descricao, conteudo = :conteudo, data_inicio = :data_inicio, data_fim = :data_fim WHERE idevento = :idevento");
        $stmt->bindParam(':idevento', $evento->idevento, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $evento->nome);
        $stmt->bindParam(':descricao', $evento->descricao);
        $stmt->bindParam(':conteudo', $evento->conteudo);
        $stmt->bindParam(':data_inicio', $evento->data_inicio);
        $stmt->bindParam(':data_fim', $evento->data_fim);
        return $stmt->execute();
    }

    public function listar() {
        $stmt = $this->conexao->prepare("SELECT idevento, idUsuario, nome, descricao, conteudo, data_inicio, data_fim FROM eventos");
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $eventos = [];
        foreach ($resultados as $linha) {
            $evento = new Evento(
                $linha['idevento'],
                $linha['idUsuario'],
                $linha['nome'],
                $linha['descricao'],
                $linha['conteudo'],
                $linha['data_inicio'],
                $linha['data_fim']
            );
            $eventos[] = $evento;
        }
    
        return $eventos;
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

    public function participar($idUsuario, $idevento) {
        // Verificar se o usuário já está participando do evento
        $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM participacoes WHERE idUsuario = :idUsuario AND idevento = :idevento");
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':idevento', $idevento, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Usuário já está participando do evento
        }
    
        // Inserir nova participação
        $stmt = $this->conexao->prepare("INSERT INTO participacoes (idUsuario, idevento) VALUES (:idUsuario, :idevento)");
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':idevento', $idevento, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function verificarParticipacao($idUsuario, $idevento) {
        $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM participacoes WHERE idUsuario = :idUsuario AND idevento = :idevento");
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':idevento', $idevento, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
}

?>
