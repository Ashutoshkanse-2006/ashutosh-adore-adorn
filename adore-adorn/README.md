# Adore & Adorn (PHP + Supabase Postgres, on Vercel)
- `app/` PHP pages (served through `api/index.php`), `public/` css/js/product images, `database/` Postgres SQL
- Admin: `/admin` (default `admin` / `admin123` - change it under Admin > Password)
- Env vars: `DB_HOST`, `DB_PORT=5432`, `DB_USER`, `DB_PASS`, `DB_NAME=postgres`, `DB_SCHEMA=adore_adorn`
- `DB_HOST` may list several Supabase pooler hosts separated by commas; the first that connects is used.
- Framework Preset: Other. No build command.
