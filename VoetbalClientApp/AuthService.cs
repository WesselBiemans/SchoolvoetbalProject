using System;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Net.Http.Json;
using System.Text.Json;
using System.Threading.Tasks;

namespace VoetbalClientApp
{
    public class AuthService
    {
        private readonly HttpClient _httpClient;

        // URL where API can be found
        private const string API_BASE_URL = "http://schoolvoetbalproject.test/api/";

        public string? CurrentToken { get; private set; }
        public User? CurrentUser { get; private set; }

        public AuthService()
        {
            _httpClient = new HttpClient
            {
                BaseAddress = new Uri(API_BASE_URL)
            };

            // Tell Laravel this is an API request
            _httpClient.DefaultRequestHeaders.Accept.Clear();
            _httpClient.DefaultRequestHeaders.Accept.Add(
                new MediaTypeWithQualityHeaderValue("application/json"));
            _httpClient.DefaultRequestHeaders.Add("X-Requested-With", "XMLHttpRequest");
        }

        // Function for logging user in
        public async Task<LoginResponse> LoginAsync(string email, string password, string deviceName = "WinUI App")
        {
            var loginData = new
            {
                email = email,
                password = password,
                device_name = deviceName
            };

            var response = await _httpClient.PostAsJsonAsync("login", loginData);

            // Login fail
            if (!response.IsSuccessStatusCode)
            {
                var error = await response.Content.ReadAsStringAsync();
                throw new Exception($"Login failed (Status {response.StatusCode}): {error}");
            }

            var loginResponse = await response.Content.ReadFromJsonAsync<LoginResponse>();

            if (loginResponse != null)
            {
                // Store the token and user
                CurrentToken = loginResponse.Token;
                CurrentUser = loginResponse.User;

                // Set authorization header for future requests
                _httpClient.DefaultRequestHeaders.Authorization =
                    new AuthenticationHeaderValue("Bearer", CurrentToken);

                return loginResponse; // Ensure a value is returned here
            }

            throw new Exception("Login failed: Unexpected null response from the server."); // Handle null case explicitly
        }

        /// <summary>
        /// Get the currently authenticated user
        /// </summary>
        public async Task<User?> GetCurrentUserAsync()
        {
            if (string.IsNullOrEmpty(CurrentToken))
                return null;

            var response = await _httpClient.GetAsync("/user");

            if (!response.IsSuccessStatusCode)
                return null;

            CurrentUser = await response.Content.ReadFromJsonAsync<User>();
            return CurrentUser;
        }

        /// <summary>
        /// Check if user is authenticated
        /// </summary>
        public bool IsAuthenticated => !string.IsNullOrEmpty(CurrentToken);
    }

    // Response models
    public class LoginResponse
    {
        public User User { get; set; } = null!;
        public string Token { get; set; } = null!;
    }
}
