<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Tudo Sobre Jogos</title>
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
    </style>
    <style>
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
                <li class="nav-item active">
                    <a class="nav-link" href="http://localhost:8080/index.php/news/view">Página Inicial <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/view">Transferências</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/tournament/view">Torneios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/index.php/team/view">Equipas </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="jumbotron mt-4">
            <h1 class="display-4">Bem-vindo ao Tudo Sobre Jogos!</h1>
            <p class="lead">O melhor lugar para ficar atualizado sobre o mundo dos jogos.</p>
            <hr class="my-4">
            <p>Explore as últimas notícias, descubra torneios emocionantes e muito mais.</p>
        </div>

        <h2 class="text-center mt-4 mb-4">Notícias</h2>

        <?php

        $session = \Config\Services::session();

        if($session->getFlashdata('success'))
        {
            echo '
            <div class="alert alert-success">'.$session->getFlashdata("success").'</div>
            ';
        }

        ?>
        
        <!-- Cartões para exibir notícias -->
        <button id="ordenarAscendente" class="btn btn-primary mr-1 float-right "><i class="fas fa-sort"></i></button>




        <div id="noticiasContainer" class="row">
            
    <?php
    if($user_data)
    {
        foreach($user_data as $user)
        {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">'.$user["title"].'</h5>
                        <p class="card-text">'.$user["description"].'</p>
                        <p class="card-text data">Data: '.$user["date"].'</p>
                    </div>
                </div>
            </div>';
        }
    }
    ?>
</div>


        
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var originalCards = []; // Array para armazenar os cartões originais
    var ascendingOrder = false; // Variável para controlar o estado da ordenação

    // Capturando os cartões originais
    var originalCardsHTML = document.querySelectorAll('.card');
    originalCardsHTML.forEach(function(card) {
        originalCards.push(card.cloneNode(true));
    });

    document.getElementById('ordenarAscendente').addEventListener('click', function() {
        var cardsContainer = document.getElementById('noticiasContainer');

        if (!ascendingOrder) {
            // Ordenar os cartões por data ascendente
            var sortedCards = Array.from(originalCards).sort(function(a, b) {
                var dateA = new Date(a.querySelector('.data').textContent);
                var dateB = new Date(b.querySelector('.data').textContent);
                return dateA - dateB;
            });

            ascendingOrder = true;
        } else {
            // Restaurar a ordem original dos cartões
            sortedCards = originalCards.slice();
            ascendingOrder = false;
        }

        cardsContainer.innerHTML = ''; // Limpar o conteúdo do contêiner

        sortedCards.forEach(function(card) {
            var cardWrapper = document.createElement('div');
            cardWrapper.classList.add('col-md-4', 'mb-4');
            cardWrapper.appendChild(card);
            cardsContainer.appendChild(cardWrapper);
        });
    });
});


</script>
</body>
</html>
