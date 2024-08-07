server {
    listen 80;
    server_name your_domain_or_ip;

    root /var/www/html;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock; // Ajusta esto según tu versión de PHP
    }

    location ~ /\.ht {
        deny all;
    }
}
