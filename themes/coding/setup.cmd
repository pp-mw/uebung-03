@echo off
title Setup

:menu
cls
echo;
echo;
echo      [E]inrichtung
echo;
echo      [S]tarten
echo;
echo      [O]ptionen
echo;
echo      [B]eenden
echo;
echo;

choice /n /c "esob" /m "Auswahl treffen (E/S/O/B)?"
if errorlevel 4 goto end
if errorlevel 3 goto special
if errorlevel 2 goto start
if errorlevel 1 goto init

:init
choice /n /m "Einrichtung starten (J/N)?"
if errorlevel 2 goto end
if errorlevel 1 goto inityes

:inityes
if exist node_modules (
echo Ordner node_modules wird entfernt...
mkdir empty_dir
robocopy empty_dir node_modules /s /mir > NUL
rmdir empty_dir
rmdir node_modules /s /q
)
if exist bower_components (
echo Ordner bower_components wird entfernt...
mkdir empty_dir
robocopy empty_dir bower_components /s /mir > NUL
rmdir empty_dir
rmdir bower_components /s /q
)
echo.
echo Module werden eingerichtet...
echo Bitte warten...
npm install & bower install
echo Einrichtung abgeschlossen.
pause
goto menu

:start
if exist node_modules if exist bower_components (
echo Gulp wird gestartet...
gulp
) else (
echo Projekt nicht ordnungsgemaess eingerichtet!
pause
goto init
)

:special
cls
echo;
echo;
echo      [G]ulp global installieren
echo;
echo      [B]ower global installieren
echo;
echo      [Z]urueck zum Hauptmenue
echo;
echo;

choice /n /c "gbz" /m "Auswahl treffen (G/B/Z)?"
if errorlevel 3 goto menu
if errorlevel 2 goto bower
if errorlevel 1 goto gulp

:gulp
npm i -g gulp
pause
goto menu

:bower
npm i -g bower
pause
goto menu

:end
exit
