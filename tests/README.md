# Admin Functionality Tests

This directory contains test files to verify the admin functionality.

## Running Tests

### Quick Verification Test

Run the comprehensive admin functionality verification:

```bash
php tests/verify_admin.php
```

This script will test:
1. Database connection
2. Hero model (all() method)
3. Episode model (all() method)
4. BlogPost model (all() method)
5. Analytics YouTube stats
6. Analytics Visitor stats
7. SocialLink model (enabled() method)
8. YouTubeChannel model (get() method)
9. LandingPage model (getSection() method)
10. CRUD Create operation
11. CRUD Read operation
12. CRUD Update operation
13. CRUD Delete operation

### Expected Output

```
🚀 Admin Functionality Verification
=====================================

1. Testing Database Connection... ✅ PASS
2. Testing Hero Model... ✅ PASS (Found 5 heroes)
3. Testing Episode Model... ✅ PASS (Found 5 episodes)
4. Testing BlogPost Model... ✅ PASS (Found 3 blog posts)
5. Testing Analytics YouTube Stats... ✅ PASS (Count: 0)
6. Testing Analytics Visitor Stats... ✅ PASS (Count: 0)
7. Testing SocialLink Model... ✅ PASS (Found 4 enabled social links)
8. Testing YouTubeChannel Model... ✅ PASS (Channel: FireStormX-Tri)
9. Testing LandingPage Model... ✅ PASS
10. Testing Model CRUD (Create)... ✅ PASS (Created hero ID: X)
11. Testing Model CRUD (Read)... ✅ PASS
12. Testing Model CRUD (Update)... ✅ PASS
13. Testing Model CRUD (Delete)... ✅ PASS

=====================================
Test Results:
  ✅ Passed: 13
  ❌ Failed: 0
  📊 Total:  13
=====================================
🎉 All tests passed! Admin functionality is working correctly.
```

## Manual Testing Checklist

### Authentication
- [ ] Can log in with admin/admin123
- [ ] Can log in with fsx/111111
- [ ] Cannot access admin without login
- [ ] Can log out successfully

### Heroes Management
- [ ] Can view heroes list
- [ ] Can add new hero
- [ ] Can edit hero
- [ ] Can delete hero
- [ ] Can enable/disable hero
- [ ] File uploader works for images/videos

### Episodes Management
- [ ] Can view episodes list
- [ ] Can add new episode
- [ ] Can delete episode
- [ ] Can enable/disable episode

### Blog Management
- [ ] Can view blog posts list
- [ ] Can add new blog post
- [ ] Can edit blog post
- [ ] Can delete blog post
- [ ] Can archive/unarchive post
- [ ] File uploader works for featured images

### Landing Page Editor
- [ ] Can edit Hero section
- [ ] Can edit About section
- [ ] Can edit Channel section
- [ ] Changes appear on frontend

### YouTube Channel Management
- [ ] Can edit channel name
- [ ] Can edit channel URL
- [ ] Can edit channel handle
- [ ] Can edit subscriber/video counts

### Social Links Management
- [ ] Can view social links list
- [ ] Can edit social link
- [ ] Can change display order
- [ ] Can enable/disable links
- [ ] Links appear in footer

### Analytics Dashboard
- [ ] Dashboard loads without errors
- [ ] YouTube click stats display
- [ ] Visitor stats display
- [ ] Hero/Episode/Blog counts are correct

## Troubleshooting

If tests fail:

1. **Database Connection**: Check `.env` file has correct MySQL credentials
2. **Model Errors**: Run `php migrate.php` to ensure all tables exist
3. **Analytics Errors**: Check MySQL date functions (should use DATE_SUB not datetime)
4. **CRUD Errors**: Verify Model base class has all methods implemented

## Test Coverage

✅ Database connectivity
✅ Model instantiation
✅ Active Record queries (all(), find())
✅ Custom model methods (enabled(), get(), getSection())
✅ Analytics MySQL date functions
✅ CRUD operations (Create, Read, Update, Delete)
✅ Collection classes
