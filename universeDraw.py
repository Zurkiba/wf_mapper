#!/usr/bin/env python
from PIL import Image, ImageDraw, ImageFont
import universe
focusMaps = '-433003,630679,-620500,630679'
mapLimit = map(int,focusMaps.split(','))
xLim, yLim = abs(mapLimit[0] - mapLimit[1]), abs(mapLimit[2] - mapLimit[3])
im = Image.new ("RGB",(int(xLim/100),int(yLim/100)),(0,0,0))
draw = ImageDraw.Draw(im)
for u in range(0,len(universe.xU)):
    draw.ellipse(((universe.xU[u]-mapLimit[0])/100,(yLim/100)-(universe.yU[u]-mapLimit[2])/100, ((universe.xU[u]-mapLimit[0])/100+10),((yLim/100)-(universe.yU[u]-mapLimit[2])/100)+10), fill=(0,255,0), outline=(0,255,0), width=3)
im.save("/home/wilhar56/vikingnauts.com/ICC/Universe.jpg")