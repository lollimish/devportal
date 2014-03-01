# python ~/sites/devcontent/devportal/uploadToCrafter.py
import time
from selenium import webdriver
from selenium.webdriver.common.action_chains import ActionChains

driver = webdriver.Firefox()
driver.get('http://ecomstgdvc03.cingular.com:8080/share')

driver.find_element_by_id('username').send_keys('mp748d')
driver.find_element_by_id('password').send_keys('Hrh106196$')

driver.find_element_by_id('btn-login').click()

# driver.get('http://ecomstgdvc03.cingular.com:8080/share/page/site/developer/dashboard')





# 
# From repo
time.sleep(1)
driver.get('http://ecomstgdvc03.cingular.com:8080/share/page/repository#filter=path%7C%2Fwem-projects%2Fdeveloper%2Fdeveloper%2Fwork-area%2Fsite%2Fcomponents%2Fcontent%2Fdocument%2FAPIDocs%2Ferrors&page=1')
# time.sleep(5)
# driver.find_element_by_xpath("//input[@name='fileChecked']").click()
# time.sleep(1)
# btn_selected_items = driver.find_element_by_id("template_x002e_toolbar_x002e_repository_x0023_default-selectedItems-button-button")
# # hover = ActionChains(driver).move_to_element(btn_selected_items)
# # hover.perform()

# btn_selected_items.click()
# time.sleep(1)
# driver.find_element_by_class_name('onActionCopyTo').click()
# time.sleep(1)
# btn_copy = driver.find_element_by_id("template_x002e_toolbar_x002e_repository_x0023_default-copyMoveTo-ok-button")
# btn_copy.click()
# btn_copy.click()



# driver.quit()