# 🎮 Game Shop - A Web Application for Browsing and Purchasing Games

This project is a web application for browsing and purchasing video games. Users can browse games by category, read reviews, add games to their cart, and manage their wishlist. The application uses **PHP**, **MySQL**, and **HTML/CSS/JavaScript** for its front-end and back-end functionality.

---

## ✨ Key Features

- 🔍 **Game Browsing:** View a catalog of video games with title, genre, price, platform, description, and ratings.
- 🔎 **Search Functionality:** Find games by title, description, or genre.
- 👤 **User Accounts:** Create accounts to manage your cart, wishlist, and reviews.
- 🛒 **Shopping Cart:** Add games to your cart and review them before checkout (checkout not implemented yet).
- 📝 **Game Reviews:** Leave reviews and ratings for your favorite games.
- 🎯 **Category Filtering:** Filter games by genre.

---

## 🧰 Technologies Used

- 🖥️ **Front-end:** HTML5, CSS3, JavaScript, [📦 Boxicons](https://boxicons.com/)
- 🖧 **Back-end:** ![PHP Logo](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white&style=flat-square) PHP, ![MySQL Logo](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white&style=flat-square) MySQL
- 🗄️ **Database:** MySQL
- 🎨 **CSS Framework:** ![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?logo=bootstrap&logoColor=white&style=flat-square) Bootstrap (via CDN)

---

## ⚙️ Prerequisites

Ensure the following are installed on your system:

- 🌐 **Web Server:** Apache, Nginx, or similar
- 🐘 **PHP:** Version 7.4 or higher with MySQLi extension
- 💾 **MySQL:** Version 5.7 or higher
- 🧮 **MySQL Client:** phpMyAdmin or command-line client
- 📝 **Code Editor/IDE:** VS Code, Sublime Text, or similar

---

## 🚀 Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/NetCatt/GamersDen.git
   ```

2. **Create the Database**
   - Import `game_shop (2).sql` into MySQL using phpMyAdmin or CLI.
   - Update database credentials in `db.php`.

3. **Configure `db.php`**
   ```php
   <?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "your database name";

   $conn = new mysqli($servername, $username, $password);
   if ($conn->connect_error) {
       die("Connection Failed: ". $conn->connect_error);
   } else {
       echo "Connection Established";
       mysqli_select_db($conn, $dbname);
   }
   ?>
   ```

4. **Install Dependencies**
   - No external dependencies needed beyond the prerequisites.

5. **Run the Application**
   - Place files in your web server’s root directory.
   - Access through a web browser.

---

## 🗂️ Project Structure

```
game-shop/
├── css/
│   ├── style.css
│   └── swiper-bundle.min.css
├── image/
│   └── ... (various image files)
├── add_to_cart.php
├── cart.php
├── db.php
├── game-details.php
├── gamelibrary.php
├── game_shop (2).sql
├── header.php
├── index.php
├── login.php
├── logout.php
├── register.php
├── remove_from_cart.php
└── search.php
```

---

## 💡 Usage Examples

- 📝 **Registering:** Visit `register.php`, fill the form, and submit.
- 🔐 **Logging In:** Go to `login.php` and enter credentials.
- 📚 **Browse Games:** Navigate to `gamelibrary.php`.
- 🛍️ **Add to Cart:** Click "Add to Cart" on any game details page.
- 🧭 **Search Games:** Use the search bar at the top.
- 🔎 **View Game Details:** Go to `game-details.php?id=<game_id>`.
- 🌟 **Leave Reviews:** Submit a review on a game’s details page if logged in.

---

## 🔧 Configuration

Edit the `db.php` file to match your database connection settings. Ensure the database name matches the one used to import `game_shop (2).sql`.

---

## 🤝 Contributing Guidelines

No contributing guidelines found. You may want to add one for collaboration clarity.

---

## 📝 License Information

No license file provided. Consider adding an [MIT](https://opensource.org/licenses/MIT) or [GPL](https://www.gnu.org/licenses/gpl-3.0.html) license.

---

## ⚠️ Error Messages

- ❌ **Database Errors:** Ensure correct credentials in `db.php`, and that MySQL is running.
- 📧 **Email Exists:** During registration if email is already registered.
- ⚠️ **Fields Required:** Shown when any required field is blank.
- ❗ **Invalid Credentials:** Shown on incorrect login attempt.
- 🔍 **Game Not Found:** When accessing a non-existent game.
- 🐞 **Other Errors:** Refer to your web server error logs for PHP or SQL issues.

---
