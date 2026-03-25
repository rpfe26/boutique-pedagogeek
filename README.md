# Boutique PedagoGeek - WordPress

Site e-commerce WordPress pour la boutique pédagogique.

## Installation rapide

### Prérequis
- Docker Desktop (sur Mac/Windows)
- Git

### Lancer avec Docker

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

### Services
- **WordPress :** http://localhost:8080
- **phpMyAdmin :** http://localhost:8081

## Pour Antigravity

Ouvrir ce dossier dans Antigravity. Le fichier `.antigravity/project.md` contient les instructions pour l'IA.

## URLs
- Production : https://boutique.pedagogeek.eu
- Développement : http://localhost:8080

## Credentials par défaut (Docker)
- DB User : `wordpress`
- DB Pass : `wordpress`
- DB Name : `wordpress`
