# Installation steps

### Clone this repo
* `git clone https://github.com/Shaykhnazar/products-crud-task.git`
* `cp .env.example .env`

#### After that run docker compose
* `cd docker`
* `cp .env.example .env`
#### Set properly variables to .env file
* `docker-compose up -d`
###### Get access to volumes while creating containers!!!


### Setup database
#### Import database from `dump.sql` [file](https://github.com/Shaykhnazar/products-crud-task/blob/main/dump.sql)

#### Default database credentials to access products page:
```
login: admin
password: secret
```

### [Open project after setup on browser](http://127.0.0.1:8000)
