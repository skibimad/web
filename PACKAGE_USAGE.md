# 📦 Skibidi Madness - Laravel Package Usage Guide

This guide explains how to integrate the Skibidi Madness package into your existing Laravel application.

## Installation

### Step 1: Add the Package

Add the repository to your Laravel project's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/skibimad/web"
        }
    ],
    "require": {
        "skibimad/skibidi-madness": "dev-main"
    }
}
```

Then run:

```bash
composer update
```

### Step 2: Publish Package Assets

Publish the migrations:

```bash
php artisan vendor:publish --provider="App\Providers\SkibidiMadnessServiceProvider" --tag="skibidi-migrations"
```

Publish the public assets (images, videos, CSS, JS):

```bash
php artisan vendor:publish --provider="App\Providers\SkibidiMadnessServiceProvider" --tag="skibidi-assets"
```

Publish the configuration (optional):

```bash
php artisan vendor:publish --provider="App\Providers\SkibidiMadnessServiceProvider" --tag="skibidi-config"
```

Publish the views (optional, if you want to customize them):

```bash
php artisan vendor:publish --provider="App\Providers\SkibidiMadnessServiceProvider" --tag="skibidi-views"
```

### Step 3: Run Migrations

```bash
php artisan migrate
```

### Step 4: Seed the Database (Optional)

To populate with default heroes and episodes:

```bash
php artisan db:seed --class=Database\\Seeders\\HeroSeeder
php artisan db:seed --class=Database\\Seeders\\EpisodeSeeder
```

## Configuration

After publishing the configuration file, you can customize settings in `config/skibidi-madness.php`:

```php
return [
    'features' => [
        'heroes' => true,
        'episodes' => true,
        'blog' => true,
        'admin_panel' => true,
    ],
    
    'api' => [
        'prefix' => 'api',
        'middleware' => ['api'],
    ],
    
    'pagination' => [
        'heroes_per_page' => 10,
        'episodes_per_page' => 10,
        'blog_posts_per_page' => 10,
    ],
];
```

## Using the Package

### API Endpoints

The package automatically registers these API routes:

#### Heroes
- `GET /api/heroes` - List all heroes
- `POST /api/heroes` - Create a hero
- `GET /api/heroes/{hero}` - Get hero details
- `PUT /api/heroes/{hero}` - Update a hero
- `DELETE /api/heroes/{hero}` - Delete a hero

#### Episodes
- `GET /api/episodes` - List all episodes
- `POST /api/episodes` - Create an episode
- `GET /api/episodes/{episode}` - Get episode details
- `PUT /api/episodes/{episode}` - Update an episode
- `DELETE /api/episodes/{episode}` - Delete an episode

#### Blog Posts
- `GET /api/blog-posts` - List published posts
- `GET /api/blog-posts?all=1` - List all posts (including drafts)
- `POST /api/blog-posts` - Create a post
- `GET /api/blog-posts/{post}` - Get post details
- `PUT /api/blog-posts/{post}` - Update a post
- `DELETE /api/blog-posts/{post}` - Delete a post
- `GET /api/blog-posts-recent?limit=3` - Get recent posts

### Using Models in Your Code

```php
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;

// Get all active heroes
$heroes = Hero::where('active', true)->orderBy('order')->get();

// Get published blog posts
$posts = BlogPost::published()->latest('published_at')->get();

// Create a new episode
$episode = Episode::create([
    'title' => 'Episode 6: The Final Battle',
    'slug' => 'episode-6-the-final-battle',
    'description' => 'The epic conclusion...',
    'thumbnail' => 'res/img/episode-6.png',
    'video_url' => 'https://youtube.com/...',
    'episode_number' => 6,
    'published_at' => now(),
]);
```

### Using Views

The package provides pre-built views that you can use:

```php
// In your routes/web.php
Route::get('/skibidi', function () {
    return view('skibidi-madness::index');
});

Route::get('/skibidi/blog', function () {
    return view('skibidi-madness::blog');
});

Route::get('/skibidi/admin', function () {
    return view('skibidi-madness::admin.dashboard');
});
```

If you published the views, you can customize them in:
- `resources/views/vendor/skibidi-madness/`

### Customizing Routes

If you want to customize the routes, disable auto-discovery in your `composer.json`:

```json
{
    "extra": {
        "laravel": {
            "dont-discover": [
                "skibimad/skibidi-madness"
            ]
        }
    }
}
```

Then manually register the service provider and define your own routes.

## Frontend Integration

### Using the Admin Panel

The package includes a complete admin panel for managing content:

1. Navigate to `/admin` for the dashboard
2. `/admin/heroes` - Manage heroes
3. `/admin/episodes` - Manage episodes
4. `/admin/blog` - Manage blog posts

The admin panel uses the API endpoints and requires the published JavaScript files.

### Multi-Language Support

The frontend includes built-in support for:
- English (en)
- Spanish (es)
- French (fr)
- German (de)

Language data is stored in `public/scripts/translations.js`.

## Database Schema

### Heroes Table
- `id` - Primary key
- `name` - Hero name
- `slug` - URL slug (unique)
- `description` - Hero description
- `image_path` - Path to hero image
- `video_path` - Path to hero video
- `abilities` - JSON array of abilities
- `order` - Display order
- `active` - Active status
- `timestamps` - Created/updated timestamps

### Episodes Table
- `id` - Primary key
- `title` - Episode title
- `slug` - URL slug (unique)
- `description` - Episode description
- `thumbnail` - Thumbnail image path
- `video_url` - YouTube/video URL
- `episode_number` - Episode number (unique)
- `published_at` - Publication date
- `featured` - Featured flag
- `timestamps` - Created/updated timestamps

### Blog Posts Table
- `id` - Primary key
- `title` - Post title
- `slug` - URL slug (unique)
- `excerpt` - Short excerpt
- `content` - Full content
- `image` - Featured image path
- `author` - Author name
- `published_at` - Publication date
- `published` - Published flag
- `timestamps` - Created/updated timestamps

## Advanced Usage

### Adding Middleware to API Routes

In your `config/skibidi-madness.php`:

```php
'api' => [
    'prefix' => 'api',
    'middleware' => ['api', 'auth:sanctum'], // Add authentication
],
```

### Custom Policies

Create policies for authorization:

```php
// app/Policies/HeroPolicy.php
class HeroPolicy
{
    public function update(User $user, Hero $hero)
    {
        return $user->isAdmin();
    }
}

// In AuthServiceProvider
protected $policies = [
    Hero::class => HeroPolicy::class,
];
```

### Event Listeners

Listen to model events:

```php
// In a service provider
Hero::created(function ($hero) {
    \Log::info("New hero created: {$hero->name}");
});

BlogPost::published(function ($post) {
    // Send notification
});
```

### API Resources

Create API resources for custom responses:

```php
// app/Http/Resources/HeroResource.php
class HeroResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'abilities' => $this->abilities,
            'image_url' => asset($this->image_path),
            'video_url' => asset($this->video_path),
        ];
    }
}
```

## Troubleshooting

### Assets Not Loading

Make sure you published the assets:
```bash
php artisan vendor:publish --provider="App\Providers\SkibidiMadnessServiceProvider" --tag="skibidi-assets"
```

### Routes Not Working

Clear your route cache:
```bash
php artisan route:clear
php artisan cache:clear
```

### Database Errors

Make sure migrations are run:
```bash
php artisan migrate:status
php artisan migrate
```

## Support

- **Issues**: https://github.com/skibimad/web/issues
- **Documentation**: See README-LARAVEL.md

## License

MIT License - See LICENSE file
