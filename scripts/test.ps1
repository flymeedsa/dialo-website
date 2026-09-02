$ErrorActionPreference = 'Stop'
& .\scripts\php.ps1 artisan test
if ($LASTEXITCODE -ne 0) { exit $LASTEXITCODE }
& 'C:\Users\بوابة جاهز\.cache\codex-runtimes\codex-primary-runtime\dependencies\bin\fallback\pnpm.cmd' build
exit $LASTEXITCODE
