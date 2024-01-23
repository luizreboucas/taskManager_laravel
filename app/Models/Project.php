<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'creator_id'
    ];

    public function tasks():HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function creator():BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    protected static function booted(): void
    {
        static::addGlobalScope('creator', function (Builder $builder) {
            $builder->where('creator_id', Auth::id());
        }); 
    }
}
