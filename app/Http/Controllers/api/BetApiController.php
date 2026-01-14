<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\Matches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BetApiController extends Controller
{
    /**
     * Place a bet on a match.
     */
    public function placeBet(Request $request)
    {
        $request->validate([
            'match_id' => 'required|exists:matches,id',

            // User's bet
            'bet_amount' => 'required|integer|min:1',

            // User's prediction
            // 0=draw, 1=team_1, 2=team_2
            'predicted_winner' => 'required|integer|in:0,1,2',
        ]);

        $user = Auth::user();
        $match = Matches::findOrFail($request->match_id);

        // Check if match has already started (match_date is in the past)
        if ($match->match_date <= now()) {
            return response()->json([
                'message' => 'Kan niet wedden op een wedstrijd die al is begonnen of afgelopen.',
            ], 400);
        }

        // Check if match has already been played
        if ($match->is_played) {
            return response()->json([
                'message' => 'Kan niet wedden op een wedstrijd die al is gespeeld.',
            ], 400);
        }

        // Check if user has enough points
        if ($user->points < $request->bet_amount) {
            return response()->json([
                'message' => 'Onvoldoende punten. U heeft ' . $user->points . ' punten.',
            ], 400);
        }

        // Check if user already has a bet on this match
        $existingBet = Bet::where('user_id', $user->id)
            ->where('match_id', $request->match_id)
            ->first();

        if ($existingBet) {
            return response()->json([
                'message' => 'U heeft al een weddenschap geplaatst op deze wedstrijd.',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Create the bet
            $bet = Bet::create([
                'user_id' => $user->id,
                'match_id' => $request->match_id,
                'bet_amount' => $request->bet_amount,
                'predicted_winner' => $request->predicted_winner,
            ]);

            // Deduct points from user
            $user->points -= $request->bet_amount;
            $user->save();

            DB::commit();

            return response()->json([
                'message' => 'Weddenschap succesvol geplaatst!',
                'bet' => $bet->load('match.team1', 'match.team2'),
                'remaining_points' => $user->points,
            ], 201);

        // Error handling
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Kan weddenschap niet plaatsen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all bets for the authenticated user.
     */
    public function getUserBets(Request $request)
    {
        $user = Auth::user();

        $bets = Bet::where('user_id', $user->id)
            ->with(['match.team1', 'match.team2', 'match.tournament'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'bets' => $bets,
            'current_points' => $user->points,
        ]);
    }

    /**
     * Get all bets for a specific match.
     */
    public function getMatchBets($matchId)
    {
        $user = Auth::user();

        $bet = Bet::where('user_id', $user->id)
            ->where('match_id', $matchId)
            ->with(['match.team1', 'match.team2'])
            ->first();

        return response()->json([
            'bet' => $bet,
        ]);
    }

    /**
     * Get matches available for betting (upcoming matches without bets).
     */
    public function getAvailableMatches()
    {
        $user = Auth::user();

        // Get matches that are in the future and haven't been played yet
        $matches = Matches::where('match_date', '>', now())
            ->where('is_played', false)
            ->with(['team1', 'team2', 'tournament'])
            ->orderBy('match_date', 'asc')
            ->get();

        // Get user's existing bets
        $userBetMatchIds = Bet::where('user_id', $user->id)
            ->pluck('match_id')
            ->toArray();

        // Mark matches that user has already bet on
        $matches->each(function ($match) use ($userBetMatchIds) {
            $match->user_has_bet = in_array($match->id, $userBetMatchIds);
        });

        return response()->json([
            'matches' => $matches,
            'current_points' => $user->points,
        ]);
    }

    /**
     * Settle all unsettled bets for matches that have been played.
     * This should be called when match results are updated by referee.
     */
    public function settleBets($matchId)
    {
        $match = Matches::findOrFail($matchId);

        // Get all unsettled bets for this match
        $bets = Bet::where('match_id', $matchId)
            ->where('is_settled', false)
            ->get();

        DB::beginTransaction();
        try {
            foreach ($bets as $bet) {
                // Determine actual winner

                // Draw (default)
                $actualWinner = 0;

                if ($match->team_1_score > $match->team_2_score) {
                    // team 1 wins
                    $actualWinner = 1;
                } elseif ($match->team_2_score > $match->team_1_score) {
                    // team 2 wins
                    $actualWinner = 2;
                }

                // Check if prediction is correct
                $isCorrect = ($bet->predicted_winner == $actualWinner);

                if ($isCorrect) {
                    // User wins double the bet amount
                    $payout = $bet->bet_amount * 2;
                    $bet->payout = $payout;

                    // Add payout to user's points
                    $user = \App\Models\User::find($bet->user_id);
                    $user->points += $payout;
                    $user->save();
                } else {
                    // User loses, no payout
                    $bet->payout = 0;
                }

                $bet->is_settled = true;
                $bet->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Weddenschappen succesvol afgerekend!',
                'settled_count' => $bets->count(),
            ]);

        // Error handling
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Kan weddenschappen niet afrekenen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Settle ALL unsettled bets for matches that have finished.
     * Used mostly for debugging when matches need to be quickly settled
     */
    public function settleAllBets()
    {
        // Find all matches that have passed and have results but unsettled bets
        $matchesWithUnsettledBets = Bet::where('is_settled', false)
            ->with('match')
            ->get()
            ->pluck('match')
            ->unique('id')
            ->filter(function ($match) {
                return $match->match_date <= now();
            });

        $totalSettled = 0;

        foreach ($matchesWithUnsettledBets as $match) {
            $bets = Bet::where('match_id', $match->id)
                ->where('is_settled', false)
                ->get();

            DB::beginTransaction();
            try {
                foreach ($bets as $bet) {
                    // Determine actual winner
                    $actualWinner = 0; // draw
                    if ($match->team_1_score > $match->team_2_score) {
                        $actualWinner = 1; // team 1 wins
                    } elseif ($match->team_2_score > $match->team_1_score) {
                        $actualWinner = 2; // team 2 wins
                    }

                    // Check if prediction is correct
                    $isCorrect = ($bet->predicted_winner == $actualWinner);

                    if ($isCorrect) {
                        // User wins double the bet amount
                        $payout = $bet->bet_amount * 2;
                        $bet->payout = $payout;

                        // Add payout to user's points
                        $user = \App\Models\User::find($bet->user_id);
                        $user->points += $payout;
                        $user->save();
                    } else {
                        // User loses, no payout
                        $bet->payout = 0;
                    }

                    $bet->is_settled = true;
                    $bet->save();
                    $totalSettled++;
                }

                DB::commit();

            // Error handling
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Failed to settle bets for match ' . $match->id . ': ' . $e->getMessage());
            }
        }

        return response()->json([
            'message' => 'Alle weddenschappen afgerekend!',
            'settled_count' => $totalSettled,
            'matches_processed' => $matchesWithUnsettledBets->count(),
        ]);
    }
}
