# GrowRight

A web application for plant care and growth management.

## Setup

### Prerequisites
- WAMP/XAMPP server
- PHP 7.4+
- MySQL
- Groq API key

### Installation

1. Clone the repository:
```bash
git clone https://github.com/SuhasSakri/GrowRight.git
cd GrowRight
```

2. Create database:
- Open phpMyAdmin
- Create database: `growright_db`
- Import SQL schema (if provided)

3. Configure API key:
- Copy `openai_config.example.php` to `openai_config.php`
- Create `.env` file:
```
GROQ_API_KEY=your_groq_api_key_here
```

4. Start WAMP server and visit:
```
http://localhost/front_design/
```

## Usage

1. Register a new account at `/register.php`
2. Login at `/login.php`
3. Access dashboard at `/user_dashboard.php`

## Database Configuration

- Host: `localhost`
- Username: `root`
- Password: (empty)
- Database: `growright_db`
