<!DOCTYPE html>
<html>
  <head>
    <title>Cadastro De Livros</title>
    <style>
      body {
        background-color: #87CEEB; /* Fundo azul */
        font-family: 'Georgia', sans-serif; /* Fonte padrão */
        color: #333; /* Cor do texto */
      }
      h1 {
        font-family: 'Georgia', serif; /* Fonte do cabeçalho */
        color: #4B0082; /* Cor do texto do cabeçalho */
      }
      h2 {
        font-family: 'Verdana', sans-serif; /* Fonte do subtítulo */
        color: #2E8B57; /* Cor do texto do subtítulo */
      }
      form {
        margin-top: 20px;
      }
      input[type="text"], input[type="number"] {
        padding: 5px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
      }
      input[type="submit"] {
        background-color: #4CAF50; /* Cor do botão */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
      input[type="submit"]:hover {
        background-color: #45a049; /* Cor do botão ao passar o mouse */
      }
      p {
        font-family: 'Courier New', monospace; /* Fonte dos parágrafos */
        color: #000080; /* Cor do texto dos parágrafos */
      }
    </style>
  </head>
  <body>
    <h1>Bem-vindo à Livraria Estácio!</h1>
    <h2>Cadastro De Livros</h2>

    <!-- Formulário para enviar dados -->
    <form method="post" action="">
      Título: <input type="text" name="titulo" required><br><br>
      Autor: <input type="text" name="autor" required><br><br>
      Ano de Publicação: <input type="number" name="ano" required><br><br>
      <input type="submit" value="Cadastrar">
    </form>

    <?php
    // Conexão com o banco de dados SQLite
    $db = new SQLite3('database.db');

    // Criar a tabela "livros" se ela não existir
    $db->exec('CREATE TABLE IF NOT EXISTS livros (
      id INTEGER PRIMARY KEY AUTOINCREMENT, 
      titulo TEXT NOT NULL, 
      autor TEXT NOT NULL, 
      ano INTEGER NOT NULL
    )');

    // Verifica se o formulário foi enviado (via método POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Obtém os valores do formulário
      $titulo = $_POST['titulo'];
      $autor = $_POST['autor'];
      $ano = $_POST['ano'];

      // Prepara e executa a consulta de inserção de dados
      $stmt = $db->prepare('INSERT INTO livros (titulo, autor, ano) VALUES (:titulo, :autor, :ano)');
      $stmt->bindValue(':titulo', $titulo, SQLITE3_TEXT);
      $stmt->bindValue(':autor', $autor, SQLITE3_TEXT);
      $stmt->bindValue(':ano', $ano, SQLITE3_INTEGER);
      $stmt->execute();

      echo "<p>Livro cadastrado com sucesso!</p>";
    }

    // Exibe os livros cadastrados
    echo "<h2>Livros Cadastrados</h2>";
    $result = $db->query('SELECT * FROM livros');
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      echo "<p>ID: {$row['id']} | Título: {$row['titulo']} | Autor: {$row['autor']} | Ano de Publicação: {$row['ano']}</p>";
    }
    ?>
  </body>
</html>