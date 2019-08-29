#!/usr/bin/env python
import MySQLdb as mdb
import string
import time
from bs4 import BeautifulSoup
import re
db = mdb.connect('sql','user','password','table')
cur = db.cursor()
cur.execute("SELECT nInput FROM input WHERE name = 'Blacktusk'")
result_set = cur.fetchall()
for row in result_set:
  nInput = row[0]
  #print nInput[0:10]
  nStr = BeautifulSoup(nInput, 'html.parser')
  trFind = nStr.find_all('tr')
  for i in range(0,len(trFind)):
    srchStr = str(nStr.find_all('tr')[i]) #finds the specific tr tag
    if srchStr[5:47] != '<td class="strong padding5 light" colspan=' and srchStr[5:47] != '<td class="strongAlt padding5 light" colsp':
      print i
    #  if i <= 2:
     #   print srchStr
 #   if srchStr[5:47] != '<td class="strong padding5 light" colspan=' and srchStr[5:47] != '<td class="strongAlt padding5 light" colsp':
  #    print srchStr[5:47]
    
    