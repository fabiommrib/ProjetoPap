<?php

namespace App\Models;

use CodeIgniter\Model;

class TournamentModel extends Model
{
	protected $table = 'tournament_table';

	protected $primaryKey = 'id';

	protected $allowedFields = ['name', 'modality', 'price', 'date'];

}

?>