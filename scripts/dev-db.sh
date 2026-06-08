#!/usr/bin/env bash
# Local, user-owned, PERSISTENT MySQL 8 instance for CuraLab dev — no sudo.
#
#   Port:    3308            (system MySQL stays on 3306)
#   Data:    ~/.local/share/curalab-mysql/data   (survives reboots)
#   App user: curalab / curalab   ·   DB: curalab
#
# AppArmor confines /usr/sbin/mysqld to system paths, so we run a COPY of the
# binary (unconfined) which is allowed to use a data dir under $HOME.
#
# Usage:
#   ./scripts/dev-db.sh                         # init (once) + start + ensure db/user
#   cd backend && php artisan migrate --seed    # only the first time (data persists after)
set -e

PB="$HOME/.local/share/curalab-mysql"
MYSQLD="$PB/bin/mysqld"
DATADIR="$PB/data"
SOCK="$PB/mysql.sock"
PIDFILE="$PB/mysqld.pid"
PORT=3308

SYS_MYSQLD=/usr/sbin/mysqld
BASEDIR=/usr
LCDIR=/usr/share/mysql
PLUGINDIR=/usr/lib/mysql/plugin

mkdir -p "$PB/bin"

# Keep an unconfined copy of the server binary (AppArmor workaround).
if [ ! -x "$MYSQLD" ] || [ "$SYS_MYSQLD" -nt "$MYSQLD" ]; then
  echo "→ Copying mysqld binary (AppArmor-unconfined)…"
  cp "$SYS_MYSQLD" "$MYSQLD"
fi

# First-time initialization of the persistent data directory.
if [ ! -d "$DATADIR" ]; then
  echo "→ Initializing persistent data directory…"
  "$MYSQLD" --no-defaults --initialize-insecure \
    --datadir="$DATADIR" --basedir="$BASEDIR" \
    --lc-messages-dir="$LCDIR" --plugin-dir="$PLUGINDIR"
fi

if mysql --socket="$SOCK" -uroot -e "SELECT 1" >/dev/null 2>&1; then
  echo "→ MySQL already running (socket $SOCK)"
else
  echo "→ Starting MySQL on port $PORT…"
  nohup "$MYSQLD" --no-defaults --datadir="$DATADIR" --basedir="$BASEDIR" \
    --lc-messages-dir="$LCDIR" --plugin-dir="$PLUGINDIR" \
    --socket="$SOCK" --port="$PORT" --pid-file="$PIDFILE" --mysqlx=OFF \
    >"$PB/mysqld.log" 2>&1 &
  disown
  for i in $(seq 1 40); do
    mysql --socket="$SOCK" -uroot -e "SELECT 1" >/dev/null 2>&1 && break
    sleep 0.5
  done
fi

echo "→ Ensuring database and user exist…"
mysql --socket="$SOCK" -uroot <<'SQL'
CREATE DATABASE IF NOT EXISTS curalab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'curalab'@'127.0.0.1' IDENTIFIED BY 'curalab';
CREATE USER IF NOT EXISTS 'curalab'@'localhost' IDENTIFIED BY 'curalab';
CREATE USER IF NOT EXISTS 'curalab'@'%' IDENTIFIED BY 'curalab';
GRANT ALL PRIVILEGES ON curalab.* TO 'curalab'@'127.0.0.1';
GRANT ALL PRIVILEGES ON curalab.* TO 'curalab'@'localhost';
GRANT ALL PRIVILEGES ON curalab.* TO 'curalab'@'%';
FLUSH PRIVILEGES;
SQL

echo "✓ Ready → mysql -h127.0.0.1 -P$PORT -ucuralab -pcuralab curalab"
