<?php
/**
 * Admin Functionality Verification Script
 * Run this to verify all admin features are working
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

use App\Core\Database;
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;
use App\Models\Analytics;
use App\Models\SocialLink;
use App\Models\YouTubeChannel;
use App\Models\LandingPage;

echo "🚀 Admin Functionality Verification\n";
echo "=====================================\n\n";

$passed = 0;
$failed = 0;

// Test 1: Database Connection
echo "1. Testing Database Connection... ";
try {
    $db = Database::getInstance();
    echo "✅ PASS\n";
    $passed++;
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 2: Hero Model
echo "2. Testing Hero Model... ";
try {
    $heroes = Hero::all();
    $count = $heroes->count();
    echo "✅ PASS (Found $count heroes)\n";
    $passed++;
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 3: Episode Model
echo "3. Testing Episode Model... ";
try {
    $episodes = Episode::all();
    $count = $episodes->count();
    echo "✅ PASS (Found $count episodes)\n";
    $passed++;
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 4: BlogPost Model
echo "4. Testing BlogPost Model... ";
try {
    $posts = BlogPost::all();
    $count = $posts->count();
    echo "✅ PASS (Found $count blog posts)\n";
    $passed++;
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 5: Analytics - YouTube Stats
echo "5. Testing Analytics YouTube Stats... ";
try {
    $stats = Analytics::getYouTubeStats('day');
    if (isset($stats['count']) && isset($stats['period'])) {
        echo "✅ PASS (Count: {$stats['count']})\n";
        $passed++;
    } else {
        echo "❌ FAIL: Invalid response structure\n";
        $failed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 6: Analytics - Visitor Stats
echo "6. Testing Analytics Visitor Stats... ";
try {
    $stats = Analytics::getVisitorStats('week');
    if (isset($stats['count']) && isset($stats['period'])) {
        echo "✅ PASS (Count: {$stats['count']})\n";
        $passed++;
    } else {
        echo "❌ FAIL: Invalid response structure\n";
        $failed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 7: SocialLink Model
echo "7. Testing SocialLink Model... ";
try {
    $links = SocialLink::enabled();
    $count = $links->count();
    echo "✅ PASS (Found $count enabled social links)\n";
    $passed++;
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 8: YouTubeChannel Model
echo "8. Testing YouTubeChannel Model... ";
try {
    $channel = YouTubeChannel::get();
    if ($channel) {
        echo "✅ PASS (Channel: " . htmlspecialchars($channel->name ?? 'N/A') . ")\n";
        $passed++;
    } else {
        echo "⚠️  WARN: No YouTube channel configured\n";
        $passed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 9: LandingPage Model
echo "9. Testing LandingPage Model... ";
try {
    $heroSection = LandingPage::getSection('hero');
    if ($heroSection) {
        echo "✅ PASS\n";
        $passed++;
    } else {
        echo "⚠️  WARN: No hero section configured\n";
        $passed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Test 10: Model CRUD - Create
echo "10. Testing Model CRUD (Create)... ";
try {
    $testHero = new Hero();
    $testHero->name = 'Test Hero';
    $testHero->slug = 'test-hero-' . time();
    $testHero->abilities = 'Testing abilities';
    $testHero->image = '/images/test.jpg';
    $testHero->video = '/videos/test.mp4';
    $testHero->display_order = 999;
    $testHero->enabled = 1;
    
    if ($testHero->save()) {
        $testHeroId = $testHero->id;
        echo "✅ PASS (Created hero ID: $testHeroId)\n";
        $passed++;
        
        // Test 11: Model CRUD - Read
        echo "11. Testing Model CRUD (Read)... ";
        $fetchedHero = Hero::find($testHeroId);
        if ($fetchedHero && $fetchedHero->name === 'Test Hero') {
            echo "✅ PASS\n";
            $passed++;
        } else {
            echo "❌ FAIL: Could not fetch created hero\n";
            $failed++;
        }
        
        // Test 12: Model CRUD - Update
        echo "12. Testing Model CRUD (Update)... ";
        $fetchedHero->name = 'Updated Test Hero';
        if ($fetchedHero->save()) {
            $verifyUpdate = Hero::find($testHeroId);
            if ($verifyUpdate->name === 'Updated Test Hero') {
                echo "✅ PASS\n";
                $passed++;
            } else {
                echo "❌ FAIL: Update not persisted\n";
                $failed++;
            }
        } else {
            echo "❌ FAIL: Could not update hero\n";
            $failed++;
        }
        
        // Test 13: Model CRUD - Delete
        echo "13. Testing Model CRUD (Delete)... ";
        if ($fetchedHero->delete()) {
            $verifyDelete = Hero::find($testHeroId);
            if (!$verifyDelete) {
                echo "✅ PASS\n";
                $passed++;
            } else {
                echo "❌ FAIL: Hero still exists after delete\n";
                $failed++;
            }
        } else {
            echo "❌ FAIL: Could not delete hero\n";
            $failed++;
        }
    } else {
        echo "❌ FAIL: Could not create test hero\n";
        $failed++;
    }
} catch (Exception $e) {
    echo "❌ FAIL: " . $e->getMessage() . "\n";
    $failed++;
}

// Summary
echo "\n=====================================\n";
echo "Test Results:\n";
echo "  ✅ Passed: $passed\n";
echo "  ❌ Failed: $failed\n";
echo "  📊 Total:  " . ($passed + $failed) . "\n";
echo "=====================================\n";

if ($failed === 0) {
    echo "🎉 All tests passed! Admin functionality is working correctly.\n";
    exit(0);
} else {
    echo "⚠️  Some tests failed. Please review the errors above.\n";
    exit(1);
}
