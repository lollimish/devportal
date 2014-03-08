# python ~/sites/devcontent/devportal/crafter.py 
#/Applications/LyX.app/Contents/MacOS/lyx -e xetex /Users/michellepai/Sites/devcontent/apis/template/Errors-Template.lyx

# $$s The LyX system directory (e. g. /usr/share/lyx).
# $$i The input file
# $$o The output file
# $$b The base name (without filename extension) in the LyX temporary directory
# $$p The full directory path of the LyX temporary directory
# $$r The full pathname to the original LyX file being processed
# $$f The filename (without any directory path) of the LyX file.
# $$l The `LaTeX name'
# $$s /Applications/LyX.app/Contents/Resources/lyx2lyx

# python ~/sites/devcontent/devportal/crafter.py /Applications/LyX.app/Contents/Resources/ /Users/michellepai/Sites/devcontent/apis/locker/ATT-Locker-Service.lyx
# python ~/sites/devcontent/devportal/crafter.py $$s $$i

import sys
import time
import subprocess
import string

if __name__ == "__main__":
	lyx_sys_path =  sys.argv[1]
	lyx_file_name = sys.argv[2]
	# for arg in sys.argv: 
	# 	print arg


	# subprocess.check_output([lyx_sys_path + "../MacOS/lyx", "-e", "xetex", lyx_file_name]);
	# proc_tex = subprocess.Popen([lyx_sys_path + "../MacOS/lyx", "-e", "xetex", lyx_file_name]);
	# proc_tex.wait()
	# print proc_tex.returncode

	api =  lyx_file_name.split('-')[1]


	subprocess.call(["php", "~/sites/devcontent/devportal/htmlForCrafter.php", api]);
	#see screen shot to know where i left off
