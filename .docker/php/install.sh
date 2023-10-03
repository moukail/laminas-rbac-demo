rm -rf ./*

echo "-------------------------------------------------------------------"
echo "-             Laminas MVC Skeleton Application                    -"
echo "-------------------------------------------------------------------"
composer create-project -s dev laminas/laminas-mvc-skeleton --no-interaction my_project

echo "-------------------------------------------------------------------"
echo "-                   require packages                              -"
echo "-------------------------------------------------------------------"
cd ./my_project
symfony composer require php:^8.2.0

composer require --no-interaction laminas/laminas-cli laminas/laminas-session
composer require --no-interaction doctrine/doctrine-orm-module --with-all-dependencies

echo "-------------------------------------------------------------------"
echo "-               require dev packages                              -"
echo "-------------------------------------------------------------------"
symfony composer require --dev --no-interaction laminas/laminas-developer-tools

rm -rf .git
cd ..

chmod -R a+rw my_project

rsync -a my_project/ ./
rm -rf my_project
