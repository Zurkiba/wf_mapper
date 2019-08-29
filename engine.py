#!/usr/bin/env python
import MySQLdb as mdb
import time
import math
db = mdb.connect('sql','user','password','table')
cur = db.cursor()
focusMaps = []
opNames = []
alert = []
cur.execute('SELECT name, leftX, rightX, bottomY, topY FROM ao')
result_set = cur.fetchall()
for row in result_set:
    opNames.append(row[0])
    focusStr = str(row[1]) + ',' + str(row[2]) + ',' + str(row[3]) + ',' + str(row[4])
    focusMaps.append(focusStr)
    alert.append(0)

cur.execute('SELECT fleetID,c1,c2,x,y,tonnage FROM intel')
result_set = cur.fetchall()
for row in result_set:
    fID = row[0]
    if row[1] != 'null':
        c1 = map(float,row[1].split(','))
    else: c1 = [0,0,0]
    if row[2] != 'null':
        c2 = map(float,row[2].split(','))
    else: c2 = [0,0,0]
    speed = 0.0
    if c2[0] != c1[0]:
        speed = float((math.sqrt(float((c2[0] - c1[0])**2 + (c2[1] - c1[1])**2 + (c2[2] - c1[2])**2)) * 4000)/1800) #km/hr
    ao = ''
    for i in range(0,len(focusMaps)):
        x,y = row[3],row[4]
        lim = map(int,focusMaps[i].split(','))
        if x > lim[0] and x < lim[1] and y > lim[2] and y < lim[3]:
            ao = opNames[i]
            if row[5] > 2: alert[i] = 1
    cur.execute('UPDATE intel SET speed=%s, c11=c10, c10=c9, c9=c8, c8=c7, c7=c6, c6=c5, c5=c4, c4=c3, c3=c2, c2=c1, c1=c0, galaxy="%s" WHERE fleetID=%s' % (speed,ao,fID))
    db.commit()
for i in range(0,len(alert)):
    if alert[i] == 1:
        cur.execute('UPDATE ao SET alert = 1 WHERE name ="' + opNames[i] + '"')
        db.commit()
    
    
