#!/usr/bin/env python
import MySQLdb as mdb
import string
import time
from requests import session
from bs4 import BeautifulSoup
from datetime import datetime as dt
loginURL = 'http://www.war-facts.com/extras/login.php'
url = 'http://www.war-facts.com/sensorArray.php?pingScanners=true&filterR='
db = mdb.connect('sql','user','password','table')
cur = db.cursor()
cur.execute("SELECT user, pass,grp FROM accounts")
result_set = cur.fetchall()
encryptKey = ['b76','d75','f74','h73','j72','l71','n70','p69','r68','t67','v66','v87','x65','x86','z64','z85','a63','a84','d62','d83','e61','e82',
              'h60','h81','i59','i80','j58','j79','g57','g78','f56','f77','c55','c76','b54','b75','y53','y74','w52','w73','u51','u72','s50','s71','q49','q70',
              'o48','o69','m47','m68','k46','k67','i45','i66','g44','g65','e43','e64','c42','c63','a41','a62','o36','j11']
decryptKey = ['0','1','2','3','4','5','6','7','8','9','a','A','b','B','c','C','d','D','e','E','f','F',
              'g','G','h','H','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','q','Q','r','R',
              's','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z','!','@']
if dt.now().minute < 28:
    grp = 0
    print dt.now().minute
elif dt.now().minute >= 28:
    grp = 1
    print dt.now().minute
for row in result_set:
    if row[2] == grp:
        hashedUsr = row[0]
        user = ''
        i = 0
        while i < len(hashedUsr):
            key = encryptKey.index(hashedUsr[i:(i+3)])
            user += decryptKey[key]
            i += 3
        hashedPass = row[1]
        pswd = ''
        i = 0
        while i < len(hashedPass):
            key = encryptKey.index(hashedPass[i:(i+3)])
            pswd += decryptKey[key]
            i += 3
        login = {
            'action':'login',
            'user': user,
            'pass': pswd
        }
        with session() as c:
            c.post(loginURL,data=login)
            pullEnemy = c.get(url + 'enemy')
            pullNeutral = c.get(url + 'neutral')
        pullEnemy = BeautifulSoup(pullEnemy.text, 'html.parser')
        if len(pullEnemy.find_all('table')) > 2: pushEnemy = str(pullEnemy.find_all('table')[1])
        else: pushEnemy = "'"
        pushE = pushEnemy.replace("'",".")
        pushE = pushE[2603:]
        if len(pushE) < 40: pushE = 'null'
        pullNeutral = BeautifulSoup(pullNeutral.text, 'html.parser')
        if len(pullNeutral.find_all('table')) > 2: pushNeutral = str(pullNeutral.find_all('table')[1])
        else: pushNeutral = "'"
        pushN = pushNeutral.replace("'",".")
        pushN = pushN[2603:]
        if len(pushN) < 40: pushN = 'null'
        print user
        cur.execute ("UPDATE input SET nInput='%s',eInput='%s',lastUpdate=%s WHERE name='%s'" % (pushN,pushE,time.time(),user))
        db.commit()


