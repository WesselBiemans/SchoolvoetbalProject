using System;
using System.Text.Json.Serialization;

namespace VoetbalClientApp
{
    public class Bet
    {
        [JsonPropertyName("id")]
        public int Id { get; set; }

        [JsonPropertyName("user_id")]
        public int UserId { get; set; }

        [JsonPropertyName("match_id")]
        public int MatchId { get; set; }

        [JsonPropertyName("bet_amount")]
        public int BetAmount { get; set; }

        [JsonPropertyName("predicted_winner")]
        // 0=draw, 1=team_1, 2=team_2
        public int PredictedWinner { get; set; }

        [JsonPropertyName("is_settled")]
        public bool IsSettled { get; set; }

        [JsonPropertyName("payout")]
        public int? Payout { get; set; }

        [JsonPropertyName("created_at")]
        public DateTime CreatedAt { get; set; }

        [JsonPropertyName("match")]
        public Match? Match { get; set; }
    }

    public class PlaceBetRequest
    {
        [JsonPropertyName("match_id")]
        public int MatchId { get; set; }

        [JsonPropertyName("bet_amount")]
        public int BetAmount { get; set; }

        [JsonPropertyName("predicted_winner")]
        public int PredictedWinner { get; set; }
    }

    public class PlaceBetResponse
    {
        [JsonPropertyName("message")]
        public string Message { get; set; } = string.Empty;

        [JsonPropertyName("bet")]
        public Bet? Bet { get; set; }

        [JsonPropertyName("remaining_points")]
        public int RemainingPoints { get; set; }
    }

    public class BetsListResponse
    {
        [JsonPropertyName("bets")]
        public List<Bet> Bets { get; set; } = new();

        [JsonPropertyName("current_points")]
        public int CurrentPoints { get; set; }
    }

    public class AvailableMatchesResponse
    {
        [JsonPropertyName("matches")]
        public List<Match> Matches { get; set; } = new();

        [JsonPropertyName("current_points")]
        public int CurrentPoints { get; set; }
    }
}
