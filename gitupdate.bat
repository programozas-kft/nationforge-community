@echo off

cd /d "%~dp0"

chcp 65001 >nul
color 0B
title NationForge - Git Update

echo ================================================
echo    NATIONFORGE - GIT FRISSÍTÉS
echo    github.com/programozas-kft/nationforge
echo ================================================
echo.

if not exist .git (
    echo [HIBA] Nem találom a .git mappát!
    echo Másold ezt a fájlt a projekt gyökerébe!
    pause
    exit
)

echo [0/3] Jogosultság beállítása...
call git config --global --add safe.directory C:/xampp/htdocs/nationforge
echo.

echo [1/3] Távoli változások letöltése (Pull)...
call git pull origin main --no-rebase --no-edit
if %errorlevel% neq 0 (
    echo [INFO] Nincs letöltendő változás vagy a szerver nem érhető el.
)
echo.

echo [2/3] Összes változás hozzáadása (Add)...
call git add -A
echo.

echo Jelenlegi állapot:
echo ------------------------------------------------
call git status --short
echo ------------------------------------------------
echo.

echo [3/3] Mentés és Feltöltés (Commit ^& Push)...
call git commit -m "NationForge Frissites - Automatikus mentes"
call git push origin main

if %errorlevel% equ 0 (
    echo.
    echo ================================================
    echo    SIKERES FELTÖLTÉS!
    echo    github.com/programozas-kft/nationforge
    echo ================================================
) else (
    echo.
    echo [!] HIBA történt a feltöltés során.
    echo Ellenőrizd az internetet vagy a GitHub jogosultságokat.
)

echo.
echo A folyamat véget ért.
pause