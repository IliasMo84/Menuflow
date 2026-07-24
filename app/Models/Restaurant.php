<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;






class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address',
        'phone',
        'logo',
    ];

    /**
     * Un restaurant appartient à un utilisateur propriétaire.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
 * Un restaurant possède plusieurs catégories.
 */
public function categories(): HasMany
{
    return $this->hasMany(Category::class)->orderBy('sort_order', 'asc');
}

public function tables(): HasMany
{
    return $this->hasMany(Table::class);
}
}