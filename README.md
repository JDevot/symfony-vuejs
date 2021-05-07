# symfony Php vuejs

# Installation
    Symfony:
        Dans le dossier server 
        Executer les commandes suivantes :

            composer install    
            php bin/console doctrine:database:create
            php bin/console doctrine:schema:update -f
    
        Ajouter des fixtures: 
            bin/console doctrine:fixtures:load
        Penser a modifier le .env
        Lancer le serveur symfony serve
    Vuejs:
        dans le dossier vuecrud
            Executer les commandes suivantes :

                npm install
             Pour lancer le serveur: 
                npm run serve
