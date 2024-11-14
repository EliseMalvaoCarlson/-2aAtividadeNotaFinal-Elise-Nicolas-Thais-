<?php
try {
    $pdo = new PDO('sqlite:database.db');

    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT NOT NULL
            )";
    $pdo->exec($sql);
    
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action == 'create') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (:nome, :email)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            echo "Registro criado com sucesso!";
        } else {
            echo "Erro ao criar registro!";
        }
    }

    if ($action == 'read') {
        $stmt = $pdo->query("SELECT * FROM usuarios");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    if ($action == 'update') { 
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            echo "Registro atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar registro!";
        }
    }

    if ($action == 'delete') {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo "Registro deletado com sucesso!";
        } else {
            echo "Erro ao deletar registro!";
        }
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

