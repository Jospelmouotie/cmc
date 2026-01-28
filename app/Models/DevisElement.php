<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevisElement extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'prix_unitaire',
        'description',
        'actif',
        'user_id'
    ];

    protected $casts = [
        'actif' => 'boolean',
        'prix_unitaire' => 'integer'
    ];

    /**
     * Get the user who created this element
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only active elements
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope to search elements
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('nom', 'like', "%{$term}%")
              ->orWhere('code', 'like', "%{$term}%");
        });
    }
}