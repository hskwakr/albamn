# albamn

A WordPress plugin allows you to make a list of Instagram posts searched by hashtag.

## Local Development Environment

A docker-compose based local development environment is provided.

- Start server
    - `docker-compose up -d`
- Init WordPress ( user / password : admin / pass )
    - `./init-wp.sh`
- Access site
    - http://localhost:8080
    - http://localhost:8080/wp-admin
- End server
    - `docker-compose down -v`
