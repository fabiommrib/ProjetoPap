<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Admin - Torneios</title>
    <!--  -->
</head>
<style>
    .sidebar {
        height: 100%;
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
        margin-left: 250px;
        padding: 20px;
    }
</style>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Admin</h3>
        <a href="http://localhost:8080/index.php/">Transferências</a>
        <a href="http://localhost:8080/index.php/news">Notícias</a>
        <a href="http://localhost:8080/index.php/tournament">Torneios</a>
        <a href="http://localhost:8080/index.php/team">Equipa</a>
        
        <!-- Add more links as needed -->
    </div>

    <!-- Modal para adição-->
    <div class="modal" id="createTournamentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Torneio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/tournament/create" method="post">
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="modality">Modalidade:</label>
                            <input type="text" class="form-control" id="modality" name="modality" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Prémio:</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Data:</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Criar novo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!-- Modal para edição -->
     <div class="modal" id="editTournamentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Torneio</h5>
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
                            <label for="edit_modality">Modalidade:</label>
                            <input type="text" class="form-control" id="edit_modality" name="modality" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_price">Prémio:</label>
                            <input type="number" class="form-control" id="edit_price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_date">Data:</label>
                            <input type="date" class="form-control" id="edit_date" name="date" required>
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


    <!-- Conteúdo -->
    <div class="content">
        <h2 class="text-center mt-4 mb-4">Torneios</h2>
        <div class="mb-3">
            <input type="text" class="form-control" id="searchInput" placeholder="Pesquisar...">
        </div>

        <?php
        $session = \Config\Services::session();
        if ($session->getFlashdata('success')) {
            echo '<div class="alert alert-success">'.$session->getFlashdata("success").'</div>';
        }
        ?>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createTournamentModal">Adicionar</button>
        <div class="card">
            <div class="card-body">
            

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tournamentTable">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Videojogo</th>
                            <th>Prémio $</th>
                            <th>Data</th>
                            <th>Editar</th>
                            <th>Apagar</th>
                        </tr>
                        <?php
                        if ($user_data) {
                            foreach ($user_data as $user) {
                                echo '<tr>
                                        <td>'.$user["id"].'</td>
                                        <td>'.$user["name"].'</td>
                                        <td>'.$user["modality"].'</td>
                                        <td>'.$user["price"].'</td>
                                        <td>'.$user["date"].'</td>
                                        <td><button class="btn btn-info edit-btn" data-id="'.$user["id"].'" data-name="'.$user["name"].'" data-modality="'.$user["modality"].'" data-price="'.$user["price"].'" data-date="'.$user["date"].'"> Editar </button></td>
                                        
                                        <td>
                                            <button class="btn btn-danger delete-btn" data-id="'.$user["id"].'"> Delete </button>
                                        </td>
                                    </tr>';
                            }
                        }
                        ?>
                    </table>
                </div>
                <div>
                    <?php
                    if ($pagination_link) {
                        $pagination_link->setPath('crud');
                        echo $pagination_link->links();
                    }
                    ?>
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
            table = document.getElementById("tournamentTable");
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


        $(document).ready(function(){
            $('.delete-btn').click(function(){
                var id = $(this).data('id');
                $('#confirmDelete').data('id', id);
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').click(function(){
                var id = $(this).data('id');
                window.location.href = '/tournament/delete/' + id;
            });
        });

        $(document).ready(function(){
            // Quando o botão Editar é clicado, exibe o modal com os dados preenchidos
            $('.edit-btn').click(function(){
                var id = $(this).data('id');
                var name = $(this).data('name');
                var modality = $(this).data('modality');
                var price = $(this).data('price');
                var date = $(this).data('date');
                
                $('#edit_id').val(id);
                $('#edit_name').val(name);
                $('#edit_modality').val(modality);
                $('#edit_price').val(price);
                $('#edit_date').val(date);

                $('#editTournamentModal').modal('show');
            });

            // Quando o botão Atualizar é clicado, envia o formulário de edição via AJAX
            $('#confirmEdit').click(function(){
                var formData = new FormData(document.getElementById("editForm"));
                $.ajax({
                    url: '/tournament/update/' + $('#edit_id').val(),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Lógica de manipulação de sucesso
                        console.log(response);
                        $('#editTournamentModal').modal('hide');
                        location.reload();
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