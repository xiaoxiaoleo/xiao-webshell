net stop winmgmt
rd /s /q C:\WINDOWS\system32\wbem\Repository
del /s /q C:\WINDOWS\system32\wbem\mof\bad
del /s /q C:\WINDOWS\system32\wbem\mof\good
net start winmgmt
pause