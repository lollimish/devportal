$configFiles=get-childitem . *.lyx -rec
foreach ($file in $configFiles)
{
 echo $file
(Get-Content $file.PSPath) | 
Foreach-Object {$_ -replace "\/callmanagement\/", "/"} | 
Set-Content $file.PSPath
}
