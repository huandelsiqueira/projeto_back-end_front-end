<?php

class Usuario {

    private $pdo;
    private $id;
    private $nome;
    private $email;

    public function __construct($pdo, $id, $nome, $email) {

        $this->pdo = $pdo;
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;

    }

    /**
     * Get the value of pdo
     */ 
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * Set the value of pdo
     *
     * @return  self
     */ 
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
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
     *
     * @return  self
     */ 
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function salvar() {

        if ($this->id) {

            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['nome' => $this->nome, 'email' => $this->email, 'id' => $this->id]);

        } else {

            $sql = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['nome' => $this->nome, 'email' => $this->email]);
            
        }
    }

}

?>