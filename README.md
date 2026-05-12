# Football Tournament Manager

Sistema de gestión de torneos de fútbol desarrollado con Laravel 11 y Eloquent ORM. El dominio modela torneos estilo FIFA World Cup y UEFA Champions League, incluyendo equipos, jugadores, partidos, goles, tarjetas y árbitros.

---

## Requisitos

- PHP 8.2 o superior
- Composer
- MySQL 8 o MariaDB 10.5+
- Laravel 11

---

## Instalación

Clonar el repositorio e instalar dependencias:

```bash
git clone https://github.com/Gotkissss/football-tournament.git
cd football-tournament
composer install
```

Copiar el archivo de entorno y generar la clave de la aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

Editar el archivo `.env` con los datos de la base de datos:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=football_tournament
DB_USERNAME=root
DB_PASSWORD=
```

---

## Base de datos

Crear la base de datos en MySQL:

```sql
CREATE DATABASE football_tournament CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Correr las migraciones:

```bash
php artisan migrate
```

Correr los seeders:

```bash
php artisan db:seed
```

O ambos en un solo comando:

```bash
php artisan migrate:fresh --seed
```

---

## Tablas

El sistema cuenta con 13 tablas:

- `confederations` — UEFA, CONMEBOL, CONCACAF, CAF, AFC, OFC
- `countries` — Países vinculados a una confederación
- `tournaments` — Mundial, Champions League, Copa América, etc.
- `stadiums` — Estadios con ciudad, aforo y coordenadas
- `teams` — Selecciones nacionales y equipos de club
- `players` — Jugadores con posición y estadísticas
- `groups` — Grupos A-H dentro de un torneo
- `group_team` — Tabla pivot con posiciones por grupo
- `matches` — Partidos con marcador, fase y estadio
- `goals` — Goles con minuto, tipo y jugador
- `cards` — Tarjetas amarillas y rojas
- `referees` — Árbitros principales, asistentes y VAR
- `match_referee` — Tabla pivot de árbitros por partido

---

## Relaciones implementadas

- `Confederation` tiene muchos `Country` y `Tournament`
- `Country` pertenece a `Confederation`, tiene muchos `Team`, `Player`, `Stadium` y `Referee`
- `Team` pertenece a `Country` y `Stadium`, tiene muchos `Player` y pertenece a muchos `Group`
- `Match` pertenece a `Tournament`, `Group`, `Team` (local y visitante) y `Stadium`, tiene muchos `Goal` y `Card`, y pertenece a muchos `Referee`
- `Player` pertenece a `Team` y `Country`, tiene muchos `Goal` y `Card`

Todas las relaciones están definidas en ambos modelos involucrados.

---

## Datos generados por el seeder

| Tabla          | Registros    |
|----------------|--------------|
| confederations | 6            |
| countries      | 48           |
| stadiums       | 120          |
| tournaments    | 20           |
| teams          | 200          |
| players        | 5,000        |
| referees       | 300          |
| groups         | 160          |
| group_team     | 640          |
| matches        | ~1,580       |
| goals          | ~3,600       |
| cards          | ~2,400       |
| match_referee  | ~4,800       |
| **Total**      | **+18,000**  |

---

## Consultas Eloquent

Las consultas de demostración se encuentran en `app/Http/Controllers/EloquentQueriesDemo.php` e incluyen:

1. Tabla de posiciones de un grupo ordenada por puntos
2. Goleadores del torneo usando `withCount` y filtros
3. Partidos de fase eliminatoria con Eager Loading para evitar el problema N+1
4. Equipos con mas tarjetas rojas usando relaciones anidadas
5. Los 5 partidos con mas goles usando `withCount` y ordenamiento
6. Jugadores sin tarjetas usando `whereDoesntHave`

El uso de Eager Loading en la consulta 3 esta justificado en comentarios dentro del archivo.
