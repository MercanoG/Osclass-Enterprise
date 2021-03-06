# Osclass Enterprise
Osclass Enterprise is a fork of the Osclass v3.8.0 repository, containing many fixes and improvements (check the CHANGELOG).

> [Release Announcement](https://www.valueweb.gr/forums/osclass-enterprise-release/release-osclass-enterprise/)

## Hosting Requirements and Settings
- Apache 2.4.17+ / LiteSpeed 5.4+
- PHP 7.1 =< 7.4
- MySQL 5.7+ / MariaDB 10.2+
- MySQLi module for PHP
- GD module for PHP
- ImageMagick module for PHP (optional)

*PHP - php.ini*

```
max_execution_time = 600
allow_url_fopen = On
```

*MySQL - my.ini*

```
[mysqld]
innodb_ft_min_token_size=2
ft_min_word_len=2
```

*Permalinks on NGINX - Virtual Host Config*

```
location / {
    try_files $uri $uri/ /index.php?$args;
}
```
-If you encounter errors using the above, try replacing `$args` with `$query_string`.

## Documented Core Changes

*We now have some settings that allow us to enhance the core functionality of Osclass, as it follows:*
- In `oc-includes/osclass/UserActions.php - Line 281` and `oc-includes/osclass/controller/login.php - Line 228` we have the option to limit multiple password requests within a predefined time frame (default is 1 request per 12 hours). You can change this value to anything you like.
- In `oc-includes/osclass/classes/datatables/UsersDataTable.php - Lines 65, 135, 136` we have the option to show the user avatar in oc-admin, if an avatar plugin is used. It's set by default to the *Madhouse Avatar Plugin*, but can be changed just by modifying the function name.
- In `oc-content/themes/bender/item-sidebar.php - Line 76-86` we've added JS bot protection to the e-mail field. This code can be used by any theme.
- In `oc-admin/themes/modern/main/index.php - Line 512` we've added a new hook `osc_run_hook('main_dashboard');` that improves support for some external plugins.
- In `hUsers.php` we've added a new function `osc_user_is_online` that returns true if the user has been online in the last 5 minutes, and false otherwise.

> [Installation Guide](https://www.youtube.com/watch?v=bOr7U81Y-IM)

> Many thanks to all contributors at [MindStellar](https://www.mindstellar.com/) and [OsclassPoint](https://osclass-classifieds.com/)
