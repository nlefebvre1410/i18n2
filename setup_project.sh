#!/usr/bin/env bash


app/console doctrine:database:drop --force
app/console doctrine:database:create
app/console doctrine:schema:create
app/console doctrine:fixtures:load
#app/console cache:clear
#chmod 0777 app/{cache,logs}
#chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/{cache,logs}
#chmod -R 777 app/cache
#chmod -R 777 app/logs

### Optionaly: create admin behat tests
#app/console kuma:generate:admin-tests
#
#npm install -g bower
#npm install -g gulp
#npm install -g uglify-js
#npm install -g uglifycss
#
#bundle install
#npm install
#bower install
#gulp build
#
#app/console assets:install --symlink
#app/console assetic:dump
