<?php

namespace App\Models; // Define o namespace para a classe CrudModel dentro do diretório Models

use CodeIgniter\Model; // Importa a classe Model do CodeIgniter para ser estendida

class CrudModel extends Model // Define a classe CrudModel que estende a classe Model
{
    protected $table = 'transfer_table'; // Define o nome da tabela do banco de dados a ser utilizada

    protected $primaryKey = 'id'; // Define o nome da chave primária da tabela

    protected $allowedFields = ['name', 'equipaantiga', 'equipanova', 'modality']; // Define quais campos podem ser inseridos ou atualizados na tabela

    function getData()
    {
        return $this->select('transfer_table.*, team1.name as team_name_equipaantiga, team2.name as team_name_equipanova')
            ->join('team_table as team1', 'transfer_table.equipaantiga = team1.id', 'left')
            ->join('team_table as team2', 'transfer_table.equipanova = team2.id', 'left')
            ->findAll();
    }
}
