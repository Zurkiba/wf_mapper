#!/usr/bin/env python
import MySQLdb as mdb
db = mdb.connect('sql','user','password','table')
cur = db.cursor()
cur.execute('UPDATE ao SET alert = 0')
db.commit()