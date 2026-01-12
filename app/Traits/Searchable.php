<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Scope untuk search by single query param
     *
     * @param Builder $query
     * @param string|null $search
     * @param array $columns kolom yang bisa di-search
     */
    public function scopeSearch(Builder $query, ?string $search, array $columns = [])
    {
        if (!$search) {
            return $query;
        }

        $columns = $columns ?: ($this->searchable ?? []);

        return $query->where(function (Builder $q) use ($search, $columns) {

            // Search by ID jika numeric
            if (is_numeric($search)) {
                $q->where($this->getKeyName(), $search);
            }

            // Search ke kolom lain
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
            }
        });
    }
}
