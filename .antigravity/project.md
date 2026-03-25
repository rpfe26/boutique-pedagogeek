# Boutique PedagoGeek - WordPress E-commerce

## Description
Site WordPress e-commerce pour la boutique pédagogique PedagoGeek.
Vend des formations et ressources pédagogiques pour enseignants.

## Stack technique
- WordPress 6.8
- WooCommerce
- Thème : Blur (ThemeHunk)
- Plugin personnalisé : FDAP Portfolio (fiches d'activités pédagogiques)

## Prérequis locaux
- PHP 8.2+
- MySQL/MariaDB
- Apache/Nginx
- Node.js 18+ (pour le dev frontend)

## Structure du projet
```
├── wp-content/
│   ├── plugins/
│   │   ├── fdap-portfolio/     # Plugin personnalisé FDAP
│   │   └── woocommerce/        # E-commerce
│   ├── themes/
│   │   └── blur/               # Thème principal
│   └── uploads/                # Médias et images FDAP
├── database-backup.sql.gz     # Base de données complète
└── wp-config-sample.php        # Template de configuration
```

## Installation locale

### Option 1: Docker (recommandé)
```bash
docker-compose up -d
# Attendre que les containers soient ready
# Importer la base de données :
gunzip -c database-backup.sql.gz | docker-compose exec -T db mysql -u wordpress -pwordpress wordpress
```

### Option 2: Installation native (macOS)
```bash
# Installer PHP et MySQL via Homebrew
brew install php mysql
brew services start mysql

# Créer la base
mysql -u root -e "CREATE DATABASE wordpress; CREATE USER 'wordpress'@'localhost' IDENTIFIED BY 'wordpress'; GRANT ALL ON wordpress.* TO 'wordpress'@'localhost';"

# Importer le dump
gunzip -c database-backup.sql.gz | mysql -u wordpress -pwordpress wordpress

# Configurer wp-config.php
cp wp-config-sample.php wp-config.php
# Éditer wp-config.php avec les bons credentials

# Lancer le serveur PHP
php -S localhost:8080
```

## URLs importantes
- Production : https://boutique.pedagogeek.eu
- Développement LXC : http://192.168.10.217
- Local : http://localhost:8080

## Base de données
- Tables : 146
- Contenu : Utilisateurs (élèves), Posts (fiches FDAP), WooCommerce products

## Tâches courantes
- Modifier le thème : wp-content/themes/blur/
- Modifier le plugin FDAP : wp-content/plugins/fdap-portfolio/
- Voir les fiches : wp_posts WHERE post_type = 'fdap'

## Git workflow
```bash
git pull origin main
# Modifier les fichiers
git add .
git commit -m "Description"
git push origin main
```
