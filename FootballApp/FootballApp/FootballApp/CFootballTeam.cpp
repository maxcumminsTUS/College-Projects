#include <iostream>
#include "CFootballTeam.h"
using namespace std;

// DEFAULT CONSTRUCTOR
CFootballTeam::CFootballTeam()
{
    m_Name = "";
    m_GamesPlayed = 0;
    m_GoalsFor = 0;
    m_GoalsAgainst = 0;
    m_Points = 0;
}

// NEW TEAM CONSTRUCTOR
CFootballTeam::CFootballTeam(string name)
{
    m_Name = name;
    m_GamesPlayed = 0;
    m_GoalsFor = 0;
    m_GoalsAgainst = 0;
    m_Points = 0;
}

// DATABASE CONSTRUCTOR
CFootballTeam::CFootballTeam(string name, int gamesPlayed, int goalsFor, int goalsAgainst, int points)
{
    m_Name = name;
    m_GamesPlayed = gamesPlayed;
    m_GoalsFor = goalsFor;
    m_GoalsAgainst = goalsAgainst;
    m_Points = points;
}

// ACCESSORS
string CFootballTeam::GetName(void) { return m_Name; }
int CFootballTeam::GetGamesPlayed(void) { return m_GamesPlayed; }
int CFootballTeam::GetGoalsFor(void) { return m_GoalsFor; }
int CFootballTeam::GetGoalsAgainst(void) { return m_GoalsAgainst; }
int CFootballTeam::GetPoints(void) { return m_Points; }

// NAME CHECK
bool CFootballTeam::HasName(string searchName)
{
    return (m_Name == searchName);
}

// DISPLAY TEAM DETAILS
void CFootballTeam::Display(void)
{
    cout << m_Name << "\t"
        << m_GamesPlayed << "\t"
        << m_GoalsFor << "\t"
        << m_GoalsAgainst << "\t"
        << m_Points << endl;
}
// UPDATE MATCH RESULT
void CFootballTeam::UpdateOnResult(int goalsFor, int goalsAgainst)
{
    m_GamesPlayed++;
    m_GoalsFor += goalsFor;
    m_GoalsAgainst += goalsAgainst;

    if (goalsFor > goalsAgainst)
        m_Points += 3;    // win
    else if (goalsFor == goalsAgainst)
        m_Points += 1;    // draw
    // else: loss gives 0 points
}

// DEDUCT POINTS
void CFootballTeam::DeductPoints(int num)
{
    m_Points -= num;
    if (m_Points < 0)
        m_Points = 0;
}
