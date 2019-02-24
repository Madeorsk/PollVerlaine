# PollVerlaine

A light self-hosted alternative to Straw Poll.

## Installation

Clone the repository:
```sh
mkdir db && touch db/polls.db && composer install
```

Enable the `dba` extension in `php.ini`:
```
extension=dba
```

### Configuration

Rename `config/app.example.php` to `config/app.php`.

Configure `app_url` to the root url of Poll Verlaine.

Sample configuration for nginx:
```nginx
root /path/to/PollVerlaine/webroot; # The webroot directory contains all publicly exposed files.
location /
{
    try_files $uri /index.php;
}
```

## API

See [API.md](API.md).
