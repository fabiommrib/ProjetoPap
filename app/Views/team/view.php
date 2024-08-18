
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Equipas</title>
    <!--  -->
    <style>
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

        .pagination li.active a {
            z-index: 1;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        body {
        background-color: #979493; /* cinza claro */
    }
    </style>
</head>
<body>
    <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Tudo Sobre Jogos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/news/view">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/view">Transferências</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/tournament/view">Torneios </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="http://localhost:8080/index.php/team/view">Equipa <span class="sr-only">(current)</span></a>
                </li>

            </ul>
        </div>
    </nav>
    <div class="container">
        
        <h2 class="text-center mt-4 mb-4">Equipas</h2>

        <?php

        $session = \Config\Services::session();

        if($session->getFlashdata('success'))
        {
            echo '
            <div class="alert alert-success">'.$session->getFlashdata("success").'</div>
            ';
        }

        ?>
        <div class="card" style="background-color: #CAC7C5;">
            <div class="card-body">
            <div class="mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Pesquisar...">
            </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="teamTable">
                        <tr>
                            <th>Nome</th>
                            <th>País</th>
                            <th>Data</th>
                       
                        </tr>
                        <?php

                        if($user_data)
                        {
                            foreach($user_data as $user)
                            {
                                echo '
                                <tr>
                                    <td>'.$user["name"].'</td>
                                    <td>'.$user["country"].'</td>
                                    <td>'.$user["date"].'</td>
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
    table = document.getElementById("teamTable");
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