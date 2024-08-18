<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- Título da página -->
    <title>Transferências</title>

    <!-- Estilos CSS customizados -->
    <style>
        /* Estilos para a paginação */
        .pagination li a {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        /* Estilos para a página ativa da paginação */
        .pagination li.active a {
            z-index: 1;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Estilos para o corpo da página */
        body {
            background-color: #979493;
            /* Cor de fundo cinza claro */
        }
    </style>
</head>

<body>
    <!-- Menu de navegação -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Tudo Sobre Jogos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links do menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!-- Link para a página inicial -->
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/news/view">Página Inicial</a>
                </li>
                <!-- Link para a página de transferências (ativa) -->
                <li class="nav-item active">
                    <a class="nav-link" href="http://localhost:8080/index.php/view">Transferências <span class="sr-only">(current)</span></a>
                </li>
                <!-- Link para a página de torneios -->
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/tournament/view">Torneios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/team/view">Equipas </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo da página -->
    <div class="container">
        <!-- Título da página -->
        <h2 class="text-center mt-4 mb-4">Transferências</h2>

        <!-- Exibe uma mensagem de sucesso, se houver -->
        <?php
        // Inicializa a sessão
        $session = \Config\Services::session();

        // Verifica se há uma mensagem de sucesso na sessão
        if ($session->getFlashdata('success')) {
            // Exibe a mensagem de sucesso em um alerta
            echo '
            <div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
            ';
        }
        ?>

        <!-- Tabela de transferências -->
        <div class="card" style="background-color: #CAC7C5;">
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Pesquisar...">
                </div>
                <div class="table-responsive">
                    <!-- Tabela -->
                    <table class="table table-striped table-bordered" id="crudTable">
                        <tr>
                            <th>Nome</th>
                            <th>De</th>
                            <th>Para</th>
                            <th>Modalidade</th>
                        </tr>
                        <!-- Loop para exibir os dados da transferência -->
                        <?php
                        // Verifica se há dados de transferência
                        if ($user_data) {
                            // Loop pelos dados de transferência
                            foreach ($user_data as $user) {
                                // Exibe os dados de cada transferência em uma linha da tabela
                                echo '
                                <tr>
                                    <td>' . $user["name"] . '</td>
                                    <td>' . $user["team_name_equipaantiga"] . '</td>
                                    <td>' . $user["team_name_equipanova"] . '</td>
                                    <td>' . $user["modality"]   . '</td>
                                </tr>';
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
    </script>
</body>

</html>