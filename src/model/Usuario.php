<?php

Class Usuario {

    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function inserirUsuario($usuario) {
        try {
            $query = $this->conexao->prepare("INSERT INTO usuario (nome, email, senha, imagem) VALUES (:nome, :email, :senha, :imagem)");
            $resultado = $query->execute([
                'nome' => $usuario->nome,
                'email' => $usuario->email,
                'senha' => $usuario->senha,
                'imagem' => $usuario->imagem
            ]);
            return $resultado;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }


    function alterarUsuario($usuario){
        try {
            $query = $this->conexao->prepare("update usuario set nome= :nome, email = :email, senha= :senha where idusuario = :idusuario");
            $resultado = $query->execute(['nome' => $usuario->getnome(),'email' => $usuario->getemail(), 'senha' => $usuario->getsenha(),'idusuario' => $usuario->getIdUsuario()]);   
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    function deletarUsuario($usuario){
        try {
            $query = $this->conexao->prepare("delete from usuario where idusuario = :idusuario");
            $resultado = $query->execute(['idusuario' => $usuario->getIdUsuario()]);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
 
    function listarUsuario(){
      try {
        $query = $this->conexao->prepare("SELECT * FROM usuario");      
        $query->execute();
        $usuarios = $query->fetchAll();
        return $usuarios;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  

    }

     function buscarUsuario($usuario){
        try {
        $query = $this->conexao->prepare("select * from usuario where idusuario=:idusuario");
        if($query->execute(['idusuario' => $usuario->getIdUsuario()])){
            $usuario = $query->fetch(); //coloca os dados num array $usuario
            return $usuario;
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

    function acessarUsuario($usuario){
        try {
        $query = $this->conexao->prepare("select * from usuario where email=:email and senha=:senha");
        if($query->execute(['email' => $usuario->getemail(), 'senha' => $usuario->getsenha()])){
            $usuario = $query->fetch(); //coloca os dados num array $usuario
          if ($usuario)
            {  
                return $usuario;
            }
        else
            {
                return false;
            }
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

 function pesquisarUsuario($usuario){
        try {
        $query = $this->conexao->prepare("select * from usuario where upper(nome) like :nome");
        if($query->execute(['nome' => $usuario->getnome()])){
            $usuarios = $query->fetchAll(); //coloca os dados num array $usuario
          if ($usuarios)
            {  
                return $usuarios;
            }
        else
            {
                return false;
            }
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

}

?>