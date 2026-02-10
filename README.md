## About Our Project (Im tired of scrolling: php artisan db:seed --class=TicketSeeder)

Raivo is my boywife xoxo

Nonetheless
For future step by step guide:

composer create-project laravel/laravel @YourProject@

cd @YourProject@

copy .env.example .env (when needed from cloning)

then php artisan key:generate

Personally prefer sqlite so my steps differ aka (create the file database/database.sqlite un database folder)

In .env set: DB_CONNECTION=sqlite

Once db is created c=: php artisan migrate

## Auth part

composer require laravel/breeze --dev

php artisan breeze:install

When prompted, choose: Blade ; dark mode (optional) ; Yes to PHPUnit 

php artisan migrate again

npm install

npm run dev

## Fillament part

composer require filament/filament

php artisan filament:install --panels

Panel id: admin

php artisan make:filament-user to create an acc you'll try to get accesss to fillament

## Ticket part

php artisan make:model Ticket -m

php artisan make:model TicketReply -m

Mess with migration (table acceptable data rows)

php artisan migrate

## Ticket BS PART part

php artisan make:filament-resource Ticket

 The "title attribute" is used to label each record in the UI.

 You can leave this blank if records do not have a title.

  What is the title attribute for this model?
❯ title

  Would you like to generate a read-only view page for the resource? (yes/no) [no]      
❯ no

  Should the configuration be generated from the current database columns? (yes/no) [no]
❯ yes

   INFO  Filament resource [App\Filament\Resources\Tickets\TicketResource] created successfully.

## Ticket Setting Up part

seeder:

php artisan db:seed --class=TicketSeeder

btw downlaod extension sql lite viewer for the ability to see

php artisan make:filament-resource TicketReply --nested=TicketResource

Create Schemas/TicketReplyForm.php

php filament-debug.php made a file in root aka base of the project to debug

## Ticket 8 PM Intrusive thoughts of ending it all atp


## Ticket 9:40 PM I realised my mistake and well, some part of previous ticket creation was useless btw; user interface:

php artisan make:controller TicketController --resource --model=Ticket
#
php artisan make:controller UserTicketController --resource
#
php artisan make:view tickets.index
#
php artisan make:view tickets.create
#
php artisan make:view tickets.show

## Ticket Admin Check
php artisan make:migration add_is_admin_to_users_table
