# Serial critique

Site web de critiques de séries TV, réalisé en PHP / MySQL selon une architecture **MVC**,
dans le cadre de l'UE **BDW – Bases de données et programmation web** (L2, Université Claude Bernard Lyon 1).

## Fonctionnalités

- **Accueil** : statistiques de la base (séries, épisodes, acteurs/actrices, critiques) et dernières critiques publiées.
- **Catalogue des séries** : une carte par série avec son nombre de saisons, d'épisodes et de critiques.
- **Fiche d'une série** : saisons et épisodes, distribution, critiques, et formulaire pour **publier une critique**.
- **Ajout d'une série** (avec contrôle des doublons).
- **Recherche** d'une série ou d'un acteur / d'une actrice.
- **Toutes les données** : vue d'ensemble des séries, critiques, acteurs/actrices et épisodes.
- **Historique** des actions de la session, exportable dans un fichier `.log`.

## Technologies

- PHP 8 (extension `mysqli`), sans framework
- MySQL 8 / MariaDB (moteur InnoDB, clés étrangères)
- HTML5 / CSS3 (mise en page responsive)

## Structure du projet

```
serial-critique/
├── index.php            # contrôleur frontal : routage, exécution du contrôleur puis de la vue
├── bd.sql               # schéma de la base + jeu de données
├── inc/
│   ├── routes.php       # association page → contrôleur / vue
│   ├── includes.php     # constantes du site et fonctions utilitaires
│   ├── config-bd.php    # choix automatique des paramètres de connexion (local / serveur)
│   └── config-bd.local.example.php   # modèle d'identifiants pour le serveur de l'UE
├── modele/modele.php    # accès aux données (requêtes préparées)
├── controleurs/         # un contrôleur par page
├── vues/                # une vue (gabarit HTML) par page
├── static/              # en-tête, menu, pied de page
├── css/style.css
├── img/
└── historiques/         # fichiers d'historique générés (non versionnés)
```

## Base de données

Le schéma (`bd.sql`) contient six tables :

| Table | Description |
|---|---|
| `Series` | les séries (`nomSerie`) |
| `Saisons` | saisons d'une série, avec leur date de lancement |
| `Episodes` | épisodes d'une saison (`numero`, `titre`) |
| `Actrices` | acteurs et actrices (`numINSEE`, `nom`, `prenom`) |
| `Jouer` | participation d'un acteur / d'une actrice à un épisode, avec son salaire |
| `Critiques` | critiques des internautes sur une série |

Les clés étrangères sont déclarées avec `ON DELETE CASCADE` : supprimer une série supprime ses saisons, épisodes, rôles et critiques.

## Installation en local (WampServer)

1. Démarrer **WampServer** (icône verte).
2. Ouvrir http://localhost/phpmyadmin (utilisateur `root`, mot de passe vide, serveur **MySQL**),
   créer une base `serial_critique` (interclassement `utf8mb4_general_ci`), puis l'onglet **Importer** → `bd.sql`.
3. Placer le dossier du projet dans `C:\wamp64\www\serial-critique`
   (ou créer un lien vers le dossier du projet, en PowerShell :
   `New-Item -ItemType Junction -Path C:\wamp64\www\serial-critique -Target <chemin du projet>`).
4. Ouvrir http://localhost/serial-critique/

> WampServer place MySQL sur le port **3308** et MariaDB sur **3307** ; XAMPP utilise **3306**.
> Adaptez la constante `PORT` dans `inc/config-bd.php` si besoin.

**Sans WampServer** (serveur PHP intégré, une base MySQL doit tout de même tourner) :

```bash
php -S localhost:8000
```

puis ouvrir http://localhost:8000/

## Déploiement sur le serveur de l'UE (bdw.univ-lyon1.fr)

1. Importer `bd.sql` via http://bdw.univ-lyon1.fr/phpmyadmin.
2. Copier `inc/config-bd.local.example.php` en `inc/config-bd.local.php` et y renseigner vos identifiants.
   Ce fichier est ignoré par git : vos identifiants ne sont jamais publiés.
3. Envoyer le dossier sur le serveur (scp, rsync ou FileZilla) et rendre le dossier `historiques`
   accessible en écriture : `chmod 777 historiques`.
4. Ouvrir `http://bdw.univ-lyon1.fr/<votre-login>/serial-critique/`

## Sécurité

- Toutes les requêtes utilisant une saisie de l'utilisateur sont des **requêtes préparées** (protection contre les injections SQL).
- Toutes les données affichées sont échappées avec `htmlspecialchars` (protection contre les failles XSS).
- Les formulaires suivent le schéma **Post/Redirect/Get** (pas de double envoi en rafraîchissant la page).

## Crédits

Squelette du site et jeu de données : Fabien Duchateau, UCB Lyon 1 – UE BDW.
Contenu sous licence [CC BY-NC-SA](https://creativecommons.org/licenses/by-nc-sa/4.0/).
