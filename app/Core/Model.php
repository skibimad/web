<?php

namespace App\Core;

/**
 * Base Model - Active Record Pattern
 */
abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $attributes = [];
    
    public function __construct(array $attributes = [])
    {
        $this->db = Database::getInstance()->getConnection();
        $this->fill($attributes);
    }
    
    /**
     * Fill model with attributes
     */
    public function fill(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }
    
    /**
     * Get attribute value
     */
    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }
    
    /**
     * Set attribute value
     */
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }
    
    /**
     * Find all records
     */
    public static function all(): Collection
    {
        $instance = new static();
        $stmt = $instance->db->query("SELECT * FROM {$instance->table}");
        $results = $stmt->fetchAll();
        
        return new Collection(array_map(function($row) {
            return new static($row);
        }, $results));
    }
    
    /**
     * Find record by primary key
     */
    public static function find($id): ?self
    {
        $instance = new static();
        $stmt = $instance->db->prepare("SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = ? LIMIT 1");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        
        return $result ? new static($result) : null;
    }
    
    /**
     * Find records by condition
     */
    public static function where(string $column, $value): Collection
    {
        $instance = new static();
        $stmt = $instance->db->prepare("SELECT * FROM {$instance->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        $results = $stmt->fetchAll();
        
        return new Collection(array_map(function($row) {
            return new static($row);
        }, $results));
    }
    
    /**
     * Save model (insert or update)
     */
    public function save(): bool
    {
        if (isset($this->attributes[$this->primaryKey])) {
            return $this->update();
        }
        return $this->insert();
    }
    
    /**
     * Insert new record
     */
    protected function insert(): bool
    {
        $columns = array_keys($this->attributes);
        $placeholders = array_fill(0, count($columns), '?');
        
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(array_values($this->attributes));
        
        if ($result) {
            $this->attributes[$this->primaryKey] = $this->db->lastInsertId();
        }
        
        return $result;
    }
    
    /**
     * Update existing record
     */
    protected function update(): bool
    {
        $id = $this->attributes[$this->primaryKey];
        unset($this->attributes[$this->primaryKey]);
        
        $columns = array_keys($this->attributes);
        $setClause = implode(', ', array_map(fn($col) => "$col = ?", $columns));
        
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
        
        $stmt = $this->db->prepare($sql);
        $values = array_values($this->attributes);
        $values[] = $id;
        
        $result = $stmt->execute($values);
        
        $this->attributes[$this->primaryKey] = $id;
        
        return $result;
    }
    
    /**
     * Delete record
     */
    public function delete(): bool
    {
        if (!isset($this->attributes[$this->primaryKey])) {
            return false;
        }
        
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$this->attributes[$this->primaryKey]]);
    }
    
    /**
     * Get all attributes as array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
