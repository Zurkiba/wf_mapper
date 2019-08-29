#!/usr/bin/env python
import MySQLdb as mdb
import time
currTime = time.time()
db = mdb.connect('sql','user','password','table')
cur = db.cursor()
cur.execute('SELECT lastUpdate, fleetID FROM intel WHERE lastUpdate < ' + str(currTime - 86400))
result_set = cur.fetchall()
for row in result_set:
    cur.execute('DELETE FROM intel WHERE fleetID =' + str(row[1]))
    db.commit()
