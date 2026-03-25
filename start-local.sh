#!/bin/bash
# Démarrage WordPress en local sans Docker
# Usage: ./start-local.sh [port]

PORT=${1:-8080}

# Couleurs
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}=== Boutique PedagoGeek - Mode Local ===${NC}"

# Vérifier MySQL
if ! command -v mysql &> /dev/null; then
    echo "${RED}Erreur: MySQL non installé${NC}"
    echo "Installer avec: brew install mysql"
    exit 1
fi

# Vérifier que MySQL tourne
if ! mysqladmin ping -h 127.0.0.1 --silent 2>/dev/null; then
    echo -e "${BLUE}Démarrage MySQL...${NC}"
    brew services start mysql
    sleep 3
fi

# Créer la DB si elle n'existe pas
echo -e "${BLUE}Vérification base de données...${NC}"
mysql -u root -e "CREATE DATABASE IF NOT EXISTS wordpress;" 2>/dev/null

# Vérifier wp-config.php
if [ ! -f wp-config.php ]; then
    if [ -f wp-config-local.php ]; then
        echo -e "${BLUE}Copie de wp-config-local.php vers wp-config.php...${NC}"
        cp wp-config-local.php wp-config.php
    else
        echo -e "${BLUE}Copie de wp-config-sample.php vers wp-config.php...${NC}"
        cp wp-config-sample.php wp-config.php
        echo -e "${GREEN}⚠️  Pensez à modifier wp-config.php avec vos credentials MySQL${NC}"
    fi
fi

# IP locale
IP=$(ipconfig getifaddr en0 2>/dev/null || echo "127.0.0.1")

echo -e "${GREEN}Serveur démarré !${NC}"
echo -e "${BLUE}URLs:${NC}"
echo -e "  Local:   http://127.0.0.1:$PORT"
echo -e "  Réseau:  http://$IP:$PORT"
echo -e ""
echo -e "${BLUE}Pour arrêter: Ctrl+C${NC}"
echo -e "${BLUE}Pour importer la DB:${NC}"
echo -e "  gunzip -c database-backup.sql.gz | mysql -u root wordpress"
echo ""

# Lancer PHP
php -S 0.0.0.0:$PORT
