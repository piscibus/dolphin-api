# Authentication

Ensure that the docker container is up and running, then run the following commands.

To create the DB tables and seed some data.
```
sail artisan migrate:refresh seeed
```

To seed the password access client
```
sail artisan dolphin:passport:seed
```

Import this [postman collection](https://www.postman.com/collections/7471dbd6101aa9697bf5) to your workspace. It contains documentation for the authentication endpoints.
