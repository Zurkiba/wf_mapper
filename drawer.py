#!/usr/bin/env python
from PIL import Image, ImageDraw, ImageFont
import MySQLdb as mdb
import universe
db = mdb.connect('sql','user','password','table')
cur = db.cursor()
#https://pillow.readthedocs.io/en/5.3.x/reference/ImageDraw.html?highlight=draw

colFont = ImageFont.load_default()
focusMaps = []
opNames = []
mapMag = []

cur.execute('SELECT name, leftX, rightX, bottomY, topY, scale FROM ao')
result_set = cur.fetchall()
for row in result_set:
    opNames.append(row[0])
    mapMag.append(row[5])
    focusStr = str(row[1]) + ',' + str(row[2]) + ',' + str(row[3]) + ',' + str(row[4])
    focusMaps.append(focusStr)
    
            

#xLeft,xRight,yBot,yTop
#focusMaps = ['397892,576958,76870,299062', #Iota
 #            '-69511,-16253,-281088,-59895', #Ironclad AO
  #           '20514,74056,160000,367000', #Bronco AO
   #          '79818,283630,-71552,-18174', #Keystone AO
    #         '-91470,93481,376021,539031', #Torchlight AO
     #        '43530,83530,439031,489030', #Khan's Landing AO
      #       '195020,436878,273884,531579', #Corkscrew
       #      '-49938,-39938,478348,486348' #Lamplight
        #     ]
#opNames = ['Home','Ironclad','Bronco','Keystone','Torchlight','KhansLanding','Corkscrew','Lamplight']
#mapMag = [50,50,50,50,50,15,50,25]
    
for i in range(0,len(focusMaps)):
    mapLimit = map(int,focusMaps[i].split(','))
    xLim, yLim = abs(mapLimit[0] - mapLimit[1]), abs(mapLimit[2] - mapLimit[3])
    im = Image.new ("RGB",(int(xLim/mapMag[i]),int(yLim/mapMag[i])),(0,0,0))
    draw = ImageDraw.Draw(im) #draw.text, draw.multiline_text draw.line, draw.ellipse, draw.point
   
    for u in range(0,len(universe.xU)):
        if universe.xU[u] > mapLimit[0] and universe.xU[u] < mapLimit[1] and universe.yU[u] > mapLimit[2] and universe.yU[u] < mapLimit[3]:
            draw.ellipse(((universe.xU[u]-mapLimit[0])/mapMag[i],(yLim/mapMag[i])-(universe.yU[u]-mapLimit[2])/mapMag[i], ((universe.xU[u]-mapLimit[0])/mapMag[i]+10),((yLim/mapMag[i])-(universe.yU[u]-mapLimit[2])/mapMag[i])+10), fill=(1,50,32), outline=(1,50,32), width=3)
        

    for g in range(0,xLim/100):
        draw.line((100*g,0,100*g,yLim),fill=(117,204,114),width=1)
        draw.text((100*g+5,0), str(mapLimit[0] + g * mapMag[i] * 100), (117,204,114), font=colFont)
    for r in range(0,yLim/100):
        draw.line((0,100*r,xLim,100*r),fill=(117,204,114),width=1)
        draw.text((0,100*r+5), str(mapLimit[3] - r * mapMag[i] * 100), (117,204,114), font=colFont)
    
    
    cur.execute('SELECT name,faction,x,y FROM colonies WHERE x>%s AND x<%s AND y>%s AND y<%s' %(int(mapLimit[0]),int(mapLimit[1]),int(mapLimit[2]),int(mapLimit[3])))
    result_set = cur.fetchall()
    for row in result_set:
        draw.ellipse(((row[2]-mapLimit[0])/mapMag[i],(yLim/mapMag[i])-(row[3]-mapLimit[2])/mapMag[i], ((row[2]-mapLimit[0])/mapMag[i]+10),((yLim/mapMag[i])-(row[3]-mapLimit[2])/mapMag[i])+10), fill=(255,255,255), outline=(255,255,255), width=3)
        draw.text(((row[2]-mapLimit[0])/mapMag[i]+11, (yLim/mapMag[i])-(row[3]-mapLimit[2])/mapMag[i]+11), row[0],(255,255,255), font=colFont)
        draw.text(((row[2]-mapLimit[0])/mapMag[i]+11,(yLim/mapMag[i])-(row[3]-mapLimit[2])/mapMag[i]+21),row[1],(255,255,255), font=colFont)
    
    cur.execute('SELECT name,enemy,x,y,size,c0,c1,c2,c3,c4,c5 FROM intel WHERE x>%s AND x<%s AND y>%s AND y<%s AND speed>0' %(int(mapLimit[0]),int(mapLimit[1]),int(mapLimit[2]),int(mapLimit[3])))
    result_set = cur.fetchall()
    for row in result_set:
        if row[1] == 0: cMod = 255
        elif row[1] == 1: cMod = 0
        draw.ellipse(((row[2]-mapLimit[0])/mapMag[i],(yLim/mapMag[i])-(row[3]-mapLimit[2])/mapMag[i], ((row[2]-mapLimit[0])/mapMag[i]+3),((yLim/mapMag[i])-(row[3]-mapLimit[2])/mapMag[i])+3), fill=(255,cMod,0), outline=(255,cMod,0), width=1)
        draw.text(((row[2]-mapLimit[0])/mapMag[i]+5, (yLim/mapMag[i])-(row[3]-mapLimit[2])/mapMag[i]+5), row[0],(255,cMod,0), font=colFont)
        if row[5] != 'null': c0 = map(int,row[5].split(','))
        if row[6] != 'null':
            c1 = map(int,row[6].split(','))
            draw.line((((c1[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c1[1]-mapLimit[2])/mapMag[i],(c0[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c0[1]-mapLimit[2])/mapMag[i])),fill=(255,cMod,0), width=1) #x,y,x,y
        if row[7] != 'null':
            c2 = map(int,row[7].split(','))
            draw.line((((c1[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c1[1]-mapLimit[2])/mapMag[i],(c2[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c2[1]-mapLimit[2])/mapMag[i])),fill=(255,cMod,0), width=1)
        if row[8] != 'null':
            c3 = map(int,row[8].split(','))
            draw.line((((c3[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c3[1]-mapLimit[2])/mapMag[i],(c2[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c2[1]-mapLimit[2])/mapMag[i])),fill=(255,cMod,0), width=1)
        if row[9] != 'null':
            c4 = map(int,row[9].split(','))
            draw.line((((c3[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c3[1]-mapLimit[2])/mapMag[i],(c4[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c4[1]-mapLimit[2])/mapMag[i])),fill=(255,cMod,0), width=1)
        if row[10] != 'null':
            c5 = map(int,row[10].split(','))
            draw.line((((c5[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c5[1]-mapLimit[2])/mapMag[i],(c4[0]-mapLimit[0])/mapMag[i], (yLim/mapMag[i])-(c4[1]-mapLimit[2])/mapMag[i])),fill=(255,cMod,0), width=1)
        
    
    cur.execute('SELECT name,enemy,x,y,c0,tonnage FROM intel WHERE x>%s AND x<%s AND y>%s AND y<%s AND speed=0' %(int(mapLimit[0]),int(mapLimit[1]),int(mapLimit[2]),int(mapLimit[3])))
    idle = cur.fetchall()
    for r in idle:
        if r[1] == 0: cMod = 255
        elif r[1] == 1: cMod = 0
        if r[5] >= 2:
            draw.ellipse(((r[2]-mapLimit[0])/mapMag[i],(yLim/mapMag[i])-(r[3]-mapLimit[2])/mapMag[i], ((r[2]-mapLimit[0])/mapMag[i]+3),((yLim/mapMag[i])-(r[3]-mapLimit[2])/mapMag[i])+3), fill=(255,0,cMod), outline=(255,0,cMod), width=1)
            draw.text(((r[2]-mapLimit[0])/mapMag[i]+5, (yLim/mapMag[i])-(r[3]-mapLimit[2])/mapMag[i]+5), str(r[0] + ' LKL'),(255,0,cMod), font=colFont)
            draw.text(((r[2]-mapLimit[0])/mapMag[i]+5, (yLim/mapMag[i])-(r[3]-mapLimit[2])/mapMag[i]+15), r[4],(255,0,cMod), font=colFont)
        elif r[5] < 2:
            draw.ellipse(((r[2]-mapLimit[0])/mapMag[i],(yLim/mapMag[i])-(r[3]-mapLimit[2])/mapMag[i], ((r[2]-mapLimit[0])/mapMag[i]+3),((yLim/mapMag[i])-(r[3]-mapLimit[2])/mapMag[i])+3), fill=(255,0,cMod), outline=(255,0,cMod), width=1)
    im.save("/home/wilhar56/vikingnauts.com/ICC/"+str(opNames[i])+".png")
    


#draw.line((100,200,150,300),fill=128,width=3)
