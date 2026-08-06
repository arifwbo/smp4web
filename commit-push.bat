@echo off
cd /d C:\laragon\www\smpn4-samarinda

echo ================================
echo  GIT COMMIT & PUSH
echo ================================
echo.

echo [1] Menambahkan semua perubahan...
git add -A

echo.
echo [2] File yang akan di-commit:
git status --short

echo.
echo [3] Melakukan commit...
git commit -m "feat: redesign UI - navbar, login, mobile menu, FAB group, JS cleanup

Perubahan yang dilakukan:
- Perbaiki foto kepala sekolah tidak tampil
- Redesign navbar: warna biru navy solid sesuai referensi
- Perbaiki topbar: background putih, teks abu gelap
- Tambah CSS mobile menu yang responsif
- Redesign halaman login: floating card premium
- Gabung tombol WhatsApp + back-to-top menjadi FAB group
- Tulis ulang custom.js: hapus duplikasi, konsolidasi semua logic
- Tulis ulang whatsapp-button.css & whatsapp-button.js
- Perbaiki kontras heading hero di halaman profil
- Update komponen whatsapp-button.blade.php"

echo.
echo [4] Push ke remote...
git push

echo.
echo ================================
echo  SELESAI!
echo ================================
pause
