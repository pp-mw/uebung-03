@echo off
choice /n /m "Module einrichten (J/N)?"
if errorlevel 2 goto end
if errorlevel 1 goto yes

:yes
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

:end
exit