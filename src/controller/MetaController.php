<?php

 // Start the session here
include_once '../core/conectaDatabase.php';
include_once '../model/Meta.php';

class MetaController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = conectaDatabase();  // Chama a função diretamente para obter a conexão PDO
    }

    public function listarMetas()
    {
        return Meta::listarTodas($this->pdo);
    }

    public function adicionarMeta($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem)
    {
        // Verificar se o usuário está logado antes de capturar o ID
        if (!isset($_SESSION['usuario_id'])) {
            throw new Exception('Usuário não logado ou ID não encontrado na sessão.');
        }

        $criadorId = $_SESSION['usuario_id']; // Captura o ID do usuário logado
        $meta = new Meta($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem, $criadorId);
        $meta->salvar($this->pdo);
    }

    public function editarMeta($id, $nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem)
    {
        // Buscar meta existente
        $metaExistente = Meta::buscarPorId($this->pdo, $id);

        if (!$metaExistente) {
            throw new Exception('Meta não encontrada.');
        }

        // Manter a imagem existente se nenhuma nova for enviada
        if (empty($imagem)) {
            $imagem = $metaExistente['imagem']; // Mantém a imagem atual se uma nova não for fornecida
        }

        $meta = new Meta($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem);
        $meta->setId($id);
        
        if (!$meta->atualizar($this->pdo)) {
            throw new Exception('Erro ao atualizar a meta.');
        }
    }

    public function excluirMeta($id)
    {
        // Verifica se o usuário está logado antes de tentar excluir a meta
        if (!isset($_SESSION['usuario_id'])) {
            throw new Exception('Usuário não logado.');
        }

        // Recupera a meta pelo ID
        $meta = Meta::buscarPorId($this->pdo, $id);

        // Verifica se a meta existe e se o usuário logado é o criador
        if (!$meta || $meta['criador_id'] != $_SESSION['usuario_id']) {
            throw new Exception('Meta não encontrada ou você não tem permissão para excluí-la.');
        }

        // Exclui a meta
        Meta::excluir($this->pdo, $id);
    }

    public function buscarMetaPorId($id)
    {
        return Meta::buscarPorId($this->pdo, $id);
    }

    public function marcarComoConcluida($id)
    {
        Meta::concluir($this->pdo, $id);
    }

    public function handleCreateMetaRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $dataInicial = $_POST['dataInicial'];
            $dataFim = $_POST['dataFim'];
            $situacao = $_POST['situacao'];
        
            // Tratamento de imagem
            $imagem = $meta['imagem']; // Mantém a imagem atual como padrão
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
                $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $tamanhoMaximo = 2 * 1024 * 1024; // 2MB
                $extensaoImagem = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        
                if (!in_array($extensaoImagem, $extensoesPermitidas)) {
                    echo "Erro: Tipo de arquivo não permitido.";
                    exit();
                }
        
                if ($_FILES['imagem']['size'] > $tamanhoMaximo) {
                    echo "Erro: O arquivo excede o tamanho máximo permitido de 2MB.";
                    exit();
                }
        
                $imagemNome = uniqid() . '-' . basename($_FILES['imagem']['name']);
                $caminhoImagem = '../../images/uploads/' . $imagemNome;
        
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
                    $imagem = $imagemNome; // Atualiza o nome da imagem
                } else {
                    echo "Erro ao salvar a imagem.";
                    exit();
                }
            }
        
            $metaObj = new Meta($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem, $meta['criador_id']);
            $metaObj->setId($id); // Define o ID para editar a meta existente
            
            if ($metaObj->atualizar($pdo)) {
                echo "Meta atualizada com sucesso!";
            } else {
                echo "Erro ao atualizar a meta.";
            }
        }
    }

    public function iniciarMeta($id)
    {
        // Busca a meta pelo ID
        $meta = Meta::buscarPorId($this->pdo, $id);
        
        // Verifica se a meta existe e se o status é 'Não Iniciada'
        if ($meta && $meta['situacao'] == 'Não Iniciada') {
            Meta::iniciar($this->pdo, $id);
        } else {
            throw new Exception('Meta não encontrada ou já foi iniciada.');
        }
    }
}
?>
