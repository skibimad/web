# Skibidi Madness Web

A custom PHP web framework for the Skibidi Madness project.

## Features

- Custom MVC architecture
- PSR-15 inspired middleware system
- Environment-based configuration
- Production-ready security defaults
- Flexible routing system

## Quick Start

### Development Setup

1. Clone the repository:
```bash
git clone https://github.com/skibimad/web.git
cd web
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment (optional):
```bash
cp .env.example .env
# Edit .env with your settings
```

4. Set up your web server to point to the `public` directory

### Environment Variables

The application uses environment variables for configuration:

- `APP_DEBUG` - Enable debug mode (true/false, default: false)
- `DB_HOST` - Database host (default: localhost)
- `DB_PORT` - Database port (default: 3306)
- `DB_USER` - Database username (default: root)
- `DB_PASSWORD` - Database password (default: empty)
- `DB_NAME` - Database name (default: skibidi_madness)

### Development Mode

To enable debug mode and error display:

```bash
export APP_DEBUG=true
```

Or set it in your web server configuration.

### Production Deployment

See [PRODUCTION.md](PRODUCTION.md) for comprehensive production deployment instructions.

## Documentation

- **[PRODUCTION.md](PRODUCTION.md)** - Production deployment guide
- **[QUICK_START.md](QUICK_START.md)** - Quick start guide for middleware system
- **[MIDDLEWARE.md](MIDDLEWARE.md)** - Complete middleware documentation
- **[MIDDLEWARE_EXAMPLES.md](MIDDLEWARE_EXAMPLES.md)** - Middleware usage examples
- **[ARCHITECTURE.md](ARCHITECTURE.md)** - System architecture diagrams
- **[IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md)** - Middleware implementation overview

## Middleware System

The framework includes a powerful middleware system with built-in middleware for:

- **Authentication** - Protect admin routes
- **Security Headers** - Add security headers to responses
- **CORS** - Handle cross-origin requests
- **Rate Limiting** - Prevent abuse
- **Logging** - Request logging for debugging

See the [QUICK_START.md](QUICK_START.md) guide for middleware usage.

## Security

### Default Security Features

- Debug mode disabled by default
- Error display disabled in production
- Security headers middleware enabled globally
- No hardcoded credentials in code
- Environment-based sensitive configuration

### Security Best Practices

1. Always use `APP_DEBUG=false` in production
2. Use strong database passwords via environment variables
3. Enable HTTPS/SSL in production
4. Keep dependencies updated
5. Review the security checklist in [PRODUCTION.md](PRODUCTION.md)

## Directory Structure

```
web/
├── bin/              # CLI tools
├── etc/              # Configuration files
│   ├── config.php    # Main configuration
│   └── config.php.example  # Configuration template
├── public/           # Web root
│   ├── index.php     # Application entry point
│   ├── css/          # Stylesheets
│   ├── js/           # JavaScript
│   └── media/        # Media files
├── src/              # Application source code
│   ├── Cli/          # CLI commands
│   ├── Controller/   # Controllers
│   ├── Core/         # Core framework classes
│   ├── Middleware/   # Middleware components
│   ├── Model/        # Models
│   └── View/         # Views
└── views/            # View templates
```

## Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Composer
- Web server (Apache/Nginx)

## License

[Add your license here]

## Contributing

[Add contribution guidelines here]
