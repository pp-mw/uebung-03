@echo off
choice /n /m "Module loeschen (J/N)?"
if errorlevel 2 goto end
if errorlevel 1 goto yes

:yes
if exist node_modules (
mkdir empty_dir
robocopy empty_dir node_modules /s /mir > nul
rmdir empty_dir
rmdir node_modules /s /q
)
if exist bower_components (
mkdir empty_dir
robocopy empty_dir bower_components /s /mir > nul
rmdir empty_dir
rmdir bower_components /s /q
)

:end
exit