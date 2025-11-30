@echo off
echo update ke GitHub dan Vercel...
git add .
git commit -m "Auto update: %date% %time%"
git push origin main
pause