<?php
// Memory limit check script
echo "Current memory limit: " . ini_get('memory_limit') . "\n";
echo "Peak memory usage: " . memory_get_peak_usage(true) / 1024 / 1024 . " MB\n";
echo "Current memory usage: " . memory_get_usage(true) / 1024 / 1024 . " MB\n";
echo "PHP version: " . PHP_VERSION . "\n";
