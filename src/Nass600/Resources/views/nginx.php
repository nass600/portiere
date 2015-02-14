server {
    server_name <?php echo $serverName ?>;
    root <?php echo $documentRoot ?>;
    <?php $frontController = ($env == "prod") ? "app" : "app_" . $env ?>

    location / {
        try_files $uri /<?php echo $frontController ?>.php$is_args$args;
    }

    location ~ ^/(<?php echo $frontController ?>)\.php(/|$) {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS off;
        <?php if ($env === "prod") : ?>
            internal;
        <?php endif ?>
    }

    error_log <?php echo $logsDir . $errorLogfile ?>;
    access_log <?php echo $logsDir . $accessLogfile ?>;
}
