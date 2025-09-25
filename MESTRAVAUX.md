Travaux réalisés : 
- Passage en PHP 8.4
- Supression de la partie SASS remplacée par Tailwind dans le but d'aller rapide sur la partie graphique
- Création des migrations pour la gestion des produits et panier
- Création des models
- Rendu JSON sur les exceptions lors que la requête demande du `application/json`
- Installation du paquet `soyhuce/next-ide-helper` pour un accès rapide aux propriétés, méthodes ... des modèles
- Installation du paquet `spatie/laravel-data` afin de travailler avec des "objets"
- Implémentation inversion de responsabilités sur la persistance sur la partie ProductController => la méthode de controller : 
    * intercepte une request
    * la transforme en data
    * inject la data dans une action qui fait les traitements en base de données
    * retourne l'objet créé
- Implémentation de la partie panier de manière assez simple
- Ajout configuration pint pour le code style
- Implémentations de tests unitaires et fonctionnels (non finalisés) avec Pest. Les tests de features ont des mocks car les actions sont testés unitairement
  On aurait pu tester unitairement les resources et requests afin d'avoir des tests de features assez light.
- Implémentation de resources en lieu et place du `response()->json(...)` : cela permet de ne renvoyer seulement ce dont on a besoin
- Récupération du token dans les endroits où la requête doit être authentifié
- Impossibilité de faire fonctionner les requêtes avec les verbes POST et PUT dû au xcsrf token manquant (sans doute lié au SSR)
- Mise en place des formualaires de création de produit et d'édition de produit
- La création de produit n'est possible seulement si l'utilisateur est un admin
- La mise à jour est possible dans son entiéreté pour un admin mais pour un rôle catalog le prix n'est pas modifiable
- Création du page non authentifié listant les produits paginées (15 produits par page : valeur par défaut de laravel)
- Selon l'utilisateur authentifié des informations apparaîssent : si c'est un admin alors affichage du bouton "Edit", si c'est un user affichage d'un
  bouton "Add to card"
- Création d'une entrée `client/cart` permettant de liste le panier de l'utilisateur connecté
- On lui liste ici son panier ainsi que les produits de son panier.
- Il peut supprimer l'entiereté de son panier
- Il peut supprimer un produit de son panier
- Il peut ajuster la quantité pour chaque produit, celle ci prend en compte le stock disponible et retourne une erreur si la quantité demandée n'est pas possible


