# FOSMessageBundle - Demo

Minimal demo [Symfony](https://symfony.com/) application with [`FriendsOfSymfony/FOSMessageBundle`](https://github.com/FriendsOfSymfony/FOSMessageBundle).

Use to test FOSMessageBundle with Symfony 6.

As you may see, right now, we used a fork of FOSMessageBundle

## Quick start

*Requirements:*

- PHP v8.1 and up
- [composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- postgresql

```bash
composer install
bin/console doctrine:database:create
bin/console doctrine:migration:migrate
bin/console doctrine:fixtures:load
symfony serve
```

## Usage
- Go to localhost:8000/login
- Log with `user@fos.fr` / `password` or `receiver@fos.fr` / `password`
- You should be redirected to `/messages` where you can try to send an email
- You have to write the email address inside recipient field so either `user@fos.fr` or `receiver@fos.fr` (you cannot send a message to yourself)