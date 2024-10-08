# commands

build docker image
```bash
docker build -t appname .
```

run docker container
```bash
docker run -p 8080:80 -e DEP_ENV={local|staging|production} appname
```
