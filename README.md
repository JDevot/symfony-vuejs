# symfony Php vuejs

# Installation
    Dans le dossier server 
    Executer les commandes suivantes :

        composer install    
        php bin/console doctrine:database:create
        php bin/console doctrine:schema:update -f
    
    Ajouter des fixtures: 
         bin/console doctrine:fixtures:load
    Penser a modifier le .env
# Usage
# Routes
Liste des articles :
Route: /post

Méthodes: GET

Paramètres: aucun

Résultat :
```json
[
    {
        "id": 1,
        "title": "Article 1",
        "body": "Lorem Ipsum"
    },
    {
        "id": 2,
        "title": "Article 2",
        "body": "Lorem Ipsum"
    }
]
```
Post :

Route: /post/{id}

Méthodes: GET

Paramètres:

id : int
Résultat:
```json
{
  "id": 1,
  "title": "test",
  "body": "test"
}
```

Article :

Route: /post/{id}

Méthodes: PUT

Paramètres:

id : int
Résultat:
```json
{
  "id": 1,
  "title": "test",
  "body": "test"
}
```
Route: /post/{id}

Méthodes: DELETE

Paramètres:

id : int
Résultat:
Status: 204
```json

```
