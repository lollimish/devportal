@echo off

for /f %%i in ('dir /b *.txt') do c:\progra~1\Java\jdk1.7.0_45\bin\java.exe -jar C:\webrtc\devcontent\apis\WebRTC\sequence-diagram\plantuml\plantuml.jar -tpng %%i