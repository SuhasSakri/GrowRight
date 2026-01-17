# GrowRight 🌱

A comprehensive web application for children's health, fitness, and nutrition management. GrowRight provides age-specific workout routines, mental activities, personalized nutrition plans, and AI-powered health assistance.

## Features ✨

### 🏃 Age-Specific Programs
- **Mini Movers (3-5 years)**: Animal walks, rainbow snacks, parent oversight
- **Power Players (6-9 years)**: Balance & agility, meal plans, hydration goals
- **Future Champs (10-13 years)**: Strength & stamina, smart nutrition swaps

### 💪 Physical & Mental Activities
- Age-appropriate physical exercises
- Mental wellness activities and mindfulness games
- Interactive activity tracking

### 🥗 Nutrition Management
- Region-specific meal recommendations (Karnataka regions)
- Calorie, protein, and fiber tracking
- Daily nutrition goals based on age groups
- BMI calculator and health insights

### 🏆 Gamification
- Daily login streak tracking
- Achievement system with unlockable badges
- Water intake reminders
- Progress visualization

### 🤖 AI Health Assistant
- Powered by Groq API (Llama 3.3)
- Real-time health and wellness guidance
- Interactive chat widget

### 👥 User Roles
- **User Dashboard**: Personalized health tracking for children
- **Admin Dashboard**: User management, profile viewing, password reset

## Tech Stack 🛠️

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5.3
- **Backend**: PHP 7.4+
- **Database**: MySQL
- **AI Integration**: Groq API (Llama 3.3-70B)
- **Server**: WAMP/XAMPP

## Installation 📦

### Prerequisites
- WAMP/XAMPP server
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Groq API key ([Get one here](https://console.groq.com))

### Setup Steps

1. **Clone the repository**
```bash
git clone https://github.com/SuhasSakri/GrowRight.git
cd GrowRight
```

2. **Create database**
- Open phpMyAdmin at `http://localhost/phpmyadmin`
- Create a new database named `growright_db`
- Import the SQL schema:
  - Users table with fields: id, name, email, password, created_at
  - Profiles table with fields: user_id, dob, height, weight, region
  - Admin table for admin authentication

3. **Configure API key**
- Copy `openai_config.example.php` to `openai_config.php`
- Create a `.env` file in the root directory:
```env
GROQ_API_KEY=your_groq_api_key_here
```

4. **Database Configuration**
The app uses the following default settings:
- Host: `localhost`
- Username: `root`
- Password: (empty)
- Database: `growright_db`

Edit `db_connect.php` if your configuration differs.

5. **Start the server**
- Start WAMP/XAMPP
- Visit: `http://localhost/front_design/`

## Usage 🚀

### For Users
1. **Register**: Create an account at `/register.php`
2. **Login**: Access your account at `/login.php`
3. **Complete Profile**: Fill in age, height, weight, and region
4. **Dashboard**: View personalized health metrics and achievements
5. **Routines**: Access age-appropriate physical and mental activities
6. **Nutrition**: Get region-specific meal plans and track daily intake
7. **AI Assistant**: Chat with the AI for health guidance

### For Admins
1. **Admin Login**: Access at `/admin_login.php`
2. **Dashboard**: View all registered users
3. **User Management**: View profiles, add users, delete accounts
4. **Password Reset**: Reset user passwords when needed

## Project Structure 📁

```
front_design/
├── index.php              # Landing page
├── login.php              # User login
├── register.php           # User registration
├── user_dashboard.php     # Main user dashboard
├── admin_login.php        # Admin authentication
├── admin_dashboard.php    # Admin panel
├── openai_chat.php        # AI chat backend
├── chat_widget.js         # AI chat widget
├── db_connect.php         # Database connection
├── save_profile.php       # Profile update handler
├── update_streak.php      # Streak tracking logic
├── update_water.php       # Water intake tracking
├── style.css              # Main styles
├── user_script.js         # Dashboard interactions
├── images/                # Image assets
└── .env                   # Environment variables (not in repo)
```

## Key Features Explained 📖

### Streak System
- Tracks consecutive daily logins
- Visual fire emoji indicators (🔥)
- Motivates consistent engagement

### Achievement System
- 7-day and 30-day streak badges
- Hydration achievements (5 and 8 glasses)
- Profile completion badge
- Goal-setting achievement

### Region-Based Nutrition
Meal recommendations tailored for:
- North Karnataka (Ragi-based meals)
- South Karnataka (Rice-based meals)
- East Karnataka (Jowar-based meals)
- West Karnataka (Ragi-based meals)

### BMI Tracking
- Automatic calculation based on height/weight
- Color-coded health categories
- Age-appropriate health advice

## Security 🔒

- Passwords hashed using PHP's `password_hash()`
- Session-based authentication
- SQL injection prevention with prepared statements
- API keys stored in `.env` (not committed to repo)
- `.gitignore` configured to exclude sensitive files

## API Integration 🔌

The app uses Groq API for AI-powered chat:
- Model: `llama-3.3-70b-versatile`
- Max tokens: 300 per response
- System prompt: Health and wellness assistant
- Real-time responses via AJAX

## Contributing 🤝

Contributions are welcome! Please:
1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## License 📄

This project is open source and available under the MIT License.

## Contact 📧

For questions or support:
- Email: growright@gmail.com
- GitHub: [@SuhasSakri](https://github.com/SuhasSakri)

## Acknowledgments 🙏

- Bootstrap for UI components
- Groq for AI capabilities
- Font Awesome for icons
- WAMP/XAMPP for local development environment

---

**Made with ❤️ for children's health and wellness**
