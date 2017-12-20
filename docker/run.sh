#!/bin/bash
## Do not try to delete if container doesn't exist
docker inspect zf-expressive > /dev/null
errorCode=$?
if [[ "${errorCode}" == '0' ]]; then
    echo "Removing old container"
    docker rm zf-expressive
fi

echo "Starting container"
ID=$(docker run -d -t -i \
    -v /home/fcailliez/Sources/www/zf-expressive:/var/www/zf-expressive \
    -p "80:80" \
    --add-host="zf-expressive.localhost.com:127.0.0.1"\
    --name="zf-expressive" zf-expressive)
echo ${ID}