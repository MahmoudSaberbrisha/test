@echo off
REM Batch script to fix PHP extension loading errors in XAMPP on Windows

SET XAMPP_PHP_DIR=C:\xampp\php
SET PHP_INI=%XAMPP_PHP_DIR%\php.ini
SET EXT_DIR=%XAMPP_PHP_DIR%\ext

echo Checking if php.ini exists at %PHP_INI%
if not exist "%PHP_INI%" (
    echo ERROR: php.ini not found at %PHP_INI%
    pause
    exit /b 1
)

echo Backing up php.ini to php.ini.bak
copy /Y "%PHP_INI%" "%PHP_INI%.bak"

echo Setting extension_dir to "ext" in php.ini
powershell -Command "(Get-Content '%PHP_INI%') -replace '^\s*extension_dir\s*=.*', 'extension_dir = \"ext\"' | Set-Content '%PHP_INI%'"

REM List of required extensions
set EXTENSIONS=bz2 curl fileinfo gd gettext mbstring exif mysqli pdo_mysql pdo_sqlite zip openssl ftp

echo Enabling required extensions in php.ini
for %%e in (%EXTENSIONS%) do (
    powershell -Command "(Get-Content '%PHP_INI%') -replace '^\s*;?\s*extension=php_%%e.dll', 'extension=php_%%e.dll' | Set-Content '%PHP_INI%'"
)

echo Disabling browscap directive in php.ini
powershell -Command "(Get-Content '%PHP_INI%') -replace '^\s*browscap\s*=.*', ';browscap =' | Set-Content '%PHP_INI%'"

echo Checking for missing DLL files in %EXT_DIR%
set MISSING_DLLS=0
for %%e in (%EXTENSIONS%) do (
    if not exist "%EXT_DIR%\php_%%e.dll" (
        echo WARNING: Missing DLL php_%%e.dll
        set /a MISSING_DLLS+=1
    )
)

if %MISSING_DLLS% neq 0 (
    echo.
    echo Some DLL files are missing. Please reinstall or repair your XAMPP installation.
    pause
    exit /b 1
)

echo Restarting Apache server
net stop Apache2.4
net start Apache2.4

echo PHP extensions fixed and Apache restarted.
pause
