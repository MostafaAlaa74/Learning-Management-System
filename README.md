# Learning Management System (LMS) API

A robust, scalable RESTful API for a modern Learning Management System built with Laravel. This API provides comprehensive functionality for online education platforms, including course management, user enrollment, progress tracking, and secure authentication.

## 🚀 Features

### 🔐 Authentication & Security
- **JWT-based Authentication** using Laravel Sanctum
- **Role-based Access Control** (Student, Instructor, Admin)
- **Secure password management** with change password functionality
- **Rate limiting** on authentication endpoints

### 📖 Course Management
- **Full CRUD operations** for courses and lessons
- **Nested resources** for intuitive course-lesson relationships
- **Search functionality** to find courses by keywords
- **Structured content organization**

### 👥 User Management
- **User registration and profile management**
- **Course enrollment system**
- **Progress tracking** for completed lessons
- **Role-based permissions** for different user types

### 📁 File Handling
- **Multi-file upload support** for lesson attachments
- **Video content management** for lesson videos
- **File type validation** for security

## 🛠 Technology Stack

- **PHP 8.1+** with Laravel 10+
- **Laravel Sanctum** for API authentication
- **MySQL/PostgreSQL** database
- **Eloquent ORM** for database operations
- **API Resource** transformations
- **File Storage** integration

## 📦 Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd lms-api
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_db
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations:
```bash
php artisan migrate
```

6. Install Sanctum:
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

## 📚 API Endpoints

### Authentication Routes
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/register` | Register a new user |
| POST | `/api/auth/login` | User login |
| POST | `/api/auth/logout` | User logout (authenticated) |
| POST | `/api/auth/reset-password` | Reset password |

### Course Routes
| Method | Endpoint | Description | Access |
|--------|----------|-------------|--------|
| GET | `/api/courses` | List all courses | Public |
| POST | `/api/courses` | Create a new course | Instructor |
| GET | `/api/courses/{id}` | Get course details | Public |
| PUT | `/api/courses/{id}` | Update course | Instructor |
| DELETE | `/api/courses/{id}` | Delete course | Instructor |
| GET | `/api/courses/search/{keyword}` | Search courses | Public |

### Lesson Routes
| Method | Endpoint | Description | Access |
|--------|----------|-------------|--------|
| GET | `/api/courses/{course}/lessons` | Get course lessons | Public |
| POST | `/api/courses/{course}/lessons` | Create lesson | Instructor |
| GET | `/api/lessons/{id}` | Get lesson details | Public |
| PUT | `/api/lessons/{id}` | Update lesson | Instructor |
| DELETE | `/api/lessons/{id}` | Delete lesson | Instructor |


## 🔐 Authentication

All protected endpoints require an authentication token in the header:

```http
Authorization: Bearer {api_token}
```

### Registration Example
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login Example
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

## 🗄 Database Structure

### Key Tables
- **users** - User accounts and profiles
- **courses** - Course information
- **lessons** - Lesson content
- **enrollments** - Course enrollments

### Relationships
- Users can enroll in multiple courses (Many-to-Many)
- Courses contain multiple lessons (One-to-Many)
- Users can complete multiple lessons (Many-to-Many)

## 🔮 Future Enhancements

- [ ] WebSocket integration for real-time notifications
- [ ] Video streaming with adaptive bitrate
- [ ] Mobile app support
- [ ] Gamification elements (badges, points)
- [ ] Third-party integrations (Zoom, Google Classroom)
- [ ] Advanced analytics and reporting
- [ ] Certificate generation
- [ ] Discussion forums and chat

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

**Note**: This API is currently in active development. Some features may change or be added in future versions. Always check the release notes for updates.
