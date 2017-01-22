#!/bin/bash

# Import the SSH deployment key
openssl aes-256-cbc -K $encrypted_55b8fcc60259_key -iv $encrypted_55b8fcc60259_iv -in deploy-key.enc -out deploy-key -d
rm deploy-key.enc # Don't need it anymore
chmod 600 deploy-key
mv deploy-key ~/.ssh/id_rsa

composer install
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate