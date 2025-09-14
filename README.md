# Your Car Your Way - Realtime Chat PoC

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up --wait` to start the containers
4. Run `docker compose exec php bin/console d:m:m -n` to initialize the database schema
5. Run `docker compose exec php bin/console d:f:l -n` to load the demo user (support@yourcaryourway.com / abcd1234)
6. Visit `https://localhost/register` to create a second user
7. Visit `https://localhost/chat` in two different browsers to test the chat
8. Run `docker compose down --remove-orphans` to stop the Docker containers.

## Technical components

- Based on the [Symony Docker](https://github.com/dunglas/symfony-docker) installer
- Server: FrankenPHP
- Realtime module: Mercure
- Framework: Symfony
- Database: PostgreSQL
- Frontend: Symfony UX - Stimulus/Turbo + Bootstrap
