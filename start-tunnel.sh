#!/bin/bash

# localhost.run Tunnel Starter Script
# This script helps you start a localhost.run tunnel for your Laravel application

echo "=========================================="
echo "  localhost.run Tunnel Starter"
echo "=========================================="
echo ""

# Check if Laravel server is running
if ! curl -s http://localhost:8000 > /dev/null 2>&1; then
    echo "⚠️  WARNING: Laravel server doesn't seem to be running on port 8000"
    echo "   Please start it first with: php artisan serve"
    echo ""
    read -p "Continue anyway? (y/n) " -n 1 -r
    echo ""
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
else
    echo "✅ Laravel server is running on port 8000"
    echo ""
fi

echo "Starting localhost.run tunnel..."
echo "📝 Note: You'll get a new URL each time you run this"
echo "   Make sure to update your .env file with the new URL"
echo ""
echo "Press Ctrl+C to stop the tunnel"
echo "=========================================="
echo ""

# Start the tunnel
ssh -R 80:localhost:8000 localhost.run

