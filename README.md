# appBookApi

## 📄 Descripció - Enunciat de l'exercici

Aquest projecte és una API RESTful desenvolupada amb Laravel per gestionar una biblioteca digital.  
Els usuaris poden tenir el rol de **reader**, **writer** o ambdós.  
- Els *readers* poden llegir llibres i guardar-los a la seva llista de preferits.
- Els *writers* poden crear llibres.
- Un mateix usuari pot llegir i crear llibres si té els dos rols.

## 💻 Tecnologies Utilitzades

- PHP (Laravel)
- Composer
- SQLite/MySQL
- Node.js & npm
- TailwindCSS
- Vite
- Thunder Client (per proves d’API)
- Laravel Passport (autenticació)

## 📋 Requisits

- PHP >= 8.1
- Composer
- Node.js i npm
- SQLite o MySQL

## 🛠️ Instal·lació

1. Clona el repositori
2. Executa `composer install`
3. Executa `npm install`
4. Configura la base de dades a `.env`:

   - Obre el fitxer `.env` a la arrel del projecte.
   - Assegura't que tens aquestes línies:
     ```
     DB_CONNECTION=sqlite
     DB_DATABASE=database/NOM_DEL_FITXER
     ```
     (Per exemple: `DB_DATABASE=database/BaseSandra`)
   - Crea el fitxer buit amb el nom que vulguis dins la carpeta `database`:
     ```sh
     touch database/NOM_DEL_FITXER
     ```
   - ⚠️ El nom i la ruta del fitxer han de coincidir exactament amb el que poses a `.env`, si no, l'aplicació donarà error.
   - 📝 El nom és sensible a majúscules i minúscules. Si a `.env` poses `BaseSandra`, el fitxer ha de ser exactament `BaseSandra`.

5. Executa `php artisan key:generate`
6. Executa `php artisan migrate`
7. (Opcional) Executa `php artisan db:seed`

## ▶️ Execució

- Inicia el servidor de Laravel:  
  `php artisan serve`
- Prova les rutes de l’API amb Thunder Client, Postman o similar.

## 🔒 Seguretat

- **Autenticació:**  
  Totes les rutes de l’API estan protegides amb Laravel Passport.
- **Sistema de rols:**  
  Els usuaris poden ser *reader*, *writer* o ambdós, i l’accés a les rutes es restringeix segons el rol.

## 🧪 Testing

- Es creen tests funcionals per a totes les rutes de l’API.
- Es recomana aplicar TDD (Test Driven Development): escriure els tests abans del codi per definir clarament el comportament esperat de l’aplicació.

## 🤝 Contribucions

Les contribucions són benvingudes!  
Fes un fork, crea una branca i envia un pull request amb la descripció dels canvis.
