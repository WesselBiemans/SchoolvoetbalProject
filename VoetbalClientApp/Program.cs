using System.ComponentModel;
using System.Linq.Expressions;

namespace VoetbalClientApp
{
    internal class Program
    {
        static async Task Main(string[] args)
        {
            bool isRunning = true;

            // User info after login
            User? loggedInUser = null;
            string? authToken = null;

            Console.WriteLine("Welkom bij de Schoolsport voetbal weddenschap applicatie!\n\n");
            while (isRunning)
            {
                bool notLoggedIn = true;
                while (notLoggedIn)
                {
                    Console.WriteLine("Voer uw email in:");
                    string email = Console.ReadLine();
                    Console.Clear();

                    Console.WriteLine("Voer uw wachtwoord in:");
                    string password = Console.ReadLine();
                    Console.Clear();

                    // API check
                    try
                    {
                        var auth = new AuthService();
                        var result = await auth.LoginAsync(email, password);

                        Console.WriteLine($"Welkom, {result.User.Name}!");
                        loggedInUser = result.User;
                        authToken = result.Token;
                        notLoggedIn = false;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine($"Login mislukt: {ex.Message}");
                        Console.WriteLine("Uw gebruikersnaam en/of wachtwoord is onjuist, probeer het opnieuw.\n");
                    }
                }

                bool inHomeMenu = true;
                while (inHomeMenu)
                {
                    Console.WriteLine("Typ uw keuze\n");
                    Console.WriteLine("[1] Bekijk uw account informatie");
                    Console.WriteLine("[2] Kies een wedstrijd om op te wedden");
                    Console.WriteLine("[3] Bekijk uw wedstrijden");
                    Console.WriteLine("[4] Sluit applicatie af");

                    string userInput = Console.ReadLine();
                    Console.Clear();

                    switch (userInput)
                    {
                        case "1":
                            if (loggedInUser != null && authToken != null)
                                await ViewUserInfo(loggedInUser, authToken);
                            break;
                        case "2":
                            if (authToken != null)
                            {
                                await BetOnMatch(authToken);
                                // Refresh user data after betting
                                var apiService = new ApiService(authToken);
                                loggedInUser = await apiService.GetCurrentUserAsync();
                            }
                            break;
                        case "3":
                            if (authToken != null)
                                await ViewUserBets(authToken);
                            break;
                        case "4":
                            inHomeMenu = false;
                            isRunning = false;
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        static async Task ViewUserInfo(User user, string token)
        {
            var apiService = new ApiService(token);
            var currentUser = await apiService.GetCurrentUserAsync();

            if (currentUser != null)
            {
                Console.WriteLine("Hier is uw account informatie\n");
                Console.WriteLine($"Gebruikersnaam: {currentUser.Name}");
                Console.WriteLine($"Email: {currentUser.Email}");
                Console.WriteLine($"Punten: {currentUser.Points}");
            }
            else
            {
                Console.WriteLine("Kon account informatie niet ophalen.");
            }

            Console.WriteLine("\n\nDruk op enter om terug te gaan naar het homescherm");
            Console.ReadLine();
            Console.Clear();
        }

        static async Task ViewUserBets(string token)
        {
            var apiService = new ApiService(token);
            var betsResponse = await apiService.GetUserBetsAsync();

            if (betsResponse == null)
            {
                Console.WriteLine("Kon wedstrijden niet ophalen.");
                Console.WriteLine("Druk op enter om terug te gaan");
                Console.ReadLine();
                Console.Clear();
                return;
            }

            Console.WriteLine($"Uw huidige punten: {betsResponse.CurrentPoints}\n");
            Console.WriteLine("Uw wedstrijden:\n");

            if (betsResponse.Bets.Count == 0)
            {
                Console.WriteLine("U heeft nog geen wedstrijden geplaatst.");
            }
            else
            {
                foreach (var bet in betsResponse.Bets)
                {
                    string predictionText = bet.PredictedWinner switch
                    {
                        0 => "Gelijkspel",
                        1 => bet.Match?.Team1?.Name ?? "Team 1",
                        2 => bet.Match?.Team2?.Name ?? "Team 2",
                        _ => "Onbekend"
                    };

                    Console.WriteLine($"Match: {bet.Match?.Team1?.Name} vs {bet.Match?.Team2?.Name}");
                    Console.WriteLine($"  Inzet: {bet.BetAmount} punten");
                    Console.WriteLine($"  Voorspelling: {predictionText} wint");
                    Console.WriteLine($"  Status: {(bet.IsSettled ? $"Afgerekend - Uitbetaling: {bet.Payout}" : "Nog niet afgerekend")}");
                    Console.WriteLine();
                }
            }

            Console.WriteLine("\nDruk op enter om terug te gaan naar het homescherm");
            Console.ReadLine();
            Console.Clear();
        }

        static async Task BetOnMatch(string token)
        {
            var apiService = new ApiService(token);

            Console.WriteLine("Ophalen van beschikbare wedstrijden...");
            var matchesResponse = await apiService.GetAvailableMatchesForBettingAsync();

            if (matchesResponse == null || matchesResponse.Matches.Count == 0)
            {
                Console.WriteLine("Geen wedstrijden beschikbaar om op te wedden.");
                Console.WriteLine("Druk op enter om terug te gaan");
                Console.ReadLine();
                Console.Clear();
                return;
            }

            var matches = matchesResponse.Matches.ToArray();
            int matchesPerPage = 10;
            int totalPages = (int)Math.Ceiling((double)matches.Length / matchesPerPage);
            int pageNum = 1;
            bool invalidChoice = true;

            while (invalidChoice)
            {
                Console.Clear();
                Console.WriteLine($"Uw huidige punten: {matchesResponse.CurrentPoints}\n");
                Console.WriteLine("Hier is een overzicht van een paar opkomende wedstrijden\n\n");

                for (int i = (pageNum - 1) * matchesPerPage; i < Math.Min(pageNum * matchesPerPage, matches.Length); i++)
                {
                    var match = matches[i];
                    string betStatus = match.UserHasBet ? " (U heeft al gegokt op deze wedstrijd)" : "";
                    Console.WriteLine($"[{match.Id}] {match.Team1?.Name} vs {match.Team2?.Name} | Datum: {match.MatchDate}{betStatus}");
                }

                Console.WriteLine("\nTyp het nummer van de wedstrijd waarop u wilt wedden");
                if (pageNum > 1)
                {
                    Console.WriteLine("Typ [T] om de vorige 10 wedstrijden te zien");
                }
                if (pageNum < totalPages)
                {
                    Console.WriteLine("Typ [V] om de volgende 10 wedstrijden te zien");
                }
                Console.WriteLine("Typ [X] om naar het homescherm te gaan");

                string userInput = Console.ReadLine();
                Console.Clear();

                if (userInput?.ToUpper() == "X")
                {
                    break;
                }

                if (userInput?.ToUpper() == "V" && pageNum < totalPages)
                {
                    pageNum++;
                }
                else if (userInput?.ToUpper() == "T" && pageNum > 1)
                {
                    pageNum--;
                }
                else if (int.TryParse(userInput, out int matchId))
                {
                    // Find the match by ID
                    var selectedMatch = matches.FirstOrDefault(m => m.Id == matchId);

                    if (selectedMatch == null)
                    {
                        Console.WriteLine("ERROR: Wedstrijd niet gevonden, probeer het opnieuw");
                        Console.WriteLine("Druk op enter om door te gaan");
                        Console.ReadLine();
                        continue;
                    }

                    // Check if match is on current page
                    int matchIndex = Array.IndexOf(matches, selectedMatch);
                    if (matchIndex < (pageNum - 1) * matchesPerPage || matchIndex >= pageNum * matchesPerPage)
                    {
                        Console.WriteLine("ERROR: Nummer niet binnen pagina opties, probeer het opnieuw");
                        Console.WriteLine("Druk op enter om door te gaan");
                        Console.ReadLine();
                        continue;
                    }

                    if (selectedMatch.UserHasBet)
                    {
                        Console.WriteLine("U heeft al een wedstrijd geplaatst op deze match.");
                        Console.WriteLine("Druk op enter om terug te gaan");
                        Console.ReadLine();
                        continue;
                    }

                    Console.WriteLine($"Wedstrijd: {selectedMatch.Team1?.Name} vs {selectedMatch.Team2?.Name}\n");
                    Console.WriteLine("Op wie wilt u wedden?");
                    Console.WriteLine($"[1] {selectedMatch.Team1?.Name} wint");
                    Console.WriteLine($"[2] {selectedMatch.Team2?.Name} wint");
                    Console.WriteLine("[0] Gelijkspel");

                    string predictionInput = Console.ReadLine();

                    if (!int.TryParse(predictionInput, out int prediction) || prediction < 0 || prediction > 2)
                    {
                        Console.WriteLine("Ongeldige keuze.");
                        Console.WriteLine("Druk op enter om terug te gaan");
                        Console.ReadLine();
                        Console.Clear();
                        continue;
                    }

                    Console.WriteLine($"\nHoeveel punten wilt u inzetten? (Beschikbaar: {matchesResponse.CurrentPoints})");
                    string betAmountInput = Console.ReadLine();

                    if (!int.TryParse(betAmountInput, out int betAmount) || betAmount <= 0)
                    {
                        Console.WriteLine("Ongeldig bedrag.");
                        Console.WriteLine("Druk op enter om terug te gaan");
                        Console.ReadLine();
                        Console.Clear();
                        continue;
                    }

                    if (betAmount > matchesResponse.CurrentPoints)
                    {
                        Console.WriteLine("U heeft niet genoeg punten.");
                        Console.WriteLine("Druk op enter om terug te gaan");
                        Console.ReadLine();
                        Console.Clear();
                        continue;
                    }

                    var betRequest = new PlaceBetRequest
                    {
                        MatchId = selectedMatch.Id,
                        BetAmount = betAmount,
                        PredictedWinner = prediction
                    };

                    var result = await apiService.PlaceBetAsync(betRequest);

                    if (result != null)
                    {
                        Console.WriteLine($"\n{result.Message}");
                        Console.WriteLine($"Resterende punten: {result.RemainingPoints}");
                        invalidChoice = false;
                    }
                    else
                    {
                        Console.WriteLine("\nKon wedstrijd niet plaatsen.");
                    }

                    Console.WriteLine("\nDruk op enter om terug te gaan");
                    Console.ReadLine();
                    Console.Clear();
                }
                else
                {
                    Console.WriteLine("ERROR: Invalide invoer, probeer het opnieuw");
                    Console.WriteLine("Druk op enter om door te gaan");
                    Console.ReadLine();
                }
            }
        }
    }
}
