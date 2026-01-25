<?php

namespace App\Console\Commands;

use App\Enums\Miseres;
use App\Models\BgaUser;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Hand;
use App\Models\HandPlayer;
use App\Models\Meet;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Storage;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class ParseWebResultsCommand extends Command
{
    protected $signature = 'web-results:parse';

    protected $description = 'Command description';

    // Regex
    private const string FIND_HAND_ID = '/Revoir Tarot #(\d+)/';
    private const string FIND_GAME_START = '/distribue\sune\snouvelle\smain/';
    private const string FIND_PLAYER_BID = '/(\w+)\s(?:(passe|propose\sune\senchère\s:\s(\d)))/i';
    private const string FIND_TAKER = '/(\w+)\sdevient\sle\spreneur/';
    private const string FIND_KING = '/\w+\sappelle\s(\d{3})/';
    private const string FIND_TAKER_PARTNER = '/(\w+)\spossédait\sla\scarte\sappelée/';
    private const string FIND_MISERE = "/(\w+)\s.+\sune\sMisère\sd'([\w\s(),']+)\./";
    private const string FIND_POIGNEE = '/(\w+)\sdéclare\sune\s(\d)\s:\s(\d+)\sAtouts/';
    private const string FIND_PLAYER_TRICK = '/(\w+)\sremporte\sle\spli/';
    private const string FIND_CONTRACT_REUSSI = '/Le\scontrat\sest\sréussi\savec\s(\d+)\spoints\sde\smieux/';
    private const string FIND_CONTRACT_CHUTE = '/Le\scontrat\sest\schuté\sde\s(\d+)\spoints/';
    private const string FIND_PLAYER_POINTS = '/(\w+)\s(gagne|perd)\s(\d+)\spoints/';
    private const string FIND_GAME_END = '/Fin de la manche/';

    private const array POIGNEES = [1 => 'simple', 2 => 'double', 3 => 'triple', 4 => 'quadruple'];

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        // @TODO : Voir si on peut trier pour exclure les sous-dossiers et les fichiers non-html
        $all_files = Storage::disk('web_results')->allFiles();

        foreach ($all_files as $file) {
            if (!preg_match('/^\d+\.html$/', $file)) {
                continue;
            }

            // @FIXME : Ajouter un try/catch
            DB::beginTransaction();

            // Récupère le fichier à importer
            $crawler = new Crawler(file_get_contents(storage_path("web-results/{$file}")));

            // Crée la manche
            $hand = $this->getHand($crawler);

            // @FIXME : ???
            if (empty($hand)) {
                $this->error('Aucune manche trouvée.');
                DB::rollBack();
                return;
            }

            // Récupère les joueur.euse.s de la manche
            $hand_players = $this->getHandPlayers($crawler, $hand->id);

            if (empty($hand_players)) {
                $this->error('Aucun joueur trouvé.');
                DB::rollBack();
                return;
            }

            // Début du parsing des résultats
            $this->parseResults($crawler, $hand, $hand_players);
            $hand->save();

            DB::commit();
            Storage::disk('web_results')->move("/{$file}", "/parsed/{$file}");
            $this->info("✅ {$file}");
        }

        $this->info('Fini !');
    }

    /**
     * Crée le Meet et la Manche puis renvoie la Manche
     * @param Crawler $crawler
     * @return Hand
     */
    private function getHand(Crawler $crawler): Hand
    {
        // Récupère la date de début
        $hand_start_date = Carbon::createFromFormat(
            'd/m/Y H:i:s',
            $crawler->filter('#gamelogs .smalltext span')->first()->text()
        );

        $meet_date = $hand_start_date->copy()->startOfDay();

        // Récupération ou création du Meet
        $meet = Meet::query()
            ->select('id')
            ->whereDate('started_at', $meet_date)
            ->first();

        // @FIXME : Jeter une erreur si problème (genre la date existe déjà)
        if (empty($meet)) {
            $meet = Meet::create(['started_at' => $meet_date]);
        }

        $c_bga_hand_id = $crawler->filter('#reviewtitle')->first();

        // Création de la Manche
        // @FIXME : create() renvoie pas un false si échec ?
        return Hand::create([
            'meet_id' => $meet->id,
            'started_at' => $hand_start_date,
            'bga_hand_id' => $c_bga_hand_id->count() > 0
                && preg_match(self::FIND_HAND_ID, $c_bga_hand_id->text(), $m_bga_hand_id)
                    ? $m_bga_hand_id[1]
                    : null,
        ]);
    }

    /**
     * @param Crawler $crawler
     * @param int $hand_id
     * @return array|bool
     */
    private function getHandPlayers(Crawler $crawler, int $hand_id): array|bool
    {
        $hand_players = [];
        $c_bga_players = $crawler->filter('#game_result .score-entry');

        if ($c_bga_players->count() === 0) {
            return false;
        }

        $c_bga_players->each(function (Crawler $node) use ($hand_id, &$hand_players) {
            $bga_username = $node->filter('.playername')->first()->text();

            // @FIXME: Throw si $bga_username vide
            // @FIXME : Dé-delete si username déjà pris ?
            // Récupère ou crée les users BGA
            $bga_user = BgaUser::query()
                ->select(['id', 'bga_username'])
                ->where('bga_username', $bga_username)
                ->whereNull('deleted_at')
                ->first();

            if (empty($bga_user)) {
                $bga_user = BgaUser::create(['bga_username' => $bga_username]);
            }

            // Crée les joueurs de la manche
            $hand_players[$bga_username] = HandPlayer::create([
                'bga_user_id' => $bga_user->id,
                'hand_id' => $hand_id,
                'total_points' => intval(str_replace(
                    ['(', ' ', 'pt', ')'],
                    '',
                    $node->children('.score')->first()->text()
                )),
            ]);
        });

        return !empty($hand_players) ? $hand_players : false;
    }

    /**
     * @param Crawler $crawler
     * @param Hand $hand
     * @param HandPlayer[] $hand_players
     * @return void
     */
    private function parseResults(Crawler $crawler, Hand &$hand, array $hand_players): void
    {
        $c_gamelogs = $crawler->filter('#gamelogs > div:not(.reflexiontimes_block)');
        $i = 1;
        $game = null;
        $game_players = [];
        $start_date = $hand->started_at->format('Y-m-d');

        $c_gamelogs->each(
            function (Crawler $node)
            use ($start_date, $hand_players, &$i, &$hand, &$game, &$game_players) {
            $node_text = preg_replace("/\xc2\xa0/", ' ', $node->text());

            // Début de partie
            if (!empty(preg_match(self::FIND_GAME_START, $node_text))) {
                $i = 1;

                // Sibling suivant du node actuel qui contient un span qui contient la date de début de partie
                $start_time_text = $node->nextAll()
                    ->filter('.smalltext')
                    ->first()
                    ->children('span')
                    ->first()
                    ->text();

                $game = Game::create([
                    'hand_id' => $hand->id,
                    'started_at' => strtotime($start_date . ' ' . $start_time_text),
                ]);

                $game_players = [];
            }

            // Joueur.euse enchérit
            if (!empty(preg_match(self::FIND_PLAYER_BID, $node_text, $m_bid))) {
                $game_players[$m_bid[1]] = [
                    'game_id' => $game->id,
                    'hand_player_id' => $hand_players[$m_bid[1]]->id,
                    'order' => $i,
                    'bga_bid_id' => $m_bid[2] !== 'passe' ? $m_bid[3] : null,
                    'role' => 'defender',
                    'nb_tricks' => 0,
                    'points' => 0,
                ];

                $i++;
            }

            // Joueur.euse prend
            if (!empty(preg_match(self::FIND_TAKER, $node_text, $m_taker))) {
                $game_players[$m_taker[1]]['role'] = 'taker';
            }

            // Preneur.euse appelle un Roi
            if (!empty(preg_match(self::FIND_KING, $node_text, $m_king))) {
                $game->king_colour = $m_king[1];
            }

            // Joueur.euse annonce une Misère
            if (!empty(preg_match(self::FIND_MISERE, $node_text, $m_misere))) {
                $game_players[$m_misere[1]]['misere'] = Miseres::from($m_misere[2])->name;
            }

            // Joueur.euse déclare une Poignée
            if (!empty(preg_match(self::FIND_POIGNEE, $node_text, $m_poignee))) {
                $game_players[$m_poignee[1]]['poignee_type'] = self::POIGNEES[$m_poignee[2]];
                $game_players[$m_poignee[1]]['poignee_nb_atouts'] = $m_poignee[3];
            }

            // Joueur.euse dans le camp du/de la preneur.euse
            if (!empty(preg_match(self::FIND_TAKER_PARTNER, $node_text, $m_partner))) {
                $game_players[$m_partner[1]]['role'] = 'taker_partner';
            }

            // Joueur.euse fait un pli
            if (!empty(preg_match(self::FIND_PLAYER_TRICK, $node_text, $m_trick))) {
                $game_players[$m_trick[1]]['nb_tricks']++;
            }

            // Fin de la partie
            if (!empty(preg_match(self::FIND_GAME_END, $node_text))) {
                // Premier sibling précédent qui est un .smalltext et contient un span qui contient la date de début de partie
                $end_time_text = $node->previousAll()
                    ->filter('.smalltext')
                    ->first()
                    ->children('span')
                    ->first()
                    ->text();
                $hand->ended_at = $game->ended_at = strtotime($start_date . ' ' . $end_time_text);
            }

            // Contrat remporté
            if (!empty(preg_match(self::FIND_CONTRACT_REUSSI, $node_text, $m_contract_reussi))) {
                $game->contract_points_diff = intval($m_contract_reussi[1]);
            }

            // Contrat chuté
            if (!empty(preg_match(self::FIND_CONTRACT_CHUTE, $node_text, $m_contract_chute))) {
                $game->contract_points_diff = intval("-{$m_contract_chute[1]}");
            }

            // Joueur.euse gagne/perd des points
            if (!empty(preg_match(self::FIND_PLAYER_POINTS, $node_text, $m_points))) {
                $game_players[$m_points[1]]['points'] = intval($m_points[2] === 'perd'
                    ? "-$m_points[3]"
                    : $m_points[3]
                );

                GamePlayer::create($game_players[$m_points[1]]);
                $game->save();
            }
        });
    }
}
