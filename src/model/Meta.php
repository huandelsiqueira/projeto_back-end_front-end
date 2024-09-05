<?php
// src/model/Meta.php

class Meta
{
    private $id;
    private $nome;
    private $descricao;
    private $dataInicial;
    private $dataFim;
    private $situacao;
    private $imagem;

        public function __construct($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem, $criadorId)
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->dataInicial = $dataInicial;
        $this->dataFim = $dataFim;
        $this->situacao = $situacao;
        $this->imagem = $imagem;
        $this->criadorId = $criadorId;
    }

    // Meta.php - Função salvar()
    public function salvar($pdo) {
        // Ajuste a query para garantir que todos os parâmetros têm correspondência com o bindParam()
        $sql = "INSERT INTO metas (nome, descricao, dataInicial, dataFim, situacao, imagem, criador_id) 
                VALUES (:nome, :descricao, :dataInicial, :dataFim, :situacao, :imagem, :criador_id)";
                
        $stmt = $pdo->prepare($sql);

        // Aqui, adicione todas as associações de parâmetros corretamente
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(':dataInicial', $this->dataInicial, PDO::PARAM_STR);
        $stmt->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stmt->bindParam(':situacao', $this->situacao, PDO::PARAM_STR);
        $stmt->bindParam(':imagem', $this->imagem, PDO::PARAM_STR);
        
        // Adicione o criador_id com o valor correto da sessão
        $criador_id = $_SESSION['usuario_id'] ?? null;
        if ($criador_id === null) {
            throw new Exception('Usuário não logado ou ID não encontrado na sessão.');
        }
        $stmt->bindParam(':criador_id', $criador_id, PDO::PARAM_INT);

        // Execute a query
        $stmt->execute();
    }


    // Método para buscar todas as metas
    public static function listarTodas($pdo)
    {
        $sql = "SELECT * FROM metas";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar($pdo)
    {
        $sql = "UPDATE metas SET nome = :nome, descricao = :descricao, dataInicial = :dataInicial, 
                dataFim = :dataFim, situacao = :situacao, imagem = :imagem WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':dataInicial', $this->dataInicial);
        $stmt->bindParam(':dataFim', $this->dataFim);
        $stmt->bindParam(':situacao', $this->situacao);
        $stmt->bindParam(':imagem', $this->imagem);
        $stmt->execute();
    }

    public static function buscarPorId($pdo, $id) {
        try {
            $stmt = $pdo->prepare('SELECT * FROM metas WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar a meta: " . $e->getMessage());
        }
    }

    // Método para excluir a meta
    public static function excluir($pdo, $id) {
        try {
            $stmt = $pdo->prepare('DELETE FROM metas WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir a meta: " . $e->getMessage());
        }
    }

    public static function concluir($pdo, $id)
    {
        $sql = "UPDATE metas SET situacao = 'Realizada' WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function iniciar($pdo, $id)
    {
        $sql = "UPDATE metas SET situacao = 'Em Andamento' WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }


    // Outros métodos de CRUD podem ser adicionados aqui

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome($nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of descricao
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao($descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of dataInicial
     */
    public function getDataInicial()
    {
        return $this->dataInicial;
    }

    /**
     * Set the value of dataInicial
     */
    public function setDataInicial($dataInicial): self
    {
        $this->dataInicial = $dataInicial;

        return $this;
    }

    /**
     * Get the value of dataFim
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * Set the value of dataFim
     */
    public function setDataFim($dataFim): self
    {
        $this->dataFim = $dataFim;

        return $this;
    }

    /**
     * Get the value of situacao
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set the value of situacao
     */
    public function setSituacao($situacao): self
    {
        $this->situacao = $situacao;

        return $this;
    }

    /**
     * Get the value of imagem
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set the value of imagem
     */
    public function setImagem($imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }
}
?>