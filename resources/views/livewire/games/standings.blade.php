<?php

use Livewire\Volt\Component;
use App\Models\GameUser;

new class extends Component {
    public $topPlayers = [];

    public function mount()
    {
        $this->loadTopPlayers();
    }

    public function loadTopPlayers()
    {
        $dbDriver = DB::getDriverName();

        $castExpression = match ($dbDriver) {
            'pgsql' => 'score::integer',
            'mysql' => 'CAST(score AS SIGNED)',
            default => 'score',
        };

        $this->topPlayers = GameUser::with('player')
        ->whereNotNull('user_id')
        ->where('score', '!=', '')
        ->orderByRaw("$castExpression DESC")
        ->limit(10)
        ->get()
        ->toArray();
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="relative h-full flex-1 overflow-hidden">
        <div class="ptable">
            <h1 class="headin text-lg font-bold">Standings</h1>
            <table>
                <tr class="col">
                    <th>#</th>
                    <th>Player</th>
                    <th>Questions</th>
                    <th>Groups</th>
                    <th>Knockouts</th>
                    <th>Champion</th>
                    <th>PTS</th>
                </tr>
                @forelse($topPlayers as $index => $gameUser)
                    <tr class="{{ $index < 3 ? 'wpos' : 'pos' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $gameUser['player']['name'] ?? 'Unknown Player' }}</td>
                        <td>{{ $gameUser['score'] }}</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $gameUser['score'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No players found</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</div>
