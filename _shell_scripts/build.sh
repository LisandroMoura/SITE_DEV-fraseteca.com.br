#!/bin/bash
docker build -t eduardomourag/pandora-php-nginx -f Docker/Dockerfile .
docker run --name pandora-php-nginx -d -p 192.168.3.3:80:80 -p 192.168.3.3:443:443 eduardomourag/pandora-php-nginx

