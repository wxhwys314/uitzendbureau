## 📦 Installation

To install the project, run the following commands:

```bash
git clone XXX
cd wachtwoord_manager
npm install

#database
php artisan migrate:fresh
php artisan db:seed

#run server(use two terminals)
npm run dev
php artisan serve