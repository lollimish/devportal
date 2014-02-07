To generates all the files in the file structure:

	php htmlForCrafter.php <APIname>

	example:
	php htmlForCrafter.php locker

To generate specific introduction section

	php parse_introduction.php <input file.tex> <output file.html>
	
	example:
	php parse_introduction.php ../apis/webrtc/ATT_Service_Spec_WebRTC-Specification.tex html/intro.html


To generate specific oath section

	php parse_oauth.php <input file.tex> <output file.html>

	example:
	php parse_oauth.php ../apis/locker/ATT-Locker-Service-Specification.tex html/oauth.html

To generate specific operation section

	php parse_operation.php <input file.tex> <output file.html>	
	example:
	php parse_operation.php ../apis/locker/Operation-Add_Files_To_Folder.tex html/op.html
	
	
To generate each input, output, object section

	php parse_paramtable.php <input file.tex> <output file.html>
	
	example:
	php parse_paramtable.php ../apis/locker/InputParam-Add_Tracks_To_Playlist.tex html/param.html
	
	
	