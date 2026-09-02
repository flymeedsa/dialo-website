$ErrorActionPreference = 'Stop'
if (-not (Test-Path -LiteralPath '.env')) { Copy-Item -LiteralPath '.env.local.example' -Destination '.env' }
if (-not (Test-Path -LiteralPath 'database\database.sqlite')) { New-Item -ItemType File -Path 'database\database.sqlite' | Out-Null }
& .\scripts\php.ps1 artisan key:generate
& .\scripts\php.ps1 artisan migrate --seed
& 'C:\Users\بوابة جاهز\.cache\codex-runtimes\codex-primary-runtime\dependencies\bin\fallback\pnpm.cmd' install
& 'C:\Users\بوابة جاهز\.cache\codex-runtimes\codex-primary-runtime\dependencies\bin\fallback\pnpm.cmd' build
