# TP Restaurant

## Objectif

Ce projet Symfony a pour objectif de démontrer la compréhension des bases de Symfony . Les fonctionnalités incluent la gestion des entités **Restaurants**, **Menus**, **Tables** et **Réservations**, ainsi qu'un système d'authentification.

---

## Fonctionnalités

### 1. Authentification

- **Connexion** : Les utilisateurs peuvent se connecter via un formulaire.
- **Réinitialisation de mot de passe** : Système de réinitialisation de mot de passe.
- **Gestion des rôles utilisateurs** :  
  - **ADMIN** : Accès à toutes les fonctionnalités du site (administration, gestion, etc.).
  - **USER** : Accès limité aux fonctionnalités liées à l'utilisateur.
  - **BANNED** : Accès restreint avec un message spécifique et interdiction d'accéder aux fonctionnalités principales.

### 2. Affichage dynamique selon l'état de l'utilisateur

#### a. En fonction de la connexion :  
- **Utilisateur connecté** :  
  - Affiche le **nom** et le **prénom** de l'utilisateur.  
  - Affiche un bouton de **déconnexion**.  
- **Utilisateur non connecté** :  
  - Affiche un bouton pour se **connecter**.  

#### b. En fonction des rôles :  
- **ADMIN** :  
  - Affiche un bouton pour accéder à la section **Administration**.  
- **USER** :  
  - Affiche un bouton pour accéder au **profil utilisateur**.  
- **BANNED** :  
  - Affiche un message indiquant que l'utilisateur est banni et masque les pages restreintes.

### 3. Gestion des entités

Chaque entité a des fonctionnalités CRUD (Create, Read, Update, Delete).  
Les entités principales sont :  
- **Restaurants**  
- **Menus**  
- **Tables**  
- **Réservations**  

> Les formulaires et routes sont sécurisés.

### 4. Fixtures

Des fixtures ont été créées pour fournir des données de test :  
- **Users** : Trois utilisateurs avec des rôles :  
  - **ADMIN** : `admin@admin.com`  
  - **USER** : `user@user.com`  
  - **BANNED** : `banned@banned.com`  
  > **Mot de passe commun** : `123`  

- **Restaurants** : 5 restaurants.  
- **Tables** : 10 tables par restaurant.  
- **Menus** : 5 menus par restaurant.  
- **Réservations** : 3 réservations par table.  

Pour tester la réinitialisation de mot de passe, vous pouvez inscrire une adresse email fonctionnelle pour recevoir le lien de récupération.

---

## Installation

0. **Telecharger et dézipper le projet / ou direct download depuis github**.

1. **Installer les dépendances du projet** :  
   ```bash
   composer install
   ```

2. **Configurer l'environnement** :  
   Un fichier `.env` préconfiguré est fourni (même si ce n'est pas une bonne pratique) pour simplifier le déploiement.

3. **Créer et configurer la base de données** :  
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

4. **Charger les données de test (fixtures)** :  
   ```bash
   php bin/console doctrine:fixtures:load --no-interaction
   ```

5. **Démarrer le serveur Symfony** :  
   ```bash
   symfony server:start
   ```

---

