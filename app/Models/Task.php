<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $casts = [
        'is_done' => 'boolean'
    ];

    protected $fillable = [
        'nome',
        'is_done',
        'project_id'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    protected static function booted(): void
    {
        static::addGlobalScope('creator', function(Builder $builder){
            $builder->where('creator_id', Auth::id());
        });
    }

}
