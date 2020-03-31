Mozno bude treba pred spustenim Dockeru na WIN spravne nastafit format suboru na UNIX pre .docker/entrypoint.sh 

### Ako spustit cez docker

```bash
$ docker-compose run --rm default install 
$ docker-compose run --rm default
```

### Ako spustit bez dockeru

```bash
$ composer install
$ php bin/console
```
