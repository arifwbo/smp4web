@echo off
cd /d C:\laragon\www\smpn4-samarinda

echo ============================================
echo  DAFTAR FILE YANG BERUBAH DARI COMMIT AWAL
echo ============================================
echo.

echo [1] STATUS FILE SAAT INI:
git status --short
echo.

echo [2] FILE BERUBAH SEJAK 1 AGUSTUS 2026:
git diff --name-only --diff-filter=M "main" HEAD 2>nul || git diff --name-status HEAD~20 HEAD 2>nul
echo.

echo [3] LOG 20 COMMIT TERAKHIR:
git log --oneline -20
echo.

echo [4] FILE YANG BELUM DI-COMMIT:
git diff --name-only
git diff --cached --name-only
echo.

pause
