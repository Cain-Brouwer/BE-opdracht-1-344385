# Jamin Magazijn — Backend

Backend voor de opdracht *Inzien leveringsinformatie product* en *Inzien allergeneninformatie product*
(Jamin, klas IO-SD-2509). Laravel 13 met PHP 8.5 en MySQL/MariaDB.

Studentnummer 344385.

## Opleveringen

| Bestand | Inhoud |
| --- | --- |
| `create_script_jamin.sql` | Create-script voor de zes specificatietabellen, inclusief relaties en data. |
| `db/BE-opdracht-1-344385_jamin.sql` | Database-export, direct te importeren in MySQL Workbench. |
| `docs/Database_Specificatie_Tabel.md` | Database Specificatie Tabel: velden, datatypes, nullable, sleutels, relaties en ERD. |
| `vids/` | Filmpje met de gerealiseerde scenario's. |

## Database

De applicatie gebruikt MySQL/MariaDB met database **`laravel`** (zie `DB_DATABASE` in `.env`).

| Instelling | Waarde |
| --- | --- |
| Host | `127.0.0.1` |
| Poort | `3306` |
| Database | `laravel` (tests: `laravel_test`) |
| Gebruiker | `root` (leeg wachtwoord, lokaal) |
| Charset | `utf8mb4` / `utf8mb4_unicode_ci` |

### Verbinden met MySQL Workbench

1. Nieuwe verbinding aanmaken (of bestaande bewerken).
2. Connection Name: `Jamin (lokaal)`.
3. Host: `localhost`, Port: `3306`, Username: `root`, wachtwoord leeg laten.
4. Schema kiezen: `laravel`.
5. Verbinden — de database is direct te openen en te bewerken.

Wordt MySQL Workbench op een **andere machine** gebruikt, dan is het IP-adres van deze laptop
nodig in plaats van `localhost`. Let op: dan is er een wachtwoord nodig, want de lege
`root`-inlog geldt alleen lokaal.

### Database aanmaken / vullen

```bash
php artisan migrate:fresh --seed
```

- `migrate` bouwt alle tabellen op, inclusief de zes Jamin-tabellen uit `create_script_jamin.sql`.
- `--seed` vult rollen, categorieën, producten en de drie demo-gebruikers.

Los daarvan:

```bash
php artisan migrate          # alleen migraties draaien
php artisan migrate:rollback # migraties terugdraaien
php artisan db:seed          # alleen seeders draaien
php artisan db:show          # overzicht van tabellen en rijen
```

### Create-script

`create_script_jamin.sql` is het create-script voor de zes specificatietabellen
(`Product`, `Allergeen`, `Leverancier`, `Magazijn`, `ProductPerAllergeen`,
`ProductPerLeverancier`) inclusief systeemvelden, relaties en de voorbeelddata uit de opdracht.

Het script is **idempotent**: foreign keys worden aan het begin en einde even uitgezet, dus je
kunt het meerdere keren uitvoeren zonder dat er een foutmelding over foreign keys komt.

Uitvoeren vanuit MySQL Workbench: selecteer het schema `laravel`, klik met rechts op het schema en
kies *Set as default*, plak daarna het script in een SQL-tabblad en voer het uit. De regels
`CREATE DATABASE` / `USE` in het script staan bewust als commentaar, omdat de applicatie het schema uit
`.env` gebruikt.

### Database-export

`db/BE-opdracht-1-344385_jamin.sql` bevat een volledige export van database `laravel`, inclusief het
create-statement voor de database zelf. Importeren in MySQL Workbench: open het bestand in een
SQL-tabblad en voer het uit. De veldnamen, typen, foreign keys en de data komen dan exact
overeen met de specificatie in `docs/Database_Specificatie_Tabel.md`.

### Migraties

| Migratie | Wat het doet |
| --- | --- |
| `0001_01_01_*` | users, cache, jobs/queues |
| `2026_09_13_192456_create_permission_tables` | rollen en rechten (Spatie) |
| `2026_09_14_000000_create_categories_table` | `categories` |
| `2026_09_14_000001_create_products_table` | `products` (winkelcatalogus) |
| `2026_09_24_083951_import_database_jamin` | voert `create_script_jamin.sql` uit |

De Jamin-migratie slaat zichzelf over op andere drivers dan MySQL, zodat de tests op SQLite kunnen
draaien.

### Modellen

| Model | Tabel |
| --- | --- |
| `Product` | `Product` (Jamin, kolom `Id`) |
| `Magazijn` | `Magazijn` |
| `Allergeen` | `Allergeen` |
| `Leverancier` | `Leverancier` |
| `ProductPerLeverancier` | `ProductPerLeverancier` |
| `ProductPerAllergeen` | `ProductPerAllergeen` |
| `Category` | `categories` |
| `ShopProduct` | `products` (winkelcatalogus) |

Let op het verschil tussen `Product` (Jamin, met hoofdletter) en `ShopProduct` (winkelcatalogus).
MySQL behandeld tabelnamen hoofdlettergevoelig, dus `Product` en `products` zijn twee tabellen.

## Aan de slag

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build

php artisan serve
```

## Gebruikers uit de seeder

| E-mail | Wachtwoord | Rol |
| --- | --- | --- |
| `admin@admin.com` | `wachtwoord` | admin |
| `magazijnmedewerker@jamin.nl` | `wachtwoord` | magazijnmedewerker |
| `klant@jamin.nl` | `wachtwoord` | klant |

## Schermen

De kolomvolgordes en de velden bovenaan de tabellen komen overeen met de wireframes uit de
opdracht. `tests/Feature/WireframeTest.php` controleert dat.

| Route | Naam | Rol |
| --- | --- | --- |
| `/` | Home met link naar het magazijn | iedereen |
| `/magazijn` | **Overzicht Magazijn Jamin** | magazijnmedewerker, admin |
| `/magazijn/{product}/leveringsinformatie` | **Levering Informatie** (user story 1) | magazijnmedewerker, admin |
| `/magazijn/{product}/allergenen` | **Overzicht Allergenen** (user story 2) | magazijnmedewerker, admin |
| `/categories` | Categorieën met producten | iedereen |
| `/dashboard` | Dashboard met eigen rollen | ingelogd |
| `/admin` | Overzicht alle gebruikers | admin |

### User story 1 – Inzien leveringsinformatie product

Het overzicht toont alle producten die in het magazijn aanwezig zijn, **gesorteerd op barcode
oplopend**. De kolommen staan in dezelfde volgorde als de wireframe: `Barcode`, `Naam`,
`Verpakkingseenheid`, `Aantal aanwezig`, `Allergenen Info` en `Leverantie Info`. In de kolom
*Allergenen Info* staat een rood kruis, in *Leverantie Info* een blauw vraagteken.

Het detailscherm toont bovenaan de vier leveranciergegevens (naam, contactpersoon,
leveranciernummer, mobiel) en daaronder de leveringen met de kolommen `Naam Product`,
`Datum laatste levering`, `Aantal` en `Eerstvolgende levering`, **gesorteerd op datum laatste
levering oplopend**.

Scenario 02 (Winegums): als `AantalAanwezig` `NULL` of `0` is, toont het scherm de melding
*Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is:
30-10-2024* en wordt je na 4 seconden teruggestuurd naar het overzicht.

### User story 2 – Inzien allergeneninformatie product

Het detailscherm toont bovenaan de velden `Naam` en `Barcode` van het product en daaronder de
kolommen `Naam` en `Omschrijving` met de allergenen, **gesorteerd op naam oplopend**.

Scenario 02 (Cola Flesjes): als het product geen allergenen heeft, toont het scherm de melding *In dit
product zitten geen stoffen die een allergische reactie kunnen veroorzaken* en wordt je na 4 seconden
teruggestuurd naar het overzicht.

> Let op: in de opdracht staat "30-04-2023", maar in de data staat voor Winegums een eerstvolgende
> levering van **30-10-2024**. De applicatie toont de datum uit de database.

## Tests

De tests draaien op de MySQL-database **`laravel_test`**, zodat de Jamin-tabellen uit
`create_script_jamin.sql` echt worden meegenomen. De ontwikkeldatabase `laravel` wordt niet geraakt.

De testdatabase eenmalig aanmaken:

```sql
CREATE DATABASE IF NOT EXISTS `laravel_test` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
php artisan test
vendor/bin/pint --dirty
```

## Rollen en rechten

Rollen komen uit `Spatie\Permission`. De middleware-alias `role`, `permission` en
`role_or_permission` zijn geregistreerd in `bootstrap/app.php`.

| Rol | Wie | Mag wat |
| --- | --- | --- |
| `magazijnmedewerker` | Medewerker van het magazijn | Overzicht Magazijn Jamin, Levering Informatie, Overzicht Allergenen |
| `admin` | Beheerder | Alles van de magazijnmedewerker, plus het overzicht van alle gebruikers op `/admin` |
| `klant` | Geregistreerd webaccount | Dashboard en de publieke pagina's, geen magazijntoegang |

Nieuwe accounts die zichzelf registreren krijgen automatisch de rol `klant`.

### Databaseserver

De applicatie gebruikt de systemaardige MariaDB op **poort 3306**. Let op: XAMPP draait op deze
laptop ook een MySQL-server, op **poort 3307**. MySQL Workbench is standaard met die XAMPP-server
verbonden en toont dan een verouderde kopie. Maak in Workbench daarom een verbinding met
Host `localhost` en Poort `3306`; dan zie je dezelfde database als de applicatie.