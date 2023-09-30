rm -rf ./*

echo "-------------------------------------------------------------------"
echo "-             Laminas MVC Skeleton Application                    -"
echo "-------------------------------------------------------------------"
composer create-project -s dev laminas/laminas-mvc-skeleton --no-interaction web

echo "-------------------------------------------------------------------"
echo "-                   require packages                              -"
echo "-------------------------------------------------------------------"
cd ./web

#symfony composer config extra.symfony.allow-contrib true
#symfony composer config allow-plugins.symfony/runtime true
symfony composer require php:^8.2.0

composer require --no-interaction laminas/laminas-cli laminas/laminas-session laminas/laminas-i18n
composer require --no-interaction doctrine/migrations doctrine/doctrine-orm-module --with-all-dependencies
echo "-------------------------------------------------------------------"
echo "-               require dev packages                              -"
echo "-------------------------------------------------------------------"

symfony composer require --dev --no-interaction laminas/laminas-developer-tools doctrine/data-fixtures

rm -rf .git
cd ..

chmod -R a+rw web

rsync -a web/ ./
rm -rf web
