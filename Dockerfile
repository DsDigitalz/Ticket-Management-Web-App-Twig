# -----------------------------
# 1️⃣ Base image: PHP with Composer
# -----------------------------
FROM php:8.2-cli

# Install dependencies (like unzip for Composer)
RUN apt-get update && apt-get install -y git unzip && apt-get clean

# -----------------------------
# 2️⃣ Set working directory
# -----------------------------
WORKDIR /app

# -----------------------------
# 3️⃣ Copy Composer and install PHP dependencies
# -----------------------------
COPY composer.json composer.lock* ./
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader || true

# -----------------------------
# 4️⃣ Copy the rest of your project
# -----------------------------
COPY . .

# -----------------------------
# 5️⃣ Expose the correct port (Render and Railway use $PORT)
# -----------------------------
EXPOSE 8000

# -----------------------------
# 6️⃣ Start PHP server dynamically on assigned port
# -----------------------------
CMD php -S 0.0.0.0:${PORT:-8000} -t public
