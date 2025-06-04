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
            'completed_at'          => 'datetime',

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

    // Relationship to User model (assuming you have a User model for players)
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    // Relationship to Game model (if you have one)
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    // Check if user has already played this game
    public static function hasUserPlayedGame($playerId, $gameId)
    {
        return static::where('player_id', $playerId)
                    ->where('game_id', $gameId)
                    ->exists();
    }

    // Get user's game result
    public static function getUserGameResult($playerId, $gameId)
    {
        return static::where('player_id', $playerId)
                    ->where('game_id', $gameId)
                    ->first();
    }
}
