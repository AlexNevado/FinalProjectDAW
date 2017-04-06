#!/bin/bash
echo "**Server is running**"
find ${PWD}/server -name "server.php"  | while read i
do 
  /usr/bin/php -q "$i";
done