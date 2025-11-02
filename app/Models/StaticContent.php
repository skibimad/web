<?php

namespace App\Models;

use Core\Model;

/**
 * StaticContent Model
 */
class StaticContent extends Model {
    protected $table = 'static_content';

    public function findByKey($key) {
        $sql = "SELECT * FROM {$this->table} WHERE content_key = ?";
        return $this->db->fetchOne($sql, [$key]);
    }

    public function updateByKey($key, $value) {
        $sql = "UPDATE {$this->table} SET content_value = ? WHERE content_key = ?";
        return $this->db->execute($sql, [$value, $key]);
    }

    public function getAllAsKeyValue() {
        $rows = $this->findAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['content_key']] = $row['content_value'];
        }
        return $result;
    }
}
