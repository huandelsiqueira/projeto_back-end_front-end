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
        $meta = new Meta($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem);
        $meta->setId($id);
        $meta->atualizar($this->pdo);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $dataInicial = $_POST['dataInicial'];
            $dataFim = $_POST['dataFim'];
            $situacao = 'Não Iniciada'; // Meta começa sempre como 'Em Andamento'

            // Tratamento de upload de imagem
            $imagem = '';
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
                $imagemNome = uniqid() . '-' . basename($_FILES['imagem']['name']); // Nome único para evitar conflitos
                $caminhoImagem = '../../images/uploads/' . $imagemNome;
                
                // Verifica se o diretório existe, se não, cria
                if (!file_exists('../../images/uploads/')) {
                    mkdir('../../images/uploads/', 0777, true);
                }

                // Move o arquivo de upload para o diretório especificado
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
                    $imagem = $imagemNome; // Salva o nome da imagem para o banco de dados
                } else {
                    echo "Erro ao salvar a imagem. Verifique as permissões da pasta e o caminho.";
                    exit; // Adiciona um exit para evitar continuar em caso de erro
                }
            } else if (isset($_FILES['imagem'])) {
                echo "Erro no upload da imagem: " . $_FILES['imagem']['error'];
                exit; // Adiciona um exit para evitar continuar em caso de erro
            }

            $this->adicionarMeta($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem);

            header('Location: ./paginaMeta.php');
            exit();
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
