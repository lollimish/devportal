# python watch.py 

import sys
import time
import subprocess
from watchdog.observers import Observer
from watchdog.events import LoggingEventHandler
from watchdog.events import FileSystemEventHandler
from time import gmtime, strftime

def watchdog_log(str):
    with open("watchdoglog.txt", "a") as watchdoglog:
        watchdoglog.write(strftime("\n%a, %d %b %Y %H:%M:%S", gmtime()) + ": "+ str)

def watch_apis():
    observer_api = Observer()
    observer_api.stop()
    observer_api.unschedule_all()
    api_event_handler = API_Handler()
    #get api from list
    apis = open( "../list/list.txt", "r")
    #Loop through list
    for api in apis:
        #trim
        if not str(api).startswith('#'):
            observer_api.schedule(api_event_handler, "../apis/"+api.rstrip(), recursive=False)
            watchdog_log("Starting watchdog on  apis: '" + api.rstrip()+"'.")
    apis.close()
    observer_api.start()    

def Keybreak():
    try:
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        sys.exit(0)
    observer.join()    

#Event handler that called htmlForCrafter.php
class API_Handler(FileSystemEventHandler):
    def on_modified(self, event):
        #print both dir&file
        if str(event).split("/", 6)[0] == "<DirModifiedEvent: src_path=": 
            api = str(event).split("/", 6)[6][:-1]
            subprocess.call(["php", "htmlForCrafter.php", api]);
            #if html regenerated
            watchdog_log("Generated new html files for api: '" + api + "' .")

#Event handler that monitor list file
class List_Handler(LoggingEventHandler):
    def on_modified(self, event):
        watchdog_log("List has been changed, restarting watchdog.")
        # call watch.py
        # subprocess.call(["python", "watch.py"]);
        watch_apis()

if __name__ == "__main__":
    observer_list = Observer()
    list_event_handler = List_Handler()
    watch_apis()
    #Monitor list file
    observer_list.schedule(list_event_handler, "../list", recursive=False)
    observer_list.start()
    Keybreak(test)
    
    