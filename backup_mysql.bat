@echo off
setlocal enabledelayedexpansion

set USER=root
set PASSWORD=
set DATABASE=sipanti
set BACKUP_DIR=D:\backup

:: Format timestamp (YYYY-MM-DD_HHMM)
for /f "tokens=1-3 delims=/- " %%a in ("%date%") do (
    set DAY=%%a
    set MONTH=%%b
    set YEAR=%%c
)

set hh=%time:~0,2%
set mm=%time:~3,2%
if "%hh:~0,1%"==" " set hh=0%hh:~1,1%

set TIMESTAMP=%YEAR%-%MONTH%-%DAY%_%hh%%mm%

echo Mulai backup database %DATABASE%...

"C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe" -u%USER% %DATABASE% > "%BACKUP_DIR%\backup_%DATABASE%_%TIMESTAMP%.sql" 2> "%BACKUP_DIR%\backup_error.log"
