<?php

namespace App\Models;

use Core\Model;

/**
 * Episode Model
 */
class Episode extends Model {
    protected $table = 'episodes';

    public function findAll($orderBy = 'episode_number ASC') {
        return parent::findAll($orderBy);
    }
}
