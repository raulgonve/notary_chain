# Shortcut to generate a model, migration, factory, seeder, policy, controller, and form requests...
php artisan make:model AvatarsUsuario --all

# Shortcut to generate a model, migration, controller and resource controller...
php artisan make:model -mrc Chirp

# controladores con crud
php artisan make:controller AvatarController --resource

# crear migracion
php artisan make:migration create_avatars_table

# crear seeder
php artisan make:seeder UserSeeder

# borrar bd y correr seeder
php artisan migrate:fresh --seed

# correr seeders
php artisan db:seed
php artisan db:seed --class=PaymentPlatformSeeder
php artisan db:seed --class=BankSeeder

# crear middleware
php artisan make:middleware IsAdmin

# crear eventos y listeners
php artisan make:event CancelarInscripcionTorneoEvent
 
php artisan make:listener SendPodcastNotification --event=PodcastProcessed

# git
git branch
git branch avatars
git checkout avatars

parado en el destino
git merge ramaorigen

Los directorios donde se deben subir son:
Para la web - ../var/www/app -> Aca subir la nueva versión / printingAds
Para el admin - ../var/www/admin -> Aca subir la nueva versión / ADbranch

# web sockets
php artisan websockets:serve --port=6781
https://beyondco.de/docs/laravel-websockets/basic-usage/starting
sudo tail -f /var/log/supervisor/supervisord.log - en vivo
sudo cat /var/log/supervisor/supervisord.log - log escrito

# crear clases para correr en el cron commands
php artisan make:command CerrarTorneoSemanal

# export NODE_OPTIONS=--openssl-legacy-provider

# chequear BD
systemctl status mysql
systemctl start mysql
cat /var/log/mysql/error.log

# ssh viejo
"username": "root",
"remotePath": "/home/trucostars-api/",
"host": "153.92.211.101",

# emails
php artisan make:mail InvoicePaid --markdown=mail.invoice.paid

# Firma digital del archivo
shasum -a 1 [AQUÍ VA EL NOMBRE DEL ARCHIVO O RUTA COMPLETA]
