<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QueryCacheService
{
    public static function remember($key, $ttl, $query)
    {
        return Cache::remember($key, $ttl, function () use ($query) {
            return DB::table($query['table'])
                ->select($query['select'])
                ->when(isset($query['joins']), function ($q) use ($query) {
                    foreach ($query['joins'] as $join) {
                        $q->leftJoin($join[0], $join[1], $join[2], $join[3]);
                    }
                    return $q;
                })
                ->when(isset($query['where']), function ($q) use ($query) {
                    foreach ($query['where'] as $where) {
                        $q->where($where[0], $where[1], $where[2] ?? null);
                    }
                    return $q;
                })
                ->get();
        });
    }
}