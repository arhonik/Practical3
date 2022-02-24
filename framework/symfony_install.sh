#################
### VARIABLES ###
#################
FILE=/var/www/.symfony/bin/symfony
SYMFONY_INSTALL_DIR=/var/www/symfony
DATABASE_URL="DATABASE_URL=mysql://root:testpass@mysql:3306/docker_dev?serverVersion=5.7"
TEST_DATABASE_URL="DATABASE_URL=mysql://root:testpass@mysql:3306/docker_dev_test?serverVersion=5.7"

##########################
### 1. INSTALL SYMFONY ###
##########################

if [ ! -f "$FILE" ]; then
  curl -sS https://get.symfony.com/cli/installer | bash
fi

if [ -d "$SYMFONY_INSTALL_DIR" ]; then
  rm -rf $SYMFONY_INSTALL_DIR
fi

/var/www/.symfony/bin/symfony new --no-git --full --dir /var/www/symfony


##############################
### 2. REMOVE UNUSED FILES ###
##############################

if [ -d "$SYMFONY_INSTALL_DIR/.git" ]; then
  rm -rf $SYMFONY_INSTALL_DIR/.git
fi

# Remove unused docker-compose configuration files
rm -rf $SYMFONY_INSTALL_DIR/docker-compose.override.yml
rm -rf $SYMFONY_INSTALL_DIR/docker-compose.yml


########################################
### 3. COPY SYMFONY FILES TO PROJECT ###
########################################

cp -a $SYMFONY_INSTALL_DIR/. /var/www/public


################################
### 4. CONFIGURATION PROJECT ###
################################

echo -e ".idea/\ndocker/.env" >>/var/www/public/.gitignore

sed -i "s|DATABASE_URL.*|$DATABASE_URL|g" "/var/www/public/.env"
echo "$TEST_DATABASE_URL" >> /var/www/public/.env.test

php /var/www/public/bin/console doctrine:database:create --if-not-exists
php /var/www/public/bin/console doctrine:database:create --env=test --if-not-exists


############################################
### 5. REMOVE TEMP FILES AND DIRECTORIES ###
############################################

rm -rf $SYMFONY_INSTALL_DIR

printf '\n\e[1;32m%-6s\e[m\n\n' "Symfony installed successfully!"
