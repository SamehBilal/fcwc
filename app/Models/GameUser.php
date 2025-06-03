<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $table    = 'games_users';
    protected $guarded  = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at'            => 'datetime',
            'updated_at'            => 'datetime',
            'deleted_at'            => 'datetime',
        ];
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($player) {
            $latestPlayer = GameUser::withTrashed()->latest('id')->first();
            $nextNumber = $latestPlayer ? intval(substr($latestPlayer->player_id, 2)) + 1 : 1;
            $player->player_id = 'TC' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }

    public function scopeSearch($query, $value)
    {
        $query->where('player_id', 'like', "%{$value}%")
        ->orWhere('game_id', 'like', "%{$value}%")
        ->orWhere('ticket_id', 'like', "%{$value}%")
        ->orWhere('user_id', 'like', "%{$value}%")
        ->orWhere('score', 'like', "%{$value}%");
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'games_users')
            ->using(GameUser::class)
            ->withPivot('player_id', 'score')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'games_users')
            ->using(GameUser::class)
            ->withPivot('player_id', 'score')
            ->withTimestamps();
    }
}
