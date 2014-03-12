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
# python /Users/michellepai/sites/devcontent/devportal/crafter.py /Applications/LyX.app/Contents/Resources/ /Users/michellepai/Sites/devcontent/apis/locker/ATT-Locker-Service.lyx
# python crafter.py ATT-Locker-Service-Specification.tex
import sys
import time
import subprocess
import string
import time
from time import gmtime, strftime

def test_log(str):
    with open("/Users/michellepai/sites/devcontent/devportal/text.txt", "a") as testlog:
        testlog.write(strftime("\n%a, %d %b %Y %H:%M:%S", gmtime()) + ": "+ str)

if __name__ == "__main__":
	lyx_file_name = sys.argv[1]
	# lyx_sys_path =  sys.argv[2]
	# for arg in sys.argv: 
	# 	print arg


	# subprocess.check_output([lyx_sys_path + "../MacOS/lyx", "-e", "xetex", lyx_file_name]);
	# proc_tex = subprocess.Popen([lyx_sys_path + "../MacOS/lyx", "-e", "xetex", lyx_file_name]);
	# proc_tex.wait()
	# print proc_tex.returncode

	api =  lyx_file_name.split('-')[1].lower()
	test_log(api)
	subprocess.call(["php", "/Users/michellepai/sites/devcontent/devportal/htmlForCrafter.php", api],)

	# with open("phplog.txt","a") as out, open("phperr.txt","a") as err:
	#     subprocess.Popen(["php", "/Users/michellepai/sites/devcontent/devportal/htmlForCrafter.php", api],stdout=out,stderr=err)

