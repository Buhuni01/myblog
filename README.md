# MyBlog - Personal Blogging Platform

A full-stack blog application that allows users to create, read, update, and delete blog posts with user authentication and authorization.

## 🌟 Features

- **User Authentication & Authorization**
  - User registration and login system
  - Secure password handling
  - Session management
  - Role-based access control

- **Blog Management**
  - Create new blog posts with a user-friendly editor
  - Read and browse all published blogs
  - Update your own blog posts
  - Delete your own blog posts
  - Author-specific blog management (users can only edit/delete their own posts)

- **Search Functionality**
  - Search bar to find blogs by title or content

- **Share Functionality**
  - Can share post url

- **Responsive Design**
  - Mobile-friendly interface
  - Clean and modern UI
  - Bootstrap-enhanced styling

  ## ✨ Additional Features

- **SweetAlert2 Integration**
  - Beautiful, responsive popup alerts
  - Enhanced user experience for success/error messages
  - Confirmation dialogs for delete operations

## 🛠️ Technologies Used

- **Frontend:**
  - HTML5
  - CSS3
  - Bootstrap (CSS Framework)
  - JavaScript (ES6)
  - AJAX for asynchronous operations
  - SweetAlert2 for beautiful alert popups
 

- **Backend:**
  - PHP
  - MySQL Database

- **Development Tools:**
  - Visual Studio Code
  - XAMPP (Apache, MySQL, PHP)
  - phpMyAdmin

## 📋 Prerequisites

Before running this project, make sure you have the following installed:

- [XAMPP](https://www.apachefriends.org/) (or any other PHP development environment)
- Web browser (Chrome, Firefox, etc.)
- Git (for version control)

## 🚀 Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/myblog.git
cd myblog
```

### 2. Setup Database

1. Start XAMPP and run Apache and MySQL services
2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Create a new database named `lastBlogProject`
4. Import the database schema by running these SQL commands:

```sql
CREATE DATABASE lastBlogProject;
USE lastBlogProject;

-- Create users table

CREATE TABLE user (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(20) DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Create blogPost table
CREATE TABLE blogPost (
  blog_id INT AUTO_INCREMENT PRIMARY KEY,
  user_user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_user_id) REFERENCES user(user_id)
);
```

### 3. Configure Environment Variables

1. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

2. Update the `.env` file with your database credentials:
   ```
   DB_HOST=localhost:3308
   DB_USER=root
   DB_PASS=
   DB_NAME=lastBlogProject
   ```

### 4. Update Connection Settings

If your MySQL runs on a different port, update the `DB_HOST` in your `.env` file and `connection.php` accordingly.

### 5. Run the Application

1. Move the project folder to your XAMPP `htdocs` directory
2. Access the application through your browser:
   ```
   http://localhost/myblog
   ```

## 📁 Project Structure

```
myblog/
│
├── img/
│   └── myblog.svg           # Application logo
│
├── includes/
│   ├── auth.php            # Authentication logic
│   └── function.php        # Helper functions
│
├── connection.php          # Database connection
├── create_post.php         # Create new blog post
├── dashboard.php           # User dashboard
├── delete_post.php         # Delete blog post
├── edit_post.php           # Edit blog post
├── footer.php              # Footer component
├── header.php              # Header component
├── index.php               # Home page
├── login_action.php        # Login handler
├── logout.php              # Logout handler
├── register_action.php     # Registration handler
├── script.js               # JavaScript functionality
├── signIn.php              # Sign in page
├── signUp.php              # Sign up page
├── style.css               # Custom styles
├── view_post.php           # View single blog post
├── .env                    # Environment variables (not committed)
├── .env.example            # Example environment file
├── .gitignore              # Git ignore file
└── README.md               # Project documentation
```

## 💻 Usage

### Register a New Account
1. Navigate to the Sign Up page
2. Fill in your username, email, and password
3. Click "Sign Up" to create your account

### Login
1. Go to the Sign In page
2. Enter your credentials
3. Click "Sign In" to access your dashboard

### Create a Blog Post
1. After logging in, go to the dashboard
2. Click "Create New Post"
3. Enter the title and content
4. Click "Publish" to save your post

### Edit/Delete Posts
1. Navigate to your dashboard
2. Find the post you want to edit or delete
3. Click the respective button (Edit/Delete)
4. Note: You can only edit or delete your own posts

### Search Blogs
1. Use the search bar on the all pages
2. Enter keywords to find specific blogs
3. Results will display matching blog posts

## 🔒 Security Features

- Password hashing for secure storage
- SQL injection prevention using prepared statements
- Session-based authentication
- CSRF protection (implement if not already added)
- User authorization checks on all sensitive operations

## 🌐 Hosting

This application is hosted on **InfinityFree** [https://www.infinityfree.com/]  You can access the live version at:

**Live URL:** [https://myblog-bl.infinityfreeapp.com]

### Hosting Platform Features:
- Free PHP & MySQL hosting
- 5GB storage
- Unlimited bandwidth
- cPanel control panel

### Hosting Instructions

To host on a free platform like InfinityFree or 000WebHost:

1. Export your database from phpMyAdmin
2. Upload all project files via FTP/File Manager
3. Import the database on your hosting control panel
4. Update the `.env` file with your hosting database credentials
5. Ensure all file permissions are set correctly

## 🌐 Live Demo

**Visit the hosted version:** [https://myblog-bl.infinityfreeapp.com]

No installation required! You can:
- Read the blogs without sign up
- Register a new account and sign in
- Create and manage blog posts
- Test all features online

## 🤝 Contributing

Contributions, issues, and feature requests are welcome! Feel free to check the issues page.

## 📝 License

This project is licensed under the MIT License.

## 👤 Author

**[P.M.B.L.Dayananda]**
- Student Index: [235024X]
- GitHub: [@Buhuni01](https://github.com/Buhuni01)
- Email: buhunilevanya@gmail.com

## 📧 Support

For any questions or support, please contact [buhunilevanya@gmail.com]

## 🙏 Acknowledgments

- Thanks to all contributors
- Inspired by modern blogging platforms
- Built as part of [Course In23-S3-IN2120 - Web Programming] project

---

