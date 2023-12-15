<?php
require_once 'ConexaoBanco.php';

// Conectar ao banco de dados (substitua os valores conforme necessário)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "charme_animal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Receber dados do formulário (validação pode ser adicionada aqui)
$email = $conn->real_escape_string($_POST['email']);
$senha = $conn->real_escape_string($_POST['senha']);

// Consulta SQL usando declaração preparada
$sql = "SELECT id, senha FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar se o login é válido
if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    // Verificar a senha usando password_verify
    if (password_verify($senha, $usuario['senha'])) {
        // Login válido, redirecione para uma página segura
        header("Location: index.html");
    } else {
        // Senha incorreta, redirecione para a página de login com uma mensagem de erro
        header("Location: login.php?erro=1");
    }
} else {
    // Login inválido, redirecione para a página de login com uma mensagem de erro
    header("Location: login.php?erro=1");
}

// Fechar a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
