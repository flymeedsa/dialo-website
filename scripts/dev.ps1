$ErrorActionPreference = 'Stop'
Write-Host 'Dialo website: http://127.0.0.1:8002'
Push-Location public
try {
    & ..\scripts\php.ps1 -S 127.0.0.1:8002 ..\vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php
} finally {
    Pop-Location
}
