<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Admin - Transferências</title>

</head>
<!-- Estilos CSS -->
<style>
    .sidebar {
        height: 100%;
        min-height: 100vh;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #f8f9fa;
        padding-top: 20px;
    }

    .sidebar a {
        padding: 10px 15px;
        text-decoration: none;
        color: #000;
        display: block;
    }

    .sidebar a:hover {
        background-color: #e9ecef;
    }

    .content {
        padding: 20px;
        margin-left: 250px;
        /* Ajuste o valor conforme necessário */
    }

    @media (max-width: 768px) {
        .content {
            margin-left: 0;
        }

        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
            margin-bottom: 20px;
        }
    }
</style>
</head>

<body>
    <!-- Menu -->
    <div class="sidebar">
        <h3 class="text-center">Admin</h3>
        <a href="http://localhost:8080/index.php/">Transferências</a>
        <a href="http://localhost:8080/index.php/news">Notícias</a>
        <a href="http://localhost:8080/index.php/tournament">Torneios</a>
        <a href="http://localhost:8080/index.php/team">Equipa</a>
        <hr>
        <a class="text-center" href="http://localhost:8080/index.php/auth/logout">Logout</a>
    </div>
    <!-- Modal de adição -->
    <div class="modal" id="createCrudModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Transferência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/create" method="post">
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="equipaantiga">Equipa Antiga:</label>
                            <select class="form-control" name="equipaantiga" id="equipaantiga" required>
                                <option value="">--Select Team--</option>
                                <?php foreach ($team as $teams) : ?>
                                    <option value="<?= $teams['id'] ?>"><?= $teams['name'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="equipanova">equipanova:</label>
                            <select class="form-control" name="equipanova" id="equipanova" required>
                                <option value="">--Select Team--</option>
                                <?php foreach ($team as $teams) : ?>
                                    <option value="<?= $teams['id'] ?>"><?= $teams['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="from-group mb-5">
                            <label for="modality">Modalidade:</label>
                            <input type="text" class="form-control" id="modality" name="modality" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para edição -->
    <div class="modal" id="editCrudModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Transferências</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" enctype="multipart/form-data">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_name">Nome:</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_equipaantiga">Equipa Antiga:</label>
                            <select class="form-control" name="equipaantiga" id="edit_equipaantiga" required>
                                <option value="">--Select Team--</option>
                                <?php foreach ($team as $teams) : ?>
                                    <option value="<?= $teams['id'] ?>"><?= $teams['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_equipanova">equipanova:</label>
                            <select class="form-control" name="equipanova" id="edit_equipanova" required>
                                <option value="">--Select Team--</option>
                                <?php foreach ($team as $teams) : ?>
                                    <option value="<?= $teams['id'] ?>"><?= $teams['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_modality">Modalidade:</label>
                            <input type="text" class="form-control" id="edit_modality" name="modality" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmEdit">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Conteúdo principal -->
    <div class="content">
        <div class="container-fluid">
            <h2 class="text-center mt-4 mb-4">Transferências</h2>
            <div class="mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Pesquisar...">
            </div>
            <?php
            // PHP para exibir mensagem de sucesso, se houver sucesso
            $session = \Config\Services::session();

            if ($session->getFlashdata('success')) {
                echo '
            <div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
            ';
            }

            ?>
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createCrudModal">Adicionar</button>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="crudTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>De</th>
                                    <th>Para</th>
                                    <th>Modalidade</th>
                                    <th>Editar</th>
                                    <th>Apagar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Verifica se a variável $user_data está definida e não é vazia
                                if ($user_data) {
                                    // Loop foreach para percorrer cada elemento do array $user_data
                                    foreach ($user_data as $user) {
                                        echo '
                                <tr>
                                    <td>' . $user["id"] . '</td>
                                    <td>' . $user["name"] . '</td>
                                    <td>' . $user["team_name_equipaantiga"] . '</td>
                                    <td>' . $user["team_name_equipanova"] . '</td>
                                    <td>' . $user["modality"] . '</td>
                                    <td><button class="btn btn-info edit-btn" data-id="' . $user["id"] . '" data-name="' . $user["name"] . '" data-equipaantiga="' . $user["equipaantiga"] . '" data-equipanova="' . $user["equipanova"] . '" data-modality="' . $user["modality"] . '"> Editar </button></td>
                                    <td><button class="btn btn-danger delete-btn" data-id="' . $user["id"] . '"> Delete </button></td>
                                </tr>';
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmação de Exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja apagar este item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Apagar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        // Função para filtrar a tabela com base no texto de pesquisa
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("crudTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }

        // Adiciona um ouvinte de eventos ao campo de entrada de pesquisa
        document.getElementById("searchInput").addEventListener("keyup", filterTable);


        $(document).ready(function() {
            // Evento de clique para botões de exclusão
            $('.delete-btn').click(function() {
                var id = $(this).data('id'); // Obtém o ID da transferencia a ser excluída
                $('#confirmDelete').data('id', id); // Define o ID da transferencia no modal de confirmação
                $('#deleteModal').modal('show'); // Exibe o modal de confirmação de exclusão
            });

            // Evento de clique para confirmação de exclusão
            $('#confirmDelete').click(function() {
                var id = $(this).data('id'); // Obtém o ID da transferencia a ser excluído
                window.location.href = '/delete/' + id; // Redireciona para a rota de exclusão com o ID da transferencia
            });
        });

        $(document).ready(function() {
            // Evento de clique para botões de edição
            $('.edit-btn').click(function() {
                var id = $(this).data('id'); // Obtém o ID da transferencia a ser editado
                var name = $(this).data('name'); // Obtém o nome da transferencia
                var equipaantiga = $(this).data('equipaantiga'); // Obtém a equipa antiga do jogador
                var equipanova = $(this).data('equipanova'); // Obtém a equipa nova do jogador
                var modality = $(this).data('modality'); //Obtém a modalidade do jogo do jogador

                // Preencher os campos do modal de edição corretamente
                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#edit_equipaantiga').val(equipaantiga);
                $('#edit_equipanova').val(equipanova);
                $('#edit_modality').val(modality);

                // Exibir o modal de edição correto
                $('#editCrudModal').modal('show');
            });

            // Evento de clique para confirmação de edição
            $('#confirmEdit').click(function() {
                var id = $('#edit_id').val(); // Obtém o ID da transferencia a ser editado
                var formData = new FormData($('#editForm')[0]); // Obtém os dados do formulário de edição
                $.ajax({
                    url: '/update/' + id, // URL para a rota de atualização com o ID da transferencia
                    type: 'POST',
                    data: formData, // Dados do formulário
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Lógica de manipulação de sucesso
                        console.log(response);
                        $('#editCrudModal').modal('hide'); // Esconde o modal de edição
                        location.reload(); // Recarrega a página para exibir as atualizações
                    },
                    error: function(xhr, status, error) {
                        // Lógica de manipulação de erro
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>