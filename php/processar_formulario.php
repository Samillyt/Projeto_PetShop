<?php
require_once 'ConexaoBanco.php';

// Conexão com o banco de dados (usando PDO)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "charme_animal";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receber os dados do formulário (adicionar validação se necessário)
    $nomeCompleto = $_POST["nomeCompleto"];
    $email = $_POST["email"];
    $dataNascimento = $_POST["dataNascimento"];
    $sexo = $_POST["sexo"];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Iniciar transação
    $pdo->beginTransaction();

    // Inserir os dados no banco de dados
    $stmt = $pdo->prepare("INSERT INTO cadastro (nomeCompleto, email, dataNascimento, sexo, senha) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nomeCompleto, $email, $dataNascimento, $sexo, $senha]);

    // Commit da transação
    $pdo->commit();

    // Redirecionar após o cadastro
    header("Location: processar_login.php");
    exit();
} catch (Exception $e) {
    // Rollback da transação em caso de erro
    $pdo->rollBack();

    // Logar o erro em um arquivo de log ou no console
    error_log("Erro ao processar o formulário: " . $e->getMessage());

    // Exibir uma mensagem amigável para o usuário
    echo "Erro ao processar o formulário. Por favor, tente novamente mais tarde.";
}
?>
