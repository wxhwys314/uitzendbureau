## 📦 Installation

To install the project, run the following commands:

```bash
git clone https://github.com/wxhwys314/uitzendbureau.git
cd uitzendbureau
npm install

#database
php artisan migrate:fresh
php artisan db:seed

#run server(use two terminals)
npm run dev
php artisan serve