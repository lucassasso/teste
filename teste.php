<html>
<head>
<title>Como criar tabelas com PHP</title>
</head>
<body>


<?php
/* Variáveis PDO */
$bd = 'teste';
$usuario_bd = 'root';
$senha_bd   = '';
$host_db    = 'localhost';
$conexao_pdo = null;
 
/* Concatenação das variáveis para detalhes da classe PDO */
$detalhes_pdo = 'mysql:host=' . $host_db . ';dbname='. $bd;
 
// Tenta conectar
try {
    // Cria a conexão PDO com a base de dados
    $conexao_pdo = new PDO($detalhes_pdo, $usuario_bd, $senha_bd);
    print "Conectado<br>";
} catch (PDOException $e) {
    // Se der algo errado, mostra o erro PDO
    print "Erro: " . $e->getMessage() . "<br/>";
    // Mata o script
    die();
}
// Nosso novo banco de dados

// Cria o banco de dados e da permissão para nosso usuário no mesmo
$verifica = $conexao_pdo->exec(
    "CREATE DATABASE IF NOT EXISTS `$bd`;
    GRANT ALL ON `$bd`.* TO '$usuario_bd'@'localhost';
    FLUSH PRIVILEGES;
    CREATE TABLE IF NOT EXISTS `$bd`.`cliente` (
        cliente_id INT(11) NOT NULL AUTO_INCREMENT,
        cliente_nome VARCHAR(255),
        cliente_endereco VARCHAR(255),
        PRIMARY KEY ( cliente_id )
    )"
);

// Verificamos se a base de dados foi criada com sucesso
if ( $verifica ) {
    echo 'Comandos MySQL executados com sucesso!';
} else {
    echo 'Falha!';
}

try {
  $pdo = new PDO('mysql:host=localhost;dbname=teste', $usuario_bd, $senha_bd);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  $stmt = $pdo->prepare('INSERT INTO cliente (cliente_nome,cliente_endereco) VALUES(:nome,:endereco)');
  $stmt->execute(array(
    ':nome' => 'Lucas Sasso',
    ':endereco' => 'Hassib Jezzini 646'
  ));
   
  echo '<br> Inserido: ' . $stmt->rowCount(). '<br>'; 
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}


//Update

  
$id = 2;
$cliente_nome = "Novo nome do Lucas";
$cliente_endereco = "Vila Fanny";
try {
  $pdo = new PDO('mysql:host=localhost;dbname=teste', $usuario_bd, $senha_bd);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  $stmt = $pdo->prepare('UPDATE cliente SET cliente_nome = :nome, cliente_endereco = :endereco WHERE cliente_id = :id');
  $stmt->execute(array(
    ':id'   => $id,
    ':nome' => $cliente_nome,
    ':endereco' => $cliente_endereco
  ));
     
  echo 'Atualizado: ' . $stmt->rowCount() . '<br>'; 
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

//Delete
$id = 4; 
   
try {
  $pdo = new PDO('mysql:host=localhost;dbname=teste', $usuario_bd, $senha_bd);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  $stmt = $pdo->prepare('DELETE FROM cliente WHERE cliente_id = :id');
  $stmt->bindParam(':id', $id); 
  $stmt->execute();
     
  echo 'Excluído id: '. $stmt->rowCount(); 
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage(). '<br>';
}

//select

$data = $pdo->query("SELECT * FROM cliente")->fetchAll();
// and somewhere later:
echo "<br><br>
<table>
<thead>
<tr>
<td>Cliente</td>
<td>Endereço</td>
</tr>";
foreach ($data as $row) {
    echo "
    <tr>
    <td>" . $row['cliente_nome']. '</td><td>' . $row['cliente_endereco'] . "</td></tr>";
}
echo "</table>"
?>
</body>
</html>