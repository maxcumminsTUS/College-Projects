#include <iostream>
#include <string>
#include "CFootballTeam.h"
using namespace std;

CFootballTeam league[5];
int teamCount = 5;

// Function prototypes
void DoInitializeTeamList(void);
void DoDisplayLeague(void);
void DoEnterMatchResult(void);
void DoDeductPoints(void);

int main()
{
    int choice;

    do
    {
        cout << "\nLeague Menu\n";
        cout << "1. Initialize Team List\n";
        cout << "2. Display League Table\n";
        cout << "3. Enter Match Result\n";
        cout << "4. Deduct Points\n";
        cout << "0. Quit\n";
        cout << "Enter choice: ";
        cin >> choice;

        switch (choice)
        {
        case 1: DoInitializeTeamList(); break;
        case 2: DoDisplayLeague(); break;
        case 3: DoEnterMatchResult(); break;
        case 4: DoDeductPoints(); break;
        case 0: cout << "Goodbye!\n"; break;
        default: cout << "Invalid option.\n";
        }

    } while (choice != 0);

    return 0;
}
void DoInitializeTeamList(void)
{
    char choice;

    cout << "Start over? (y/n): ";
    cin >> choice;

    if (choice != 'y' && choice != 'Y')
        return;

    for (int i = 0; i < 5; i++)
    {
        string name;
        int played, gf, ga, pts;

        cout << "\nEnter team " << i + 1 << " name: ";
        cin >> name;

        cout << "Games Played: ";
        cin >> played;

        cout << "Goals For: ";
        cin >> gf;

        cout << "Goals Against: ";
        cin >> ga;

        cout << "Points: ";
        cin >> pts;

        league[i] = CFootballTeam(name, played, gf, ga, pts);
    }
}
void DoDisplayLeague(void)
{
    cout << "\nTeam\tPlayed\tGF\tGA\tPts\n";
    cout << "----------------------------------\n";

    for (int i = 0; i < teamCount; i++)
        league[i].Display();
}
void DoEnterMatchResult(void)
{
    string home, away;
    int homeScore, awayScore;

    cout << "Enter (homeTeam homeScore awayTeam awayScore): ";
    cin >> home >> homeScore >> away >> awayScore;

    for (int i = 0; i < 5; i++)
        if (league[i].HasName(home))
            league[i].UpdateOnResult(homeScore, awayScore);

    for (int i = 0; i < 5; i++)
        if (league[i].HasName(away))
            league[i].UpdateOnResult(awayScore, homeScore);
}
void DoDeductPoints(void)
{
    string name;
    int points;

    cout << "Enter team name: ";
    cin >> name;

    cout << "Points to deduct: ";
    cin >> points;

    for (int i = 0; i < 5; i++)
    {
        if (league[i].HasName(name))
        {
            league[i].DeductPoints(points);
            return;
        }
    }

    cout << "Team not found.\n";
}
