<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create teams
        $teams = [
            \App\Models\Teams::create(['name' => 'Ajax', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'Feyenoord', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'PSV', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'FC Utrecht', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'AZ Alkmaar', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'FC Twente', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'FC Groningen', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'Vitesse', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'Heracles', 'created_by' => $adminUser->id]),
            \App\Models\Teams::create(['name' => 'Sparta Rotterdam', 'created_by' => $adminUser->id]),
        ];

        // Create players for each team
        foreach ($teams as $team) {
            for ($i = 1; $i <= 11; $i++) {
                \App\Models\Players::create([
                    'name' => fake()->name(),
                    'team_id' => $team->id,
                ]);
            }
        }

        // Create past tournament
        $pastTournament = \App\Models\Tournament::create([
            'name' => 'Winter Championship 2024',
            'description' => 'Past tournament that already finished',
            'start_date' => now()->subMonths(2),
            'created_by' => $adminUser->id,
        ]);

        // Create upcoming tournaments
        $upcomingTournament1 = \App\Models\Tournament::create([
            'name' => 'Spring Cup 2025',
            'description' => 'Exciting spring tournament starting soon!',
            'start_date' => now()->addDays(7),
            'created_by' => $adminUser->id,
        ]);

        $upcomingTournament2 = \App\Models\Tournament::create([
            'name' => 'Summer League 2025',
            'description' => 'Summer tournament for all teams',
            'start_date' => now()->addMonths(2),
            'created_by' => $adminUser->id,
        ]);

        $upcomingTournament3 = \App\Models\Tournament::create([
            'name' => 'Autumn Championship 2025',
            'description' => 'Grand autumn championship',
            'start_date' => now()->addMonths(4),
            'created_by' => $adminUser->id,
        ]);

        // Register teams to tournaments
        foreach ($teams as $team) {
            // Past tournament
            \App\Models\TeamsTournaments::create([
                'team_id' => $team->id,
                'tournament_id' => $pastTournament->id,
            ]);

            // Upcoming tournament 1
            \App\Models\TeamsTournaments::create([
                'team_id' => $team->id,
                'tournament_id' => $upcomingTournament1->id,
            ]);
        }

        // Register some teams to tournament 2
        for ($i = 0; $i < 4; $i++) {
            \App\Models\TeamsTournaments::create([
                'team_id' => $teams[$i]->id,
                'tournament_id' => $upcomingTournament2->id,
            ]);
        }

        // Register all teams to tournament 3
        foreach ($teams as $team) {
            \App\Models\TeamsTournaments::create([
                'team_id' => $team->id,
                'tournament_id' => $upcomingTournament3->id,
            ]);
        }

        // Create matches for past tournament (with scores)
        \App\Models\Matches::create([
            'team_1_id' => $teams[0]->id,
            'team_2_id' => $teams[1]->id,
            'tournament_id' => $pastTournament->id,
            'team_1_score' => 3,
            'team_2_score' => 1,
            'match_date' => now()->subMonths(2)->addDays(1),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[2]->id,
            'team_2_id' => $teams[3]->id,
            'tournament_id' => $pastTournament->id,
            'team_1_score' => 2,
            'team_2_score' => 2,
            'match_date' => now()->subMonths(2)->addDays(1),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[4]->id,
            'team_2_id' => $teams[5]->id,
            'tournament_id' => $pastTournament->id,
            'team_1_score' => 1,
            'team_2_score' => 0,
            'match_date' => now()->subMonths(2)->addDays(2),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[6]->id,
            'team_2_id' => $teams[7]->id,
            'tournament_id' => $pastTournament->id,
            'team_1_score' => 4,
            'team_2_score' => 2,
            'match_date' => now()->subMonths(2)->addDays(2),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[8]->id,
            'team_2_id' => $teams[9]->id,
            'tournament_id' => $pastTournament->id,
            'team_1_score' => 0,
            'team_2_score' => 3,
            'match_date' => now()->subMonths(2)->addDays(3),
        ]);

        // Create upcoming matches for tournament 1 (no scores yet)
        \App\Models\Matches::create([
            'team_1_id' => $teams[0]->id,
            'team_2_id' => $teams[2]->id,
            'tournament_id' => $upcomingTournament1->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addDays(8),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[1]->id,
            'team_2_id' => $teams[3]->id,
            'tournament_id' => $upcomingTournament1->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addDays(9),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[4]->id,
            'team_2_id' => $teams[5]->id,
            'tournament_id' => $upcomingTournament1->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addDays(10),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[6]->id,
            'team_2_id' => $teams[7]->id,
            'tournament_id' => $upcomingTournament1->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addDays(11),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[8]->id,
            'team_2_id' => $teams[9]->id,
            'tournament_id' => $upcomingTournament1->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addDays(12),
        ]);

        // Create upcoming matches for tournament 2
        \App\Models\Matches::create([
            'team_1_id' => $teams[0]->id,
            'team_2_id' => $teams[1]->id,
            'tournament_id' => $upcomingTournament2->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(2)->addDays(1),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[2]->id,
            'team_2_id' => $teams[3]->id,
            'tournament_id' => $upcomingTournament2->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(2)->addDays(2),
        ]);

        // Create upcoming matches for tournament 3
        \App\Models\Matches::create([
            'team_1_id' => $teams[0]->id,
            'team_2_id' => $teams[4]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(1),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[1]->id,
            'team_2_id' => $teams[5]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(2),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[2]->id,
            'team_2_id' => $teams[6]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(3),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[3]->id,
            'team_2_id' => $teams[7]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(4),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[8]->id,
            'team_2_id' => $teams[9]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(5),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[0]->id,
            'team_2_id' => $teams[9]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(6),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[1]->id,
            'team_2_id' => $teams[8]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(7),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[2]->id,
            'team_2_id' => $teams[7]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(8),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[3]->id,
            'team_2_id' => $teams[6]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(9),
        ]);

        \App\Models\Matches::create([
            'team_1_id' => $teams[4]->id,
            'team_2_id' => $teams[5]->id,
            'tournament_id' => $upcomingTournament3->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'match_date' => now()->addMonths(4)->addDays(10),
        ]);
    }
}
