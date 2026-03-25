# Boutique PedagoGeek - WordPress

Site e-commerce WordPress pour la boutique pédagogique.

## Installation

### Option 1: Docker (recommandé pour débuter)

```bash
# Cloner le repo
git clone https://github.com/rpfe26/boutique-pedagogeek.git
cd boutique-pedagogeek

# Copier la config
cp wp-config-sample.php wp-config.php

# Lancer les containers
docker-compose up -d

# Attendre que tout démarre, puis importer la DB
sleep 30
gunzip -c database-backup.sql.gz | docker-compose exec -T db mysql -u wordpress -pwordpress wordpress

# Ouvrir http://localhost:8080
```

### Option 2: Native (sans Docker) - IP locale + port

```bash
# Prérequis (Homebrew)
brew install php mysql

# Cloner le repo
git clone https://github.com/rpfe26/boutique-pedagogeek.git
cd boutique-pedagogeek

# Démarrer MySQL
brew services start mysql

# Créer la DB
mysql -u root -e "CREATE DATABASE wordpress;"

# Importer les données
gunzip -c database-backup.sql.gz | mysql -u root wordpress

# Copier la config locale
cp wp-config-local.php wp-config.php

# Lancer le serveur (port 8080 par défaut)
./start-local.sh

# Ou spécifier un port
./start-local.sh 3000
```

**URLs générées:**
- Local: `http://127.0.0.1:8080`
- Réseau: `http://192.168.x.x:8080`

### Services
- **WordPress :** http://localhost:8080
- **phpMyAdmin (Docker) :** http://localhost:8081

## Pour Antigravity

Ouvrir ce dossier dans Antigravity. Voir `.antigravity/project.md` pour les instructions IA.

## URLs
- Production : https://boutique.pedagogeek.eu
- Développement : http://localhost:8080

## Credentials par défaut (Docker)
- DB User : `wordpress`
- DB Pass : `wordpress`
- DB Name : `wordpress`

## Credentials par défaut (Native/Homebrew)
- DB User : `root`
- DB Pass : `` (vide par défaut)
- DB Name : `wordpress`

## Fichiers importants
- `docker-compose.yml` - Configuration Docker
- `wp-config-sample.php` - Config pour Docker
- `wp-config-local.php` - Config pour installation native
- `start-local.sh` - Script de lancement sans Docker
- `database-backup.sql.gz` - Backup de la base de données

## Mettre à jour la DB depuis la production

Sur YunoHost:
```bash
cd /var/www/wordpress
mysqldump -u root wordpress | gzip > database-backup.sql.gz
```

Puis commit/push vers le repo.
