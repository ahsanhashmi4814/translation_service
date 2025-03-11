# Translation Management Service

## Overview
This project is an API-driven Translation Management Service built using **Laravel 12**. It allows storing and managing translations for multiple locales with tagging support, optimized performance, and scalability.

## Features
- Store translations for multiple locales (e.g., `en`, `fr`, `es`)
- Tag translations for context (e.g., `mobile`, `desktop`, `web`)
- CRUD operations for translations
- Search translations by tags, keys, or content
- JSON export endpoint for frontend applications
- Token-based authentication (Laravel Sanctum)
- Factory-based seeding for 100K+ records
- Optimized database queries for performance (< 200ms response time)
- Unit & Feature tests with >95% coverage
- OpenAPI/Swagger documentation

## Installation
### Prerequisites
Ensure you have the following installed:
- PHP 8.2
- MySQL 8.0
- Composer
- Laravel 12
- Laragon (or another local development environment)
- Docker (optional, for containerized setup)

### Steps
1. **Clone the repository**
   ```sh
   git clone https://github.com/your-repo/translation-service.git
   cd translation-service
   ```

2. **Install dependencies**
   ```sh
   composer install
   ```

3. **Set up environment variables**
   ```sh
   cp .env.example .env
   ```
   Update `.env` with your database and authentication configurations.

4. **Generate application key**
   ```sh
   php artisan key:generate
   ```

5. **Run database migrations**
   ```sh
   php artisan migrate --seed
   ```

6. **Serve the application**
   ```sh
   php artisan serve
   ```

## API Endpoints
### Authentication
- `POST /api/v1/register` - Register a new user
- `POST /api/v1/login` - User login & receive token
- `POST /api/v1/logout` - Logout (requires authentication)

### Translations
- `POST /api/v1/translations` - Create a new translation
- `GET /api/v1/translations` - List all translations
- `GET /api/v1/translations/{id}` - View a specific translation
- `PUT /api/v1/translations/{id}` - Update a translation
- `DELETE /api/v1/translations/{id}` - Delete a translation
- `GET /api/v1/export` - Export translations in JSON format

## Performance Optimization
- **Indexing**: Database indexed on `locale` and `tag` columns.
- **Efficient Queries**: Uses optimized SQL queries for large datasets.
- **JSON Export Optimization**: Uses chunking & caching for faster response.

## Running Tests
To run unit and feature tests:
```sh
php artisan test
```

## Swagger Documentation
To generate Swagger API documentation:
```sh
php artisan l5-swagger:generate
```
Then, access it at:
```
http://localhost:8000/api/documentation
```

## Docker Setup (Optional)
To run the application in Docker:
```sh
docker-compose up -d
```

## Contributing
Feel free to submit pull requests and open issues to improve the project.

## License
This project is licensed under the MIT License.

