<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Storage;
use Throwable;

class ResetWebResultsCommand extends Command
{
    protected $signature = 'results:reset';

    protected $description = 'Vide la base joueurs, parties, manches, etc..';

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        if (!$this->askWithCompletion(
            '⚠️ Cette commande va vider les tables joueurs, parties, manches, etc.. Continuer ? [Oui] [Non]',
            ['Oui', 'Non'],
            'Non'
        )) {
            $this->info('Aucune action effectuée.');
            return;
        }

        DB::table('game_players')->delete();
        DB::table('games')->delete();
        DB::table('hand_players')->delete();
        DB::table('hands')->delete();

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
