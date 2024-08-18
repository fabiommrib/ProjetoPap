<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
	protected $table = 'news_table';

	protected $primaryKey = 'id';

	protected $allowedFields = ['title', 'description', 'date'];

}

?>