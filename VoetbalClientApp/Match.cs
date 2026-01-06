using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.Json.Serialization;
using System.Threading.Tasks;

namespace VoetbalClientApp
{
    public class Match
    {
        [JsonPropertyName("id")]
        public int Id { get; set; }

        [JsonPropertyName("team_1_id")]
        public int Team1Id { get; set; }

        [JsonPropertyName("team_2_id")]
        public int Team2Id { get; set; }

        [JsonPropertyName("team_1_score")]
        public int? Team1Score { get; set; }

        [JsonPropertyName("team_2_score")]
        public int? Team2Score { get; set; }

        [JsonPropertyName("match_date")]
        public string MatchDate { get; set; } = string.Empty;

        [JsonPropertyName("tournament_id")]
        public int TournamentId { get; set; }

        [JsonPropertyName("team1")]
        public Team? Team1 { get; set; }

        [JsonPropertyName("team2")]
        public Team? Team2 { get; set; }

        [JsonPropertyName("user_has_bet")]
        public bool UserHasBet { get; set; }

        // Helper property to get DateTime from string
        public DateTime MatchDateTime => DateTime.Parse(MatchDate);
    }
}
