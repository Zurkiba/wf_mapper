#!/usr/bin/env python
import MySQLdb as mdb
import string
import time
from bs4 import BeautifulSoup
import re
import time
db = mdb.connect('sql','user','password','table')
cur = db.cursor()
cur.execute("SELECT nInput, eInput, lastUpdate FROM input")
result_set = cur.fetchall()
fID = []
fOwn = []
fNum = []
fTon = []
fleetID = []
fleetName = []
fleetX = []
fleetY = []
fleetZ = []
fleetOwner = []
fleetNumber = []
fleetTons = []
fleetEnemy = []
for row in result_set:
    if row[2] > time.time() - 1000:
        nInput = row[0]
        eInput = row[1]
        if nInput != 'null':
            nStr = BeautifulSoup(nInput, 'html.parser')
            trFind = nStr.find_all('tr') #FINDS FOR NEUTRAL
            for i in range(0,len(trFind)):
                srchStr = nStr.find_all('tr')[i] #finds the specific tr tag
                conStr = str(nStr.find_all('tr')[i])
                if conStr[5:47] != '<td class="strong padding5 light" colspan=' and conStr[5:47] != '<td class="strongAlt padding5 light" colsp':
                    fID = str(srchStr.find_all('td')[0]) #fleet id, name, coords
                    idResult = (re.search('tfleet=' + '(.*)' + '" target=', fID))
                    idPush = int(idResult.group(1))
                    fleetID.append(idPush)
                    nameResult = (re.search('target="maingame">' + '(.*)' + '</a></strong>', fID)) #enemy has a different tag
                    namePush = str(nameResult.group(1))
                    fleetName.append(namePush)
                    xResult = (re.search('x=' + '(.*)' + '&amp;y=', fID))
                    xPush = int(xResult.group(1))
                    fleetX.append(xPush)
                    yResult = (re.search('y=' + '(.*)' + '&amp;z=', fID))
                    yPush = int(yResult.group(1))
                    fleetY.append(yPush)
                    zResult = (re.search('z=' + '(.*)' + '&amp;tpos', fID)) #might need a change when in open space
                    zPush = int(zResult.group(1))
                    fleetZ.append(zPush)
                    fOwn = str(srchStr.find_all('td')[1]) #owner
                    ownResult = (re.search('target="maingame">' + '(.*)' + '</a>', fOwn))
                    ownPush = str(ownResult.group(1))
                    fleetOwner.append(ownPush)
                    fNum = str(srchStr.find_all('td')[2]) #number
                    numResult = (re.search('tbborder">' + '(.*)' + '</td>', fNum))
                    numPush = int(numResult.group(1))
                    fleetNumber.append(numPush)
                    fTon = str(srchStr.find_all('td')[3]) #tonnage
                    tonResult = (re.search('tbborder">' + '(.*)' + '</td>', fTon))
                    tonPush = float(tonResult.group(1))
                    fleetTons.append(tonPush)
                    fleetEnemy.append(0)
        if eInput != 'null':   
            eStr = BeautifulSoup(eInput, 'html.parser')
            trFind = eStr.find_all('tr') #FINDS FOR ENEMY
            for i in range(0,len(trFind)):
                srchStr = eStr.find_all('tr')[i] #finds the specific tr tag
                conStr = str(srchStr)
                if conStr[5:47] != '<td class="strong padding5 light" colspan=' and conStr[5:47] != '<td class="strongAlt padding5 light" colsp':
                    fID = str(srchStr.find_all('td')[0]) #fleet id, name, coords
                    idResult = (re.search('tfleet=' + '(.*)' + '" target=', fID))
                    idPush = int(idResult.group(1))
                    fleetID.append(idPush)
                    nameResult = (re.search('class="enemy">' + '(.*)' + '</font></a></strong>', fID))
                    namePush = str(nameResult.group(1))
                    fleetName.append(namePush)
                    xResult = (re.search('x=' + '(.*)' + '&amp;y=', fID))
                    xPush = int(xResult.group(1))
                    fleetX.append(xPush)
                    yResult = (re.search('y=' + '(.*)' + '&amp;z=', fID))
                    yPush = int(yResult.group(1))
                    fleetY.append(yPush)
                    zResult = (re.search('z=' + '(.*)' + '&amp;tpos', fID)) #might need a change when in open space
                    zPush = int(zResult.group(1))
                    fleetZ.append(zPush)
                    fOwn = str(srchStr.find_all('td')[1]) #owner
                    ownResult = (re.search('target="maingame">' + '(.*)' + '</a>', fOwn))
                    ownPush = str(ownResult.group(1))
                    fleetOwner.append(ownPush)
                    fNum = str(srchStr.find_all('td')[2]) #number
                    numResult = (re.search('tbborder">' + '(.*)' + '</td>', fNum))
                    numPush = int(numResult.group(1))
                    fleetNumber.append(numPush)
                    fTon = str(srchStr.find_all('td')[3]) #tonnage
                    tonResult = (re.search('tbborder">' + '(.*)' + '</td>', fTon))
                    tonPush = float(tonResult.group(1))
                    fleetTons.append(tonPush)
                    fleetEnemy.append(1)
if len(fleetID)>0:
    for i in range(0,len(fleetID)):
        coords = str(fleetX[i]) + ',' + str(fleetY[i]) + ',' + str(fleetZ[i])
        cur.execute ("INSERT INTO intel (name, fleetID, owner, tonnage, size, c0, lastUpdate, enemy,x,y,speed,galaxy,c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11) VALUES ('%s',%s,'%s',%s,%s,'%s',%s,%s,%s,%s,0,'unassigned','null','null','null','null','null','null','null','null','null','null','null') ON DUPLICATE KEY UPDATE c0='%s', lastUpdate=%s, size=%s, owner='%s', tonnage=%s, x=%s, y=%s" % (fleetName[i], fleetID[i], fleetOwner[i], fleetTons[i],fleetNumber[i], coords,time.time(), fleetEnemy[i],fleetX[i],fleetY[i], coords, time.time(), fleetNumber[i], fleetOwner[i], fleetTons[i],fleetX[i],fleetY[i]))
        db.commit()
    print 'Success'
