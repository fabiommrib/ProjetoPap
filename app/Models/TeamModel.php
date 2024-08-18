<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table = 'team_table';

    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'country', 'date'];
}

?>