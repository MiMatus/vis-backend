@echo off
echo.
docker build -t skillshare-gql %~dp0/../.
docker run --rm -it -v %~dp0/../:/var/www/html %* skillshare-gql
pause

