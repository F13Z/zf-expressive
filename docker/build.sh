#!/bin/bash
echo "Removing old images"
docker rmi zf-expressive
echo "Building dockerfile..."

docker build -t "zf-expressive" .