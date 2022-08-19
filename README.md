# albamn

A WordPress plugin allows you to make a list of Instagram posts searched by hashtag.

## Installation

Download latest version from [Releases](https://github.com/hskwakr/albamn/releases "Releases · hskwakr/albamn · GitHub")

Change permission for medias directory writable.
```
cd ./albamn-hskwakr
chmod 777 ./medias
```

Put this plugin in `wp-content/plugins/`

## Local Development Environment

A docker-compose based local development environment is provided.

- Start server
    - `docker-compose up -d`
- Init WordPress ( user / password : admin / pass )
    - `./init-wp.sh`
- Unit testing
    - `docker-compose run phpunit phpunit`
- Access site
    - http://localhost:8080
    - http://localhost:8080/wp-admin
- End server
    - `docker-compose down -v`
