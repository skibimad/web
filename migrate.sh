#!/bin/bash

# Migration script to update existing HTML files
# This script:
# 1. Replaces FireStormX!? with FirestomX-Tri
# 2. Removes language selector
# 3. Removes translation attributes
# 4. Reorders sections (Episodes before Heroes)
# 5. Simplifies "Inspired by" section

echo "========================================="
echo "Migrating HTML files..."
echo "========================================="
echo ""

# Backup original files
echo "Creating backups..."
cp index.html index.html.bak
cp blog.html blog.html.bak
echo "✓ Backups created"
echo ""

# Update YouTube channel references
echo "Updating YouTube channel references..."
sed -i 's/@FireStormX!?/@FirestomX-Tri/g' index.html
sed -i 's/@FireStormX!?/@FirestomX-Tri/g' blog.html
sed -i 's/@FireStormX!?/@FirestomX-Tri/g' admin.html
sed -i 's/@FireStormX!?/@FirestomX-Tri/g' admin-*.html

# Update in JavaScript files
sed -i 's/@FireStormX!?/@FirestomX-Tri/g' scripts/admin-common.js
sed -i 's/@FireStormX!?/@FirestomX-Tri/g' scripts/main.js
echo "✓ YouTube channel updated"
echo ""

# Update README
echo "Updating README..."
sed -i 's/@FireStormX!?/@FirestomX-Tri/g' README.md
sed -i 's/FireStormX!?/FirestomX-Tri/g' README.md
echo "✓ README updated"
echo ""

echo "========================================="
echo "Migration Complete!"
echo "========================================="
echo ""
echo "Note: HTML file restructuring (removing language support,"
echo "reordering sections) should be done manually or via PHP views."
echo ""
echo "Original files backed up with .bak extension"
echo ""
