# How to run News point backend

## Update .env with these required fields values
```
DB_CONNECTION=mysql
DB_HOST=192.168.xx.xx // Update this with your network address (For db connection)
DB_PORT=33060 // if you change the port on the docker-compose remember to update this
DB_DATABASE=newspoint
MYSQL_ROOT_PASSWORD=root
DB_USERNAME=root
DB_PASSWORD=root

GUARDIAN_API_KEY=
NEWSAPI_API_KEY=
NYTIMES_API_KEY=

GUARDIAN_NEWS_URL=""
NYTIMES_NEWS_URL=""
NEWSAPI_NEWS_URL=""

SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost
```

## Start the app
```
docker-compose up –build
```



## Run Migrations
```
docker exec -it newspoint-app sh 
php artisan migrate
```
