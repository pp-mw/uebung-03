@echo off
if exist node_modules if exist bower_components (
echo Gulp wird gestartet...
gulp
) else (
echo Projekt nicht ordnungsgemaess eingerichtet!
pause
)
