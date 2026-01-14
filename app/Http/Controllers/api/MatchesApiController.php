<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\Bet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchesApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Matches::all());
    }

    public function upcoming(): JsonResponse
    {
        return response()->json(
            Matches::where('match_date', '>', now())
                ->orderBy('match_date', 'asc')
                ->get()
        );
    }

    public function show(Matches $Matches): JsonResponse
    {
        return response()->json($Matches);
    }

    public function store(Request $request): JsonResponse
    {
        $Matches = Matches::create($request->all());

        return response()->json($Matches, 201);
    }

    public function update(Request $request, Matches $Matches): JsonResponse
    {
        $wasPlayed = $Matches->is_played;

        $Matches->update($request->all());
        $Matches->refresh();

        // Check if match was just marked as played
        $justMarkedAsPlayed = (!$wasPlayed && $Matches->is_played);

        // Settle bets if match was just marked as played
        if ($justMarkedAsPlayed) {
            $this->settleBetsForMatch($Matches->id);
        }

        return response()->json($Matches);
    }

    /**
     * Settle all unsettled bets for a match
     */
    private function settleBetsForMatch($matchId): void
    {
        $match = Matches::findOrFail($matchId);

        // Get all unsettled bets for this match
        $bets = Bet::where('match_id', $matchId)
            ->where('is_settled', false)
            ->get();

        if ($bets->isEmpty()) {
            return;
        }

        DB::beginTransaction();
        try {
            foreach ($bets as $bet) {
                // Determine actual winner

                // draw (default)
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
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to settle bets for match ' . $matchId . ': ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    public function destroy(Matches $Matches): JsonResponse
    {
        $Matches->delete();

        return response()->json(null, 204);
    }
}
