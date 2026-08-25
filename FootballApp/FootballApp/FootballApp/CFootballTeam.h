#ifndef CFOOTBALLTEAM_H
#define CFOOTBALLTEAM_H

#include <string>
using namespace std;

class CFootballTeam
{
private:
    string m_Name;
    int m_GamesPlayed;
    int m_GoalsFor;
    int m_GoalsAgainst;
    int m_Points;

public:
    CFootballTeam();
    CFootballTeam(string name);
    CFootballTeam(string name, int gamesPlayed, int goalsFor, int goalsAgainst, int points);

    string GetName(void);
    int GetGamesPlayed(void);
    int GetGoalsFor(void);
    int GetGoalsAgainst(void);
    int GetPoints(void);

    bool HasName(string searchName);

    void Display(void);
    void UpdateOnResult(int goalsFor, int goalsAgainst);
    void DeductPoints(int num);
};

#endif

