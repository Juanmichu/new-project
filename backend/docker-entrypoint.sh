#!/bin/bash

echo "Starting Laravel application..."

# Wait for MongoDB to be ready using a simple PHP script
echo "Waiting for MongoDB to be ready..."

# Create a simple connection test script
cat > /tmp/test_mongo.php << 'EOF'
<?php
$maxAttempts = 10;
$attempt = 0;

while ($attempt < $maxAttempts) {
    try {
        $manager = new MongoDB\Driver\Manager("mongodb://app_root:1234@mongodb:27017/laraveldb");
        $command = new MongoDB\Driver\Command(['ping' => 1]);
        $result = $manager->executeCommand('laraveldb', $command);
        echo "MongoDB connection successful!\n";
        exit(0);
    } catch (Exception $e) {
        $attempt++;
        echo "Attempt $attempt/$maxAttempts - MongoDB not ready yet...\n";
        sleep(2);
    }
}

echo "Failed to connect to MongoDB after $maxAttempts attempts\n";
exit(1);
EOF

# Run the connection test
php /tmp/test_mongo.php

# Check if we should seed the database
echo "Checking database status..."

# Simple seeding approach - always try to seed but let Laravel handle duplicates
echo "Running database seeder..."
php artisan db:seed --force 2>/dev/null || echo "Seeding completed or skipped"

echo "Laravel application ready!"

# Execute the main command
exec "$@"
