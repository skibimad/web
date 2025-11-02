<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Episode Model
 */
class Episode extends Model {
    protected $table = 'episodes';

    public function findAll($orderBy = 'episode_number ASC') {
        return parent::findAll($orderBy);
    }
}
