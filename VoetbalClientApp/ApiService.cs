using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Net.Http.Json;
using System.Text.Json.Serialization;
using System.Threading.Tasks;

namespace VoetbalClientApp
{
    // Service class that handles all API communication with the Laravel backend
    // Manages HTTP requests with authentication and provides methods for betting operations
    public class ApiService
    {
        private readonly HttpClient _httpClient;
        private readonly string _token;
        private const string API_BASE_URL = "http://schoolvoetbalproject.test/api/";

        // Constructor that initializes the API service with an authentication token
        // Sets up the HttpClient with base URL and authorization headers
        public ApiService(string token)
        {
            _token = token;

            // Create new HttpClient with the API base URL
            _httpClient = new HttpClient
            {
                BaseAddress = new Uri(API_BASE_URL)
            };

            // Add headers to accept JSON responses
            _httpClient.DefaultRequestHeaders.Add("Accept", "application/json");

            // Add authentication token to all requests
            _httpClient.DefaultRequestHeaders.Add("Authorization", $"Bearer {token}");
        }

        // Fetches all upcoming matches from the API
        // Returns list of upcoming matches, or empty list if request fails
        public async Task<List<Match>> GetUpcomingMatchesAsync()
        {
            try
            {
                // Send GET request to fetch upcoming matches
                var response = await _httpClient.GetAsync("matches/upcoming/list");

                // Throw exception if response status is not successful
                response.EnsureSuccessStatusCode();

                // Deserialize JSON response to List of Match objects
                var matches = await response.Content.ReadFromJsonAsync<List<Match>>();

                // Return matches or empty list if null
                return matches ?? new List<Match>();
            }
            catch (Exception ex)
            {
                // Log error to console if request fails
                Console.WriteLine($"Error fetching matches: {ex.Message}");
                return new List<Match>();
            }
        }

        // Fetches all teams from the API
        // Returns list of teams, or empty list if request fails
        public async Task<List<Team>> GetTeamsAsync()
        {
            try
            {
                // Send GET request to fetch all teams
                var response = await _httpClient.GetAsync("teams");

                // Throw exception if response is not successful
                response.EnsureSuccessStatusCode();

                // Deserialize JSON response to List of Team objects
                var teams = await response.Content.ReadFromJsonAsync<List<Team>>();

                // If teams is null return empty list
                // otherwise return the teams
                if (teams == null)
                {
                    return new List<Team>();
                }
                else
                {
                    return teams;
                }
            }
            // Error handling
            catch (Exception ex)
            {
                Console.WriteLine($"Error fetching teams: {ex.Message}");
                return new List<Team>();
            }
        }

        // Fetches matches that are available for betting
        // Only returns matches that haven't been played yet and includes info about existing bets
        // Returns response containing available matches and current user points, or null if request fails
        public async Task<AvailableMatchesResponse?> GetAvailableMatchesForBettingAsync()
        {
            try
            {
                // Send GET request to fetch matches available for betting
                var response = await _httpClient.GetAsync("matches/available-for-betting");

                // Throw exception if response is not successful
                response.EnsureSuccessStatusCode();

                // Deserialize JSON response to AvailableMatchesResponse object
                return await response.Content.ReadFromJsonAsync<AvailableMatchesResponse>();
            }
            catch (Exception ex)
            {
                // Log error to console if request fails
                Console.WriteLine($"Error fetching available matches: {ex.Message}");
                return null;
            }
        }

        // Places a new bet on a match
        // Deducts bet amount from user's points immediately
        // Returns response with bet details and remaining points, or null if request fails
        public async Task<PlaceBetResponse?> PlaceBetAsync(PlaceBetRequest betRequest)
        {
            try
            {
                // Send POST request with bet data as JSON
                var response = await _httpClient.PostAsJsonAsync("bets", betRequest);

                // Throw exception if response is not successful
                response.EnsureSuccessStatusCode();

                // Deserialize JSON response to PlaceBetResponse object
                return await response.Content.ReadFromJsonAsync<PlaceBetResponse>();
            }
            catch (Exception ex)
            {
                // Log error to console if request fails
                Console.WriteLine($"Error placing bet: {ex.Message}");
                return null;
            }
        }

        // Fetches all bets placed by the current user
        // Includes bet details, match info, and settlement status
        // Returns response with list of user's bets and current points, or null if request fails
        public async Task<BetsListResponse?> GetUserBetsAsync()
        {
            try
            {
                // Send GET request to fetch user's bets
                var response = await _httpClient.GetAsync("bets");

                // Throw exception if response is not successful
                response.EnsureSuccessStatusCode();

                // Deserialize JSON response to BetsListResponse object
                return await response.Content.ReadFromJsonAsync<BetsListResponse>();
            }
            // Error handling
            catch (Exception ex)
            {
                Console.WriteLine($"Error fetching user bets: {ex.Message}");
                return null;
            }
        }

        // Fetches the current authenticated user's information
        // Includes name, email, and current points balance
        // Returns User object with current data, or null if request fails
        public async Task<User?> GetCurrentUserAsync()
        {
            try
            {
                // Send GET request to fetch current user info
                var response = await _httpClient.GetAsync("user");

                // Throw exception if response is not successful
                response.EnsureSuccessStatusCode();

                // Deserialize JSON response to User object
                return await response.Content.ReadFromJsonAsync<User>();
            }
            // Error handling
            catch (Exception ex)
            {
                Console.WriteLine($"Error fetching current user: {ex.Message}");
                return null;
            }
        }
    }
}
