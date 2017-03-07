server {
    server_name <?php echo $vhost->getServerName() ?>;
    root <?php echo $vhost->getDocumentRoot() ?>;

    location / {
        try_files $uri /app.php$is_args$args;
    }

    <?php if ($vhost->getEnv() === 'dev') : ?>
    location ~ ^/(app_dev|config)\.php(/|$) {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    <?php endif ?>
    location ~ ^/app\.php(/|$) {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS off;
        internal;
    }

    location ~ \.php$ {
        return 404;
    }

    error_log <?php echo $server['logsDir'].$vhost->getErrorLogFilename() ?>;
    access_log <?php echo $server['logsDir'].$vhost->getAccessLogFilename() ?>;
}
