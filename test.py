import sys
import time
import subprocess
import string
import time
from time import gmtime, strftime


def test_log(str):
    with open("/Users/michellepai/sites/devcontent/devportal/new.txt", "a") as testlog:
        testlog.write(strftime("\n%a, %d %b %Y %H:%M:%S", gmtime()) + ": "+ str)

if __name__ == "__main__":
	lyx_sys_path =  sys.argv[1]
	lyx_file_name = sys.argv[2]
	test_log(lyx_sys_path)	
	test_log(lyx_file_name)