$ErrorActionPreference = 'Stop'
$phpExecutable = (Get-Command php).Source
$extensionDirectory = Join-Path (Split-Path $phpExecutable) 'ext'
$extensions = @('openssl', 'curl', 'mbstring', 'fileinfo', 'pdo_sqlite', 'sqlite3', 'zip')
$phpArguments = @('-d', "extension_dir=$extensionDirectory")
foreach ($extension in $extensions) { $phpArguments += @('-d', "extension=$extension") }
& $phpExecutable @phpArguments @args
exit $LASTEXITCODE
