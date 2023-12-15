<?php

// Dados de conexão com o base de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "charme_animal";

// Criar Conexão com o BD
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Configurar o modo de erro para exceção
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>