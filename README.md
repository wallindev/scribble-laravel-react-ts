# scribble-laravel-react-ts
Backend is a Laravel/PHP server that provides API to a MariaDB database, and also serves the HTML page where the React app is run.

At the moment the React SPA is a separate app (node-react-ts). The frontend of that app is going to be placed on top of this backend soon.

The backend serves as the "backoffice" where the administrator manages all users, and also has access to all articles in the database.

## Available Scripts

In the project directory, you can run:

### `composer run dev`

Runs the Laravel server (with the API and backoffice) in development mode, with HMR (Hot Module Reloading).<br>
[http://localhost:3000](http://localhost:3000) opens a minimal Start Page. Will be changed to the React SPA soon.
[http://localhost:3000/admin](http://localhost:3000/admin) opens the backoffice Start Page.

### `npm run build`

Bundles the assets (CSS, and minimal Javascript) with Vite.

### `php artisan serve`

Starts the Laravel server with bundled and minimized static assets.<br>
The Url:s are the same as in development mode:
[http://localhost:3000](http://localhost:3000) (Start Page)
[http://localhost:3000/admin](http://localhost:3000/admin) (Admin/Backoffice Start Page)
