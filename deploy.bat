@echo off
echo Mengirim update ke GitHub dan Vercel...
git add .
git commit -m "Auto update: %date% %time%"
git push origin main
echo Selesai! Vercel akan deploy otomatis sebentar lagi.
pause