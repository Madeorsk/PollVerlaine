# PollVerlaine

A small alternative to Straw Poll.

## Installation

Clone the repository :
```sh
mkdir db && touch db/polls.db && composer install
```

Uncomment the `dba` extention in `php.ini` :
```
extension=dba
```

Rename `config/app.example.php` to `config/app.php`.

Sample configuration for nginx :
```nginx
location /
{
    try_files $uri /index.php =404;
}
```

## API

See [API.md](API.md).