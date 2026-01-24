<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use Starter\ServerDocumentation\Database\Factories\ServerFactory;

class Server extends Model
{
    protected $table = 'servers';

    public function getTable(): string
    {
        return $this->table;
    }

    public function belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null, $relatedKey = null, $relation = null): BelongsToMany
    {
        return new BelongsToMany((new $related())->newQuery(), $this, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relation);
    }

    public function newQuery()
    {
        return new class extends Builder {
            public function __construct() { parent::__construct(new \Illuminate\Database\Query\Builder(new \Illuminate\Database\Connection(fn() => null))); }

            public function whereHas($relation, ?Closure $callback = null, $operator = '>=', $count = 1) { return $this; }

            public function withPivot() { return $this; }
            public function withTimestamps() { return $this; }
            public function orderByPivot($column, $direction = 'asc') { return $this; }
        };
    }

    public static function factory()
    {
        return \Starter\ServerDocumentation\Database\Factories\ServerFactory::new();
    }
}