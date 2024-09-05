<?php

class Evento {
    public $idevento;
    public $idUsuario;
    public $nome;
    public $descricao;
    public $conteudo;
    public $data_inicio;
    public $data_fim;
    

    public function __construct($idevento = null, $idUsuario = null, $nome = null, $descricao = null, $conteudo = null, $data_inicio = null, $data_fim = null) {
        $this->idevento = $idevento;
        $this->idUsuario = $idUsuario;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->conteudo = $conteudo;
        $this->data_inicio = $data_inicio;
        $this->data_fim = $data_fim;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->idevento;
    }

    /**
     * Set the value of id
     */
    public function setId($idevento): self
    {
        $this->idevento = $idevento;

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
     * Get the value of conteudo
     */
    public function getConteudo()
    {
        return $this->conteudo;
    }

    /**
     * Set the value of conteudo
     */
    public function setConteudo($conteudo): self
    {
        $this->conteudo = $conteudo;

        return $this;
    }

    /**
     * Get the value of data_inicio
     */
    public function getDataInicio()
    {
        return $this->data_inicio;
    }

    /**
     * Set the value of data_inicio
     */
    public function setDataInicio($data_inicio): self
    {
        $this->data_inicio = $data_inicio;

        return $this;
    }

    /**
     * Get the value of data_fim
     */
    public function getDataFim()
    {
        return $this->data_fim;
    }

    /**
     * Set the value of data_fim
     */
    public function setDataFim($data_fim): self
    {
        $this->data_fim = $data_fim;

        return $this;
    }
}

?>
