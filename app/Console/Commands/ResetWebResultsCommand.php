<?php

namespace App\Console\Commands;

use App\Models\BgaUser;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Hand;
use App\Models\HandPlayer;
use App\Models\Meet;
use DB;
use Illuminate\Console\Command;
use Storage;
use Throwable;

class ResetWebResultsCommand extends Command
{
    protected $signature = 'web-results:reset';

    protected $description = 'Command description';

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        DB::table('game_player_scores')->delete();
        DB::table('games')->delete();
        DB::table('hand_players')->delete();
        DB::table('hands')->delete();
        DB::table('meets')->delete();

        $all_files = Storage::disk('web_results')->allFiles('/parsed');

        foreach ($all_files as $filepath) {
            if (!preg_match('#^parsed/\d+\.html$#', $filepath)) {
                continue;
            }

            $filename = str_replace('parsed/', '', $filepath);
            Storage::disk('web_results')->move("/{$filepath}", "/{$filename}");
            $this->info("✅ {$filename}");
        }

        $this->info('Fini !');
    }
}
