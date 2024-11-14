<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD com PHP, JavaScript e SQLite</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <h2>CRUD com PHP, JavaScript e SQLite</h2>
    <form onsubmit="event.preventDefault(); save();">
        <input type="hidden" id="id">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" required> <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" required> <br><br>

        <input type="submit" value="Salvar">
        <button type="button" onclick="clearForm()">Limpar</button>
    </form>

    <h3>Registros</h3>
    <table border="2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="data"></tbody>
    </table>

    <script>
        function loadData() {
            fetch('crud.php?action=read')
                .then(response => response.json())
                .then(data => {
                    let table = document.getElementById('data');
                    table.innerHTML = '';
                    data.forEach(row => {
                        table.innerHTML += `
                        <tr>
                            <td>${row.id}</td>
                            <td>${row.nome}</td>
                            <td>${row.email}</td>
                            <td>
                                <button onclick="edit(${row.id}, '${row.nome}', '${row.email}')">Editar</button>
                                <button onclick="remove(${row.id})">Deletar</button>
                            </td>
                        </tr>
                        `;
                    });
                });
        }

        function save() {
            let id = document.getElementById('id').value;
            let nome = document.getElementById('nome').value;
            let email = document.getElementById('email').value;

            let formData = new FormData();
            formData.append('id', id);
            formData.append('nome', nome);
            formData.append('email', email);

            let action = id ? 'update' : 'create';

            fetch(`crud.php?action=${action}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                loadData();
                clearForm();
            });
        }

        function edit(id, nome, email) {
            document.getElementById('id').value = id;
            document.getElementById('nome').value = nome;
            document.getElementById('email').value = email;
        }

        function remove(id) {
            if (confirm('Tem certeza que deseja excluir?')) {
                fetch(`crud.php?action=delete&id=${id}`)
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        loadData();
                    });
            }
        }

        function clearForm() {
            document.getElementById('id').value = '';
            document.getElementById('nome').value = '';
            document.getElementById('email').value = '';
        }

        window.onload = loadData;
    </script>
</body>
</html>

