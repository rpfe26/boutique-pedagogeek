# Boutique PedagoGeek - Contexte Projet

## Description
Site e-commerce WordPress pour la boutique pédagogique de Patrick.

## Environnements

### Production (YunoHost)
- URL: https://boutique.pedagogeek.eu
- Serveur: YunoHost (192.168.10.11)
- Path: /var/www/wordpress
- DB: MySQL (YunoHost)

### Développement Local (Mac)
- Option 1: Docker (docker-compose up -d)
- Option 2: Native (./start-local.sh)

## Structure
- Thème: Blur (custom)
- Plugins: FDAP Portfolio, WooCommerce, etc.
- Uploads: wp-content/uploads/

## Plugins Actifs
- WordPress 6.8
- WooCommerce (e-commerce)
- FDAP Portfolio (fiches pédagogiques)
- Code Snippets (personnalisation)

## Tâches Courantes

### Mettre à jour la DB
```bash
# Sur YunoHost
mysqldump -u root wordpress | gzip > database-backup.sql.gz
git add database-backup.sql.gz
git commit -m "Update DB backup"
git push
```

### Reset mot de passe admin
```bash
# Via WP-CLI
php8.3 /usr/local/bin/wp user update admin --user_pass=newpassword --allow-root
```

## Notes
- Toujours faire un snapshot avant modifications critiques
- Le plugin FDAP est en développement actif
