<?php

Class Usuario {

    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function inserirUsuario($usuario) {
        try {
            $sql = "INSERT INTO usuario (nome, email, senha, imagem) VALUES (:nome, :email, :senha, :imagem)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(':nome', $usuario->nome);
            $stmt->bindParam(':email', $usuario->email);
            $stmt->bindParam(':senha', $usuario->senha);
            $stmt->bindParam(':imagem', $usuario->imagem); // Adiciona o caminho da imagem
    
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
            return false;
        }
    }
    


    public function atualizarUsuario($id, $nome, $email, $senha, $imagem)
    {
        try {
            $sql = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, imagem = :imagem WHERE idusuario = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            $stmt->bindParam(':imagem', $imagem, PDO::PARAM_STR);
            
            // Executa a query
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            throw new Exception('Erro ao atualizar o usuário: ' . $e->getMessage());
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

    public function buscarUsuarioPorId($id)
    {
        try {
            // Prepara a consulta para buscar o usuário pelo ID
            $stmt = $this->conexao->prepare('SELECT * FROM usuario WHERE idusuario = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Retorna o resultado como array associativo
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar o usuário: ' . $e->getMessage());
        }
    }

    public function acessarUsuario($email, $senha) {
        try {
            $query = $this->conexao->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha");
            $query->execute(['email' => $email, 'senha' => $senha]);
            $usuario = $query->fetch(); // Coloca os dados num array $usuario
            
            if ($usuario) {
                return $usuario; // Retorna o usuário encontrado
            } else {
                return false; // Retorna falso se não encontrar o usuário
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
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