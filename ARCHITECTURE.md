# Middleware System Architecture

## Visual Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                       Incoming HTTP Request                      │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
                    ┌────────────────┐
                    │   App::run()   │
                    └────────┬───────┘
                             │
                             ▼
              ┌──────────────────────────┐
              │  Global Middleware Stack │
              │  (from config.php)       │
              ├──────────────────────────┤
              │ SecurityHeadersMiddleware│
              │ LoggingMiddleware        │
              └────────────┬─────────────┘
                           │
                           ▼
              ┌──────────────────────────┐
              │   MiddlewarePipeline     │
              │   processes each in      │
              │   sequential order       │
              └────────────┬─────────────┘
                           │
                           ▼
              ┌──────────────────────────┐
              │  Router::handle()        │
              │  - Parse route           │
              │  - Determine group       │
              └────────────┬─────────────┘
                           │
                           ▼
         ┌─────────────────┴─────────────────┐
         │                                   │
         ▼                                   ▼
┌────────────────────┐            ┌──────────────────┐
│  Admin Routes      │            │ Frontend Routes  │
│  /admin/*          │            │ Other routes     │
├────────────────────┤            ├──────────────────┤
│ Admin Middleware   │            │ Frontend         │
│ Group              │            │ Middleware Group │
├────────────────────┤            ├──────────────────┤
│ • AuthMiddleware   │            │ • CorsMiddleware │
└────────┬───────────┘            └────────┬─────────┘
         │                                 │
         └─────────────┬───────────────────┘
                       │
                       ▼
         ┌─────────────────────────────┐
         │  Controller Instantiation   │
         │  - registerMiddleware()     │
         │  - Add controller-specific  │
         │    middleware               │
         └──────────────┬──────────────┘
                        │
                        ▼
         ┌──────────────────────────────┐
         │  Controller Middleware Stack │
         │  (if any)                    │
         ├──────────────────────────────┤
         │  • RateLimitMiddleware       │
         │  • CustomMiddleware          │
         └──────────────┬───────────────┘
                        │
                        ▼
         ┌──────────────────────────────┐
         │  Controller::handle()        │
         │  - Execute controller logic  │
         │  - Render view / Send response│
         └──────────────────────────────┘
```

## Request Flow Example: /admin/dashboard

```
HTTP GET /admin/dashboard
    ↓
1. App::run()
    ↓
2. Global Middleware Pipeline
   ├─ SecurityHeadersMiddleware → Adds security headers
   └─ LoggingMiddleware → Logs request
    ↓
3. Router::handle()
   ├─ Parses route: /admin/dashboard
   └─ Detects "admin" group
    ↓
4. Admin Middleware Group
   └─ AuthMiddleware → Checks authentication
       ├─ If not authenticated: Redirect to /auth/login
       └─ If authenticated: Continue
    ↓
5. Controller::executeWithMiddleware()
   └─ [No controller-specific middleware]
    ↓
6. DashboardController::handle()
   └─ Render admin/dashboard view
    ↓
Response sent to client
```

## Request Flow Example: /api/data

```
HTTP GET /api/data
    ↓
1. App::run()
    ↓
2. Global Middleware Pipeline
   ├─ SecurityHeadersMiddleware → Adds security headers
   └─ LoggingMiddleware → Logs request
    ↓
3. Router::handle()
   ├─ Parses route: /api/data
   └─ Detects "frontend" group (or custom "api" if configured)
    ↓
4. Frontend Middleware Group
   └─ CorsMiddleware → Adds CORS headers
    ↓
5. Controller::executeWithMiddleware()
   └─ RateLimitMiddleware → Check rate limits
       ├─ If exceeded: Return 429 Too Many Requests
       └─ If OK: Continue
    ↓
6. DataController::handle()
   └─ Return JSON response
    ↓
Response sent to client
```

## Class Relationships

```
┌──────────────────────────┐
│  MiddlewareInterface     │
│  ────────────────────    │
│  + process(Request,      │
│    RequestHandler)       │
└────────────▲─────────────┘
             │
             │ implements
             │
    ┌────────┴─────────────────────────────────┐
    │                                           │
┌───┴────────────────┐              ┌──────────┴──────────┐
│  AuthMiddleware    │              │ LoggingMiddleware   │
├────────────────────┤              ├─────────────────────┤
│  CorsMiddleware    │              │ SecurityHeaders     │
└────────────────────┘              └─────────────────────┘


┌────────────────────────────┐
│ RequestHandlerInterface    │
│ ──────────────────────     │
│ + handle(Request)          │
└──────────▲─────────────────┘
           │
           │ implements
           │
    ┌──────┴──────────┐
    │                 │
┌───┴──────────┐  ┌──┴──────────────┐
│  Router      │  │ Middleware      │
│              │  │ Pipeline        │
└──────────────┘  └─────────────────┘


┌──────────────────────────┐
│  Controller              │
├──────────────────────────┤
│ - middleware[]           │
├──────────────────────────┤
│ + registerMiddleware()   │
│ + addMiddleware()        │
│ + executeWithMiddleware()│
└──────────────────────────┘
           ▲
           │ extends
           │
    ┌──────┴──────────┐
    │                 │
┌───┴──────────┐  ┌──┴──────────────┐
│AdminController│  │ Index          │
│              │  │ Controller      │
└──────────────┘  └─────────────────┘
```

## Configuration Structure

```
config/config.php
│
├─ 'middleware' => [
│   │
│   ├─ 'global' => [
│   │   ├─ SecurityHeadersMiddleware::class
│   │   └─ LoggingMiddleware::class
│   │   ]
│   │
│   └─ 'groups' => [
│       │
│       ├─ 'admin' => [
│       │   └─ AuthMiddleware::class
│       │   ]
│       │
│       └─ 'frontend' => [
│           └─ CorsMiddleware::class
│           ]
│       ]
│   ]
```

## Middleware Execution Order

```
Priority 1: GLOBAL
    ↓
Priority 2: GROUP (based on route)
    ↓
Priority 3: CONTROLLER
    ↓
CONTROLLER ACTION
```

Within each priority level, middleware executes in registration order:

```
Example:
global: [Security, Logging]
admin:  [Auth]
controller: [RateLimit, Custom]

Execution Order:
1. Security
2. Logging
3. Auth
4. RateLimit
5. Custom
6. Controller::handle()
```

## Key Design Principles

1. **Separation of Concerns**
   - Each middleware handles one specific task
   - Controllers focus on business logic
   - Routing handles request dispatching

2. **Flexibility**
   - Global middleware for cross-cutting concerns
   - Groups for area-specific concerns
   - Controller middleware for specific needs

3. **Extensibility**
   - Easy to add new middleware
   - No modification to core framework needed
   - Implements standard PSR-15 patterns

4. **Backward Compatibility**
   - Existing code works without changes
   - Middleware is opt-in
   - Legacy auth mechanisms still work

5. **Performance**
   - Middleware only created when needed
   - Pipeline stops if middleware terminates early
   - No unnecessary processing
