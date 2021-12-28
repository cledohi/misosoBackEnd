@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../bombayworks/zendframework1/bin/zf.sh
sh "%BIN_TARGET%" %*
