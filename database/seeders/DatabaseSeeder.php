<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    private $faker;

    public function run(): void
    {
        $this->faker = Faker::create('es_ES');

        $this->command->info('🏟️  Iniciando seeder de torneos de fútbol...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->seedConfederations();   // 6 registros
        $this->seedCountries();        // 48 registros
        $this->seedStadiums();         // 120 registros
        $this->seedTournaments();      // 20 registros
        $this->seedTeams();            // 200 registros
        $this->seedPlayers();          // ~5,000 registros
        $this->seedReferees();         // 300 registros
        $this->seedGroups();           // ~160 registros
        $this->seedGroupTeams();       // ~640 registros (pivot)
        $this->seedMatches();          // ~1,200 registros
        $this->seedGoals();            // ~3,600 registros
        $this->seedCards();            // ~2,400 registros
        $this->seedMatchReferees();    // ~4,800 registros (pivot)

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅  Seeder completado con más de 10,000 registros totales.');
    }

    // ──────────────── CONFEDERACIONES ────────────────
    private function seedConfederations(): void
    {
        $confederations = [
            ['name' => 'UEFA',     'acronym' => 'UEFA',     'region' => 'Europa'],
            ['name' => 'CONMEBOL', 'acronym' => 'CONMEBOL', 'region' => 'Sudamérica'],
            ['name' => 'CONCACAF', 'acronym' => 'CONCACAF', 'region' => 'Norteamérica y Caribe'],
            ['name' => 'CAF',      'acronym' => 'CAF',      'region' => 'África'],
            ['name' => 'AFC',      'acronym' => 'AFC',      'region' => 'Asia'],
            ['name' => 'OFC',      'acronym' => 'OFC',      'region' => 'Oceanía'],
        ];

        foreach ($confederations as $c) {
            DB::table('confederations')->insert(array_merge($c, [
                'logo_url'   => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->line('  ✔ Confederaciones sembradas');
    }

    // ──────────────── PAÍSES ────────────────
    private function seedCountries(): void
    {
        $data = [
            // UEFA
            ['name' => 'España',       'code' => 'ESP', 'confederation_id' => 1],
            ['name' => 'Alemania',      'code' => 'GER', 'confederation_id' => 1],
            ['name' => 'Francia',       'code' => 'FRA', 'confederation_id' => 1],
            ['name' => 'Italia',        'code' => 'ITA', 'confederation_id' => 1],
            ['name' => 'Inglaterra',    'code' => 'ENG', 'confederation_id' => 1],
            ['name' => 'Portugal',      'code' => 'POR', 'confederation_id' => 1],
            ['name' => 'Países Bajos',  'code' => 'NED', 'confederation_id' => 1],
            ['name' => 'Bélgica',       'code' => 'BEL', 'confederation_id' => 1],
            // CONMEBOL
            ['name' => 'Brasil',        'code' => 'BRA', 'confederation_id' => 2],
            ['name' => 'Argentina',     'code' => 'ARG', 'confederation_id' => 2],
            ['name' => 'Uruguay',       'code' => 'URU', 'confederation_id' => 2],
            ['name' => 'Colombia',      'code' => 'COL', 'confederation_id' => 2],
            ['name' => 'Chile',         'code' => 'CHI', 'confederation_id' => 2],
            ['name' => 'Ecuador',       'code' => 'ECU', 'confederation_id' => 2],
            // CONCACAF
            ['name' => 'México',        'code' => 'MEX', 'confederation_id' => 3],
            ['name' => 'Estados Unidos','code' => 'USA', 'confederation_id' => 3],
            ['name' => 'Costa Rica',    'code' => 'CRC', 'confederation_id' => 3],
            ['name' => 'Honduras',      'code' => 'HON', 'confederation_id' => 3],
            ['name' => 'Guatemala',     'code' => 'GUA', 'confederation_id' => 3],
            ['name' => 'Panamá',        'code' => 'PAN', 'confederation_id' => 3],
            // CAF
            ['name' => 'Senegal',       'code' => 'SEN', 'confederation_id' => 4],
            ['name' => 'Marruecos',     'code' => 'MAR', 'confederation_id' => 4],
            ['name' => 'Nigeria',       'code' => 'NGA', 'confederation_id' => 4],
            ['name' => 'Ghana',         'code' => 'GHA', 'confederation_id' => 4],
            ['name' => 'Camerún',       'code' => 'CMR', 'confederation_id' => 4],
            ['name' => 'Costa de Marfil','code'=> 'CIV', 'confederation_id' => 4],
            // AFC
            ['name' => 'Japón',         'code' => 'JPN', 'confederation_id' => 5],
            ['name' => 'Corea del Sur', 'code' => 'KOR', 'confederation_id' => 5],
            ['name' => 'Arabia Saudita','code' => 'KSA', 'confederation_id' => 5],
            ['name' => 'Irán',          'code' => 'IRN', 'confederation_id' => 5],
            ['name' => 'Australia',     'code' => 'AUS', 'confederation_id' => 5],
            // Extra países para equipos de club
            ['name' => 'Croacia',       'code' => 'CRO', 'confederation_id' => 1],
            ['name' => 'Polonia',       'code' => 'POL', 'confederation_id' => 1],
            ['name' => 'Dinamarca',     'code' => 'DEN', 'confederation_id' => 1],
            ['name' => 'Suiza',         'code' => 'SUI', 'confederation_id' => 1],
            ['name' => 'Perú',          'code' => 'PER', 'confederation_id' => 2],
            ['name' => 'Venezuela',     'code' => 'VEN', 'confederation_id' => 2],
            ['name' => 'Bolivia',       'code' => 'BOL', 'confederation_id' => 2],
            ['name' => 'Paraguay',      'code' => 'PAR', 'confederation_id' => 2],
            ['name' => 'El Salvador',   'code' => 'SLV', 'confederation_id' => 3],
            ['name' => 'Jamaica',       'code' => 'JAM', 'confederation_id' => 3],
            ['name' => 'Egipto',        'code' => 'EGY', 'confederation_id' => 4],
            ['name' => 'Túnez',         'code' => 'TUN', 'confederation_id' => 4],
            ['name' => 'Argelia',       'code' => 'ALG', 'confederation_id' => 4],
            ['name' => 'China',         'code' => 'CHN', 'confederation_id' => 5],
            ['name' => 'Qatar',         'code' => 'QAT', 'confederation_id' => 5],
            ['name' => 'Nueva Zelanda', 'code' => 'NZL', 'confederation_id' => 6],
            ['name' => 'Fiji',          'code' => 'FIJ', 'confederation_id' => 6],
        ];

        $rows = array_map(fn ($c) => array_merge($c, [
            'flag_url'   => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]), $data);

        DB::table('countries')->insert($rows);
        $this->command->line('  ✔ Países sembrados');
    }

    // ──────────────── ESTADIOS ────────────────
    private function seedStadiums(): void
    {
        $famous = [
            ['name' => 'Santiago Bernabéu',    'city' => 'Madrid',       'capacity' => 81044, 'country_id' => 1],
            ['name' => 'Camp Nou',              'city' => 'Barcelona',    'capacity' => 99354, 'country_id' => 1],
            ['name' => 'Allianz Arena',         'city' => 'Múnich',       'capacity' => 75000, 'country_id' => 2],
            ['name' => 'Signal Iduna Park',     'city' => 'Dortmund',     'capacity' => 81365, 'country_id' => 2],
            ['name' => 'Stade de France',       'city' => 'París',        'capacity' => 81338, 'country_id' => 3],
            ['name' => 'Wembley Stadium',       'city' => 'Londres',      'capacity' => 90000, 'country_id' => 5],
            ['name' => 'Maracaná',              'city' => 'Río de Janeiro','capacity'=> 78838, 'country_id' => 9],
            ['name' => 'Monumental',            'city' => 'Buenos Aires', 'capacity' => 84567, 'country_id' => 10],
            ['name' => 'Estadio Azteca',        'city' => 'Ciudad de México','capacity'=>87523, 'country_id' => 15],
            ['name' => 'San Siro',              'city' => 'Milán',        'capacity' => 80018, 'country_id' => 4],
            ['name' => 'Estadio Olímpico',      'city' => 'Roma',         'capacity' => 72698, 'country_id' => 4],
            ['name' => 'Anfield',               'city' => 'Liverpool',    'capacity' => 61276, 'country_id' => 5],
            ['name' => 'Old Trafford',          'city' => 'Manchester',   'capacity' => 74310, 'country_id' => 5],
            ['name' => 'Estádio da Luz',        'city' => 'Lisboa',       'capacity' => 64642, 'country_id' => 6],
            ['name' => 'Johan Cruyff Arena',    'city' => 'Ámsterdam',    'capacity' => 54990, 'country_id' => 7],
        ];

        // Estadios famosos
        foreach ($famous as $s) {
            DB::table('stadiums')->insert(array_merge($s, [
                'surface'    => 'natural_grass',
                'year_built' => $this->faker->numberBetween(1950, 2010),
                'latitude'   => $this->faker->latitude,
                'longitude'  => $this->faker->longitude,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Estadios generados aleatoriamente
        $countryIds = DB::table('countries')->pluck('id')->toArray();
        $batch = [];
        for ($i = 0; $i < 105; $i++) {
            $batch[] = [
                'name'       => 'Estadio ' . $this->faker->city . ' ' . $this->faker->randomElement(['Arena', 'Park', 'Stadium', 'Field']),
                'city'       => $this->faker->city,
                'capacity'   => $this->faker->numberBetween(10000, 70000),
                'latitude'   => $this->faker->latitude,
                'longitude'  => $this->faker->longitude,
                'surface'    => $this->faker->randomElement(['natural_grass', 'artificial', 'hybrid']),
                'year_built' => $this->faker->numberBetween(1940, 2020),
                'country_id' => $this->faker->randomElement($countryIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('stadiums')->insert($batch);

        $this->command->line('  ✔ Estadios sembrados');
    }

    // ──────────────── TORNEOS ────────────────
    private function seedTournaments(): void
    {
        $tournaments = [];

        // Mundiales
        foreach ([1990, 1994, 1998, 2002, 2006, 2010, 2014, 2018, 2022] as $year) {
            $tournaments[] = [
                'name'             => "FIFA World Cup {$year}",
                'type'             => 'world_cup',
                'edition_year'     => $year,
                'host_country'     => $this->faker->country,
                'start_date'       => "{$year}-06-01",
                'end_date'         => "{$year}-07-15",
                'is_active'        => false,
                'confederation_id' => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        // UEFA Champions League
        foreach ([2018, 2019, 2020, 2021, 2022, 2023] as $year) {
            $tournaments[] = [
                'name'             => "UEFA Champions League " . $year . "/" . ($year + 1),
                'type'             => 'club',
                'edition_year'     => $year,
                'host_country'     => null,
                'start_date'       => "{$year}-09-01",
                'end_date'         => ($year + 1) . "-05-31",
                'is_active'        => false,
                'confederation_id' => 1,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        // Copa América
        foreach ([2019, 2021, 2024] as $year) {
            $tournaments[] = [
                'name'             => "Copa América {$year}",
                'type'             => 'continental',
                'edition_year'     => $year,
                'host_country'     => $this->faker->country,
                'start_date'       => "{$year}-06-01",
                'end_date'         => "{$year}-07-15",
                'is_active'        => false,
                'confederation_id' => 2,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        // Torneo activo
        $tournaments[] = [
            'name'             => 'FIFA World Cup 2026',
            'type'             => 'world_cup',
            'edition_year'     => 2026,
            'host_country'     => 'USA/Canada/Mexico',
            'start_date'       => '2026-06-11',
            'end_date'         => '2026-07-19',
            'is_active'        => true,
            'confederation_id' => null,
            'created_at'       => now(),
            'updated_at'       => now(),
        ];

        foreach (array_chunk($tournaments, 50) as $chunk) {
            DB::table('tournaments')->insert($chunk);
        }

        $this->command->line('  ✔ Torneos sembrados');
    }

    // ──────────────── EQUIPOS ────────────────
    private function seedTeams(): void
    {
        $countryIds = DB::table('countries')->pluck('id')->toArray();
        $stadiumIds = DB::table('stadiums')->pluck('id')->toArray();

        // Selecciones nacionales (una por país)
        $nationals = [];
        foreach ($countryIds as $cid) {
            $countryName = DB::table('countries')->where('id', $cid)->value('name');
            $nationals[] = [
                'name'            => "Selección de {$countryName}",
                'short_name'      => DB::table('countries')->where('id', $cid)->value('code'),
                'team_type'       => 'national',
                'primary_color'   => $this->faker->hexColor,
                'secondary_color' => $this->faker->hexColor,
                'country_id'      => $cid,
                'stadium_id'      => $this->faker->randomElement($stadiumIds),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }
        DB::table('teams')->insert($nationals);

        // Equipos de club
        $clubNames = [
            'Real', 'FC', 'Atlético', 'Sporting', 'Deportivo',
            'Racing', 'Independiente', 'River', 'Boca', 'Nacional',
        ];
        $citySuffixes = ['City', 'United', 'Athletic', 'Rovers', 'Stars'];

        $clubs = [];
        for ($i = 0; $i < 152; $i++) {
            $clubs[] = [
                'name'            => $this->faker->randomElement($clubNames) . ' ' . $this->faker->city,
                'short_name'      => strtoupper(substr($this->faker->word, 0, 3)),
                'team_type'       => 'club',
                'primary_color'   => $this->faker->hexColor,
                'secondary_color' => $this->faker->hexColor,
                'country_id'      => $this->faker->randomElement($countryIds),
                'stadium_id'      => $this->faker->randomElement($stadiumIds),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        foreach (array_chunk($clubs, 50) as $chunk) {
            DB::table('teams')->insert($chunk);
        }

        $this->command->line('  ✔ Equipos sembrados');
    }

    // ──────────────── JUGADORES (~5,000) ────────────────
    private function seedPlayers(): void
    {
        $teamIds    = DB::table('teams')->pluck('id')->toArray();
        $countryIds = DB::table('countries')->pluck('id')->toArray();
        $positions  = ['goalkeeper', 'defender', 'midfielder', 'forward'];

        $batch = [];
        for ($i = 0; $i < 5000; $i++) {
            $batch[] = [
                'first_name'    => $this->faker->firstName('male'),
                'last_name'     => $this->faker->lastName,
                'birth_date'    => $this->faker->dateTimeBetween('-40 years', '-17 years')->format('Y-m-d'),
                'position'      => $this->faker->randomElement($positions),
                'jersey_number' => $this->faker->numberBetween(1, 99),
                'height_cm'     => $this->faker->randomFloat(1, 165, 200),
                'weight_kg'     => $this->faker->randomFloat(1, 60, 95),
                'is_active'     => $this->faker->boolean(90),
                'country_id'    => $this->faker->randomElement($countryIds),
                'team_id'       => $this->faker->randomElement($teamIds),
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            // Insertar en lotes de 500 para mayor eficiencia
            if (count($batch) === 500) {
                DB::table('players')->insert($batch);
                $batch = [];
            }
        }
        if ($batch) {
            DB::table('players')->insert($batch);
        }

        $this->command->line('  ✔ Jugadores sembrados (5,000)');
    }

    // ──────────────── ÁRBITROS (300) ────────────────
    private function seedReferees(): void
    {
        $countryIds = DB::table('countries')->pluck('id')->toArray();
        $roles      = ['main', 'assistant', 'fourth', 'var'];
        $batch      = [];

        for ($i = 0; $i < 300; $i++) {
            $batch[] = [
                'first_name' => $this->faker->firstName,
                'last_name'  => $this->faker->lastName,
                'birth_date' => $this->faker->dateTimeBetween('-55 years', '-25 years')->format('Y-m-d'),
                'role'       => $this->faker->randomElement($roles),
                'is_active'  => $this->faker->boolean(85),
                'country_id' => $this->faker->randomElement($countryIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('referees')->insert($batch);
        $this->command->line('  ✔ Árbitros sembrados (300)');
    }

    // ──────────────── GRUPOS ────────────────
    private function seedGroups(): void
    {
        $tournamentIds = DB::table('tournaments')->pluck('id')->toArray();
        $groupNames    = ['Grupo A', 'Grupo B', 'Grupo C', 'Grupo D',
                          'Grupo E', 'Grupo F', 'Grupo G', 'Grupo H'];
        $batch = [];

        foreach ($tournamentIds as $tid) {
            foreach ($groupNames as $name) {
                $batch[] = [
                    'name'          => $name,
                    'tournament_id' => $tid,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }
        }

        DB::table('groups')->insert($batch);
        $this->command->line('  ✔ Grupos sembrados');
    }

    // ──────────────── PIVOT GROUP_TEAM ────────────────
    private function seedGroupTeams(): void
    {
        $groups  = DB::table('groups')->get();
        $teamIds = DB::table('teams')->pluck('id')->toArray();
        $batch   = [];
        $used    = []; // evitar duplicados

        foreach ($groups as $group) {
            $selected = $this->faker->randomElements($teamIds, 4);
            foreach ($selected as $teamId) {
                $key = "{$group->id}-{$teamId}";
                if (isset($used[$key])) continue;
                $used[$key] = true;

                $won   = rand(0, 3);
                $drawn = rand(0, 3 - $won);
                $lost  = 3 - $won - $drawn;
                $gf    = rand(0, 10);
                $ga    = rand(0, 10);

                $batch[] = [
                    'group_id'      => $group->id,
                    'team_id'       => $teamId,
                    'played'        => $won + $drawn + $lost,
                    'won'           => $won,
                    'drawn'         => $drawn,
                    'lost'          => $lost,
                    'goals_for'     => $gf,
                    'goals_against' => $ga,
                    'points'        => ($won * 3) + $drawn,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            if (count($batch) >= 500) {
                DB::table('group_team')->insert($batch);
                $batch = [];
            }
        }

        if ($batch) DB::table('group_team')->insert($batch);
        $this->command->line('  ✔ Tabla group_team sembrada');
    }

    // ──────────────── PARTIDOS (~1,200) ────────────────
    private function seedMatches(): void
    {
        $tournaments = DB::table('tournaments')->get();
        $groups      = DB::table('groups')->get()->groupBy('tournament_id');
        $teams       = DB::table('teams')->pluck('id')->toArray();
        $stadiums    = DB::table('stadiums')->pluck('id')->toArray();
        $stages      = ['group_stage', 'round_of_16', 'quarterfinal', 'semifinal', 'third_place', 'final'];
        $statuses    = ['finished', 'finished', 'finished', 'scheduled'];
        $batch       = [];

        foreach ($tournaments as $tournament) {
            $tournamentGroups = $groups[$tournament->id] ?? collect();
            $startYear = $tournament->edition_year;

            // Partidos de fase de grupos (6 por grupo × 8 grupos = 48)
            foreach ($tournamentGroups as $group) {
                for ($i = 0; $i < 6; $i++) {
                    [$home, $away] = $this->faker->randomElements($teams, 2);
                    $batch[] = $this->buildMatch($tournament->id, $group->id, $home, $away,
                        $stadiums, 'group_stage', $startYear, $statuses);
                }
            }

            // Fase eliminatoria (16 + 8 + 4 + 2 + 1 = 31 partidos)
            foreach (['round_of_16', 'quarterfinal', 'semifinal', 'third_place', 'final'] as $stage) {
                $count = match ($stage) {
                    'round_of_16' => 16, 'quarterfinal' => 8,
                    'semifinal' => 4, default => 1,
                };
                for ($i = 0; $i < $count; $i++) {
                    [$home, $away] = $this->faker->randomElements($teams, 2);
                    $batch[] = $this->buildMatch($tournament->id, null, $home, $away,
                        $stadiums, $stage, $startYear, $statuses);
                }
            }

            if (count($batch) >= 500) {
                DB::table('matches')->insert($batch);
                $batch = [];
            }
        }

        if ($batch) DB::table('matches')->insert($batch);
        $this->command->line('  ✔ Partidos sembrados');
    }

    private function buildMatch($tid, $gid, $home, $away, $stadiums, $stage, $year, $statuses): array
    {
        $status     = $this->faker->randomElement($statuses);
        $homeScore  = $status === 'finished' ? rand(0, 5) : null;
        $awayScore  = $status === 'finished' ? rand(0, 5) : null;

        return [
            'tournament_id'          => $tid,
            'group_id'               => $gid,
            'home_team_id'           => $home,
            'away_team_id'           => $away,
            'stadium_id'             => $this->faker->randomElement($stadiums),
            'match_date'             => $this->faker->dateTimeBetween("{$year}-06-01", "{$year}-07-15")->format('Y-m-d H:i:s'),
            'stage'                  => $stage,
            'home_score'             => $homeScore,
            'away_score'             => $awayScore,
            'home_score_extra'       => null,
            'away_score_extra'       => null,
            'home_score_penalties'   => null,
            'away_score_penalties'   => null,
            'status'                 => $status,
            'attendance'             => $this->faker->numberBetween(20000, 90000),
            'created_at'             => now(),
            'updated_at'             => now(),
        ];
    }

    // ──────────────── GOLES (~3,600) ────────────────
    private function seedGoals(): void
    {
        $finishedMatches = DB::table('matches')
            ->where('status', 'finished')
            ->get(['id', 'home_team_id', 'away_team_id', 'home_score', 'away_score']);

        $playerIds = DB::table('players')->pluck('id', 'team_id')->toArray();
        $allPlayers = DB::table('players')->pluck('id')->toArray();
        $types     = ['normal', 'normal', 'normal', 'penalty', 'free_kick', 'own_goal'];
        $batch     = [];

        foreach ($finishedMatches as $match) {
            $total = ($match->home_score ?? 0) + ($match->away_score ?? 0);

            for ($i = 0; $i < $total; $i++) {
                $isHome = $i < $match->home_score;
                $teamId = $isHome ? $match->home_team_id : $match->away_team_id;

                $batch[] = [
                    'match_id'      => $match->id,
                    'player_id'     => $this->faker->randomElement($allPlayers),
                    'team_id'       => $teamId,
                    'minute'        => rand(1, 90),
                    'extra_minute'  => $this->faker->optional(0.1)->numberBetween(1, 10),
                    'type'          => $this->faker->randomElement($types),
                    'is_extra_time' => $this->faker->boolean(5),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            if (count($batch) >= 500) {
                DB::table('goals')->insert($batch);
                $batch = [];
            }
        }

        if ($batch) DB::table('goals')->insert($batch);
        $this->command->line('  ✔ Goles sembrados');
    }

    // ──────────────── TARJETAS (~2,400) ────────────────
    private function seedCards(): void
    {
        $matchIds   = DB::table('matches')->where('status', 'finished')->pluck('id')->toArray();
        $playerIds  = DB::table('players')->pluck('id')->toArray();
        $teamIds    = DB::table('teams')->pluck('id')->toArray();
        $cardTypes  = ['yellow', 'yellow', 'yellow', 'red', 'yellow_red'];
        $batch      = [];

        // ~2 tarjetas por partido terminado
        foreach ($matchIds as $matchId) {
            $count = rand(0, 5);
            for ($i = 0; $i < $count; $i++) {
                $batch[] = [
                    'match_id'   => $matchId,
                    'player_id'  => $this->faker->randomElement($playerIds),
                    'team_id'    => $this->faker->randomElement($teamIds),
                    'minute'     => rand(1, 90),
                    'card_type'  => $this->faker->randomElement($cardTypes),
                    'reason'     => $this->faker->optional(0.5)->sentence(4),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (count($batch) >= 500) {
                DB::table('cards')->insert($batch);
                $batch = [];
            }
        }

        if ($batch) DB::table('cards')->insert($batch);
        $this->command->line('  ✔ Tarjetas sembradas');
    }

    // ──────────────── PIVOT MATCH_REFEREE ────────────────
    private function seedMatchReferees(): void
    {
        $matchIds   = DB::table('matches')->pluck('id')->toArray();
        $refereeIds = DB::table('referees')->pluck('id')->toArray();
        $roles      = ['main', 'assistant', 'assistant', 'fourth', 'var'];
        $batch      = [];
        $used       = [];

        foreach ($matchIds as $matchId) {
            $assignedRoles = $this->faker->randomElements($roles, rand(3, 5));
            $selectedRefs  = $this->faker->randomElements($refereeIds, count($assignedRoles));

            foreach ($selectedRefs as $idx => $refId) {
                $key = "{$matchId}-{$refId}";
                if (isset($used[$key])) continue;
                $used[$key] = true;

                $batch[] = [
                    'match_id'   => $matchId,
                    'referee_id' => $refId,
                    'role'       => $assignedRoles[$idx],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (count($batch) >= 500) {
                DB::table('match_referee')->insert($batch);
                $batch = [];
            }
        }

        if ($batch) DB::table('match_referee')->insert($batch);
        $this->command->line('  ✔ Árbitros de partidos sembrados');
    }
}