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
                    Console.WriteLine("[3] Bekijk resultaten van afgelopen wedstrijden");
                    Console.WriteLine("[4] Sluit applicatie af");

                    string userInput = Console.ReadLine();
                    Console.Clear();

                    switch (userInput)
                    {
                        case "1":
                            if (loggedInUser != null)
                                ViewUserInfo(loggedInUser);
                            break;
                        case "2":
                            BetOnMatch();
                            break;
                        case "3":
                            // code block
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

        static void ViewUserInfo(User user)
        {
            Console.WriteLine("Hier is uw account informatie\n");
            Console.WriteLine($"Gebruikersnaam: {user.Name}");
            Console.WriteLine($"Punten: {user.Points}");

            Console.WriteLine("\n\nDruk op enter om terug te gaan naar het homescherm");
            Console.ReadLine();
            Console.Clear();
        }

        static void BetOnMatch()
        {
            bool invalidChoice = true;
            int pageNum = 1;
            while (invalidChoice)
            {
                Console.WriteLine("Hier is een overzicht van een paar opkomende wedstrijden\n\n");

                // TODO API call to show the first 10 upcoming matches
                Match[] matches = [
                    new Match { Id = 1, Team1Id = 1, Team2Id = 2, MatchDate = new DateTime(2024, 11, 10, 15, 30, 0) },
                    new Match { Id = 2, Team1Id = 3, Team2Id = 4, MatchDate = new DateTime(2024, 10, 5, 18, 0, 0) },
                    new Match { Id = 3, Team1Id = 5, Team2Id = 6, MatchDate = new DateTime(2024, 9, 20, 20, 15, 0) },
                    new Match { Id = 4, Team1Id = 7, Team2Id = 8, MatchDate = new DateTime(2024, 8, 30, 14, 0, 0) },
                    new Match { Id = 5, Team1Id = 2, Team2Id = 3, MatchDate = new DateTime(2024, 8, 15, 16, 0, 0) },
                    new Match { Id = 6, Team1Id = 4, Team2Id = 5, MatchDate = new DateTime(2024, 8, 1, 19, 30, 0) },
                    new Match { Id = 7, Team1Id = 6, Team2Id = 7, MatchDate = new DateTime(2024, 7, 20, 13, 0, 0) },
                    new Match { Id = 8, Team1Id = 8, Team2Id = 1, MatchDate = new DateTime(2024, 7, 5, 17, 45, 0) },
                    new Match { Id = 9, Team1Id = 3, Team2Id = 5, MatchDate = new DateTime(2024, 6, 25, 18, 30, 0) },
                    new Match { Id = 10, Team1Id = 2, Team2Id = 6, MatchDate = new DateTime(2024, 6, 10, 20, 0, 0) },
                    new Match { Id = 11, Team1Id = 4, Team2Id = 8, MatchDate = new DateTime(2024, 5, 30, 15, 0, 0) },
                    new Match { Id = 12, Team1Id = 1, Team2Id = 7, MatchDate = new DateTime(2024, 5, 15, 19, 0, 0) },
                    new Match { Id = 13, Team1Id = 5, Team2Id = 2, MatchDate = new DateTime(2024, 5, 1, 16, 30, 0) },
                    new Match { Id = 14, Team1Id = 6, Team2Id = 3, MatchDate = new DateTime(2024, 4, 20, 18, 0, 0) },
                    new Match { Id = 15, Team1Id = 7, Team2Id = 4, MatchDate = new DateTime(2024, 4, 5, 14, 0, 0) },
                    new Match { Id = 16, Team1Id = 8, Team2Id = 5, MatchDate = new DateTime(2024, 3, 25, 20, 30, 0) },
                    new Match { Id = 17, Team1Id = 1, Team2Id = 6, MatchDate = new DateTime(2024, 3, 10, 17, 0, 0) },
                    new Match { Id = 18, Team1Id = 2, Team2Id = 7, MatchDate = new DateTime(2024, 2, 28, 19, 45, 0) },
                    new Match { Id = 19, Team1Id = 3, Team2Id = 8, MatchDate = new DateTime(2024, 2, 15, 16, 0, 0) },
                    new Match { Id = 20, Team1Id = 4, Team2Id = 1, MatchDate = new DateTime(2024, 2, 1, 18, 30, 0) }
                ];

                // TODO API call to get all teams
                Team[] teams =
                [
                    new Team { Id = 1, Name = "Ajax" },
                    new Team { Id = 2, Name = "PSV" },
                    new Team { Id = 3, Name = "Feyenoord" },
                    new Team { Id = 4, Name = "AZ Alkmaar" },
                    new Team { Id = 5, Name = "FC Utrecht" },
                    new Team { Id = 6, Name = "Vitesse" },
                    new Team { Id = 7, Name = "SC Heerenveen" },
                    new Team { Id = 8, Name = "FC Groningen" }
                ];


                foreach (Match match in matches)
                {
                    string team1Name = "";
                    string team2Name = "";
                    int matchLoopCount = 0;
                    if (matchLoopCount <= pageNum * 10 && match.Id <= pageNum * 10 && match.Id >= pageNum * 10 - 10)
                    {
                        foreach (Team team in teams)
                        {
                            if (match.Team1Id == team.Id)
                            {
                                team1Name = team.Name;
                            }

                            if (match.Team2Id == team.Id)
                            {
                                team2Name = team.Name;
                            }

                        }
                        Console.WriteLine($"[{match.Id}] Team {team1Name} vs Team {team2Name} | Datum van wedstrijd: {match.MatchDate.ToString()}");
                    }
                    matchLoopCount++;
                }

                Console.WriteLine("\nTyp het nummer van de wedstrijd waarvan je meer wilt zien");
                if (pageNum > 1)
                {
                    Console.WriteLine("Typ [T] om de vorige 10 wedstrijden te zien");
                }
                Console.WriteLine("Typ [V] om de volgende 10 wedstrijden te zien");
                Console.WriteLine("Typ [X] om naar het homescherm te gaan");
                string userInput = Console.ReadLine();
                Console.Clear();

                if (userInput.ToUpper() == "X")
                {
                    break;
                }

                if (userInput.ToUpper() == "V")
                {
                    pageNum++;
                }
                else if (userInput.ToUpper() == "T" && pageNum > 1)
                {
                    pageNum--;
                }
                else if (int.TryParse(userInput, out int userMatch))
                {
                    int matchNum = 0;
                    foreach (Match match in matches)
                    {
                        // Match isn't within current page, skip everything.
                        if (match.Id < pageNum * 10)
                        {
                            continue;
                        }

                        // Match is in current page
                        matchNum++;
                        if (match.Id == userMatch)
                        {
                            invalidChoice = false;
                        }
                        // Looped more than there are matches on page
                        else if (matchNum >= 10 * pageNum)
                        {
                            Console.WriteLine("ERROR: Nummer niet binnen pagina opties, probeer het opnieuw");
                            Console.WriteLine("Druk op enter om door te gaan");
                            Console.ReadLine();
                            Console.Clear();
                            break;
                        }
                    }
                }
                else
                {
                    Console.WriteLine("ERROR: Invalide invoer, probeer het opnieuw");
                    Console.WriteLine("Druk op enter om door te gaan");
                    Console.ReadLine();
                    Console.Clear();
                }
            }
        }
    }
}
