# Use the official PHP image as the base image
FROM php:8.3-fpm

# Copy the PHP application code
COPY . /var/www/html
