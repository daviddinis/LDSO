#!/bin/bash

#################################################################################
#
#                         Deploy script for iFleet app (staging/production)
#                         
#                           Requirements:
#                               - git
#                               - docker
#                               - docker compose
#                               - yq
#                               - ssh with (probably) root access
#
#                           Call script like this:
# 
#                            ssh -o StrictHostKeyChecking=no $ACCESS_URL "bash -s" < ./deploy-staging.sh \
#                              $DEPLOY_VERSION
#                              $GITLAB_ACCESS_USER \
#                              $GITLAB_ACCESS_TOKEN \
#                              $DB_HOST \
#                              $DB_NAME \
#                              $DB_ROOT_USER \
#                              $DB_ROOT_PWD \
#                              $PGADMIN_USER \
#                              $PGADMIN_PWD
#
#
################################################################################

# Parameters
DEPLOY_VERSION=$1;

GITLAB_ACCESS_USER=$2;
GITLAB_ACCESS_TOKEN=$3;

POSTGRESQL_DB_HOST=$4;
POSGRESQL_DB_NAME=$5;
POSTGRESQL_ROOT_USER=$6;
POSTGRESQL_ROOT_PWD=$7;

PGADMIN_ADMIN_USER=$8;
PGADMIN_ADMIN_PWD=$9;

echo "Deploying..."

# In staging: stop and remove all containers & images
if [[ "$DEPLOY_VERSION" == "staging" ]];
then
    echo "Staging!"
 	docker stop $(docker ps -aq)
	docker rm $(docker ps -aq)
	docker rmi $(docker images -q)
    
    cd /home/ubuntu/ifleet/staging

# In prod: stop & remove only laravelapp
elif [[ "$DEPLOY_VERSION" == "production" ]];
then
    echo "Production!"
    docker kill app
    docker rm app
    docker rmi laravelapp

    cd /home/ubuntu/ifleet/production
fi

if [[ -d "t1g3" ]];
then
    echo "found repo folder, deleting..."
    sudo rm -rf t1g3
fi

echo "Cloning new repo"

# Decide what branch to pull
if [[ "$DEPLOY_VERSION" == "staging" ]]; 
then
    git clone --single-branch --branch staging https://$GITLAB_ACCESS_USER:$GITLAB_ACCESS_TOKEN@gitlab.com/feup-tbs/ldso2021/t1g3.git
elif [[ "$DEPLOY_VERSION" == "production" ]];
then
    git clone --single-branch --branch master https://$GITLAB_ACCESS_USER:$GITLAB_ACCESS_TOKEN@gitlab.com/feup-tbs/ldso2021/t1g3.git

    # In prod we do not want to drop the DB or insert test values
    # so we replace the seed script
    echo "Changing seed script..."
    cp -f ./t1g3/fleetmanagement/resources/sql/seed_production.sql ./t1g3/fleetmanagement/resources/sql/seed.sql
fi

cd t1g3/fleetmanagement

echo "Updating secrets..."

# Replace env variables, append ok since laravel will only use the last version of the variable
echo "DB_HOST=$POSTGRESQL_DB_HOST"       >> .env
echo "DB_DATABASE=$POSGRESQL_DB_NAME"    >> .env
echo "DB_USERNAME=$POSTGRESQL_ROOT_USER" >> .env
echo "DB_PASSWORD=$POSTGRESQL_ROOT_PWD"  >> .env

# Update docker-compose.yml secrets
yq w -i docker-compose.yml services.db.environment.POSTGRES_DB $POSGRESQL_DB_NAME
yq w -i docker-compose.yml services.db.environment.POSTGRES_USER $POSTGRESQL_ROOT_USER
yq w -i docker-compose.yml services.db.environment.POSTGRES_PASSWORD $POSTGRESQL_ROOT_PWD

yq w -i docker-compose.yml services.pgadmin.environment.PGADMIN_DEFAULT_EMAIL $PGADMIN_ADMIN_USER
yq w -i docker-compose.yml services.pgadmin.environment.PGADMIN_DEFAULT_PASSWORD $PGADMIN_ADMIN_PWD

## Give our user ownership (for logging, uploading images etc)
sudo chown -R ubuntu:www-data storage
sudo chown -R ubuntu:www-data bootstrap/cache
sudo chown -R ubuntu:www-data public


## Build & start container
echo "Building..."
docker-compose build && docker-compose up -d
docker-compose exec -T app bash -c "composer install && php artisan config:cache && php artisan key:generate && php artisan db:seed"
echo "Deployed!"
