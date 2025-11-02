<?php

namespace App\Core;

/**
 * Collection class - holds model instances
 */
class Collection implements \Iterator, \Countable, \ArrayAccess
{
    private $items = [];
    private $position = 0;
    
    public function __construct(array $items = [])
    {
        $this->items = array_values($items);
    }
    
    /**
     * Add item to collection
     */
    public function add($item): self
    {
        $this->items[] = $item;
        return $this;
    }
    
    /**
     * Get all items
     */
    public function all(): array
    {
        return $this->items;
    }
    
    /**
     * Get first item
     */
    public function first()
    {
        return $this->items[0] ?? null;
    }
    
    /**
     * Get last item
     */
    public function last()
    {
        return end($this->items) ?: null;
    }
    
    /**
     * Filter collection
     */
    public function filter(callable $callback): self
    {
        return new self(array_filter($this->items, $callback));
    }
    
    /**
     * Map collection
     */
    public function map(callable $callback): self
    {
        return new self(array_map($callback, $this->items));
    }
    
    /**
     * Check if collection is empty
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }
    
    /**
     * Convert collection to array
     */
    public function toArray(): array
    {
        return array_map(function($item) {
            return method_exists($item, 'toArray') ? $item->toArray() : $item;
        }, $this->items);
    }
    
    // Iterator implementation
    public function current()
    {
        return $this->items[$this->position];
    }
    
    public function key()
    {
        return $this->position;
    }
    
    public function next(): void
    {
        ++$this->position;
    }
    
    public function rewind(): void
    {
        $this->position = 0;
    }
    
    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }
    
    // Countable implementation
    public function count(): int
    {
        return count($this->items);
    }
    
    // ArrayAccess implementation
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }
    
    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }
    
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }
    
    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }
}
