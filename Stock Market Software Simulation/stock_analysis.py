from Tkinter import *
class Candle:

    def __init__(self,enterDate,realName):

        f = open(realName,"r")
        self.date = enterDate
        self.f = f
        self.f.seek(0)
        day = self.f.readline()
        day = self.f.readline()
        
        sum = 0
        while  day!="":
            data = day.split(",")
            date = data[0]
            if date >= self.date:
                sum = sum + 1
            day = self.f.readline()
        self.daySum = sum

        self.f.seek(0)
        day = self.f.readline()
        day = self.f.readline()
        num = 0
        while day!="":
            data = day.split(",")
            date = data[0]
            if date <= self.date:
                num = num + 1
                day = self.f.readline()
            else : break
        self.num = num
        
        self.f.seek(0)
        day = self.f.readline()
        day = self.f.readline()
        max = 0
        min = 10000   
        while day!="":
            data = day.split(",")
            date = data[0]
            if date >= self.date:
                if eval(data[2]) > max:
                    max = eval(data[2])
                if eval(data[3]) < min:
                    min = eval(data[3])
            day = self.f.readline()
        max = "%0.2f" % (max)
        min = "%0.2f" % (min)
        self.max = max
        self.min = min

    def dayCan(self):

        self.f.seek(0)
        day=self.f.readline()
        day=self.f.readline()

        newSum = 0
        a = self.daySum % 5
        b = self.daySum / 5
        xPointList = []
        dateList = []
        greenXList = []       
        greenOList = []
        greenCList = []
        greenHList = []
        greenLList = []
        redXList = []       
        redOList = []
        redCList = []
        redHList = []
        redLList = []       
        while day!= "":
            data = day.split(",")
            date = data[0]
            if date >= self.date:
                newSum = newSum + 1
                x = float(770 - 60) * (newSum) / self.daySum + 60
                openPri = eval(data[1])
                high = eval(data[2])
                low = eval(data[3])
                close = eval(data[4])
                y1 = 420/(eval(self.max) - eval(self.min))*(eval(self.max) - openPri) + 50
                y2 = 420/(eval(self.max) - eval(self.min))*(eval(self.max) - close) + 50
                y3 = 420/(eval(self.max) - eval(self.min))*(eval(self.max) - high) + 50
                y4 = 420/(eval(self.max) - eval(self.min))*(eval(self.max) - low) + 50
                if (newSum - a) % b == 0:
                    xPointList.append(x)
                    dateList.append(date)                  
                if close <= openPri:
                    greenXList.append(x)
                    greenOList.append(y1)
                    greenCList.append(y2)
                    greenHList.append(y3)
                    greenLList.append(y4)
                if close >= openPri:
                    redXList.append(x)
                    redOList.append(y1)
                    redCList.append(y2)
                    redHList.append(y3)
                    redLList.append(y4)
            day = self.f.readline()
        return self.daySum,xPointList,dateList,greenXList,greenOList,greenCList,greenHList,greenLList,redXList,redOList,redCList,redHList,redLList
       
    def rsi(self,n):
        
        self.f.seek(0)
        day = self.f.readline()
        day = self.f.readline()
        data = day.split(",")
        num = 0
        pointList=[]
        plus = 0
        minus = 0
        sum = 0
        averPlus = 0
        averMin = 0
        close = eval(data[4])
        while day != "":
            data = day.split(",")
            num = num + 1
            newClose = eval(data[4])
            diff = newClose - close
            if diff > 0:
                plus = diff
            else:
                minus = -diff
            averPlus = averPlus*(n-1)/n - plus/n
            averMin = averMin*(n-1)/n - minus/n
            if averMin == 0:
                rs = 0
                rsi = 100
            else:
                rs = averPlus/averMin
                rsi = rs/(1+rs)*100
            if num >= self.num-1:
                sum = sum + 1
                y = float(100 - rsi)/100*120 + 500
                x = float(sum-1)/self.daySum*710 + 60
                point = (x,y)
                pointList.append(point)               
            plus = 0
            minus = 0
            close = newClose
            day = self.f.readline()
        return pointList
            
    def movAver(self,n):

        self.f.seek(0)
        day = self.f.readline()
        day = self.f.readline()
        num = 0
        sum = 0
        a = 0
        closeList = []
        pointList = []
        while day != "":
            data = day.split(",")
            close = eval(data[4])
            num = num + 1
            if num >= self.num - n:
                closeList.append(close)
            if num >= self.num-1:
                a = a + 1
                for i in range(n):
                    sum = sum + closeList[i]
                aver = sum/n
                x = float(770 - 60) * (a-1) / self.daySum + 60
                y = 420/(eval(self.max) - eval(self.min))*(eval(self.max) - aver) + 50
                if y <= 470:
                    point = (x,y)
                    pointList.append(point)
                
                del closeList[0]
                sum = 0
            day = self.f.readline()
        return pointList
      
    def corSystem(self):

        mid1 = "%0.2f" % ((eval(self.max)-eval(self.min))/5 + eval(self.min))
        mid2 = "%0.2f" % ((eval(self.max)-eval(self.min))*2/5 + eval(self.min))
        mid3 = "%0.2f" % ((eval(self.max)-eval(self.min))*3/5 + eval(self.min))
        mid4 = "%0.2f" % ((eval(self.max)-eval(self.min))*4/5 + eval(self.min))
        return mid1,mid2,mid3,mid4,self.min,self.max

root1 = Tk()
root2 = Tk()
root3 = Tk()
root2.withdraw()
root3.withdraw()
c=Canvas(root1,width=800,height=650,bg='white')
c.grid(row=0,column=0,rowspan=80)

date = "2017-12-01"
d = Candle(date,"BABA.txt")

def corSystem(d):
    mid1,mid2,mid3,mid4,min,max = d.corSystem()
    c.create_text(770,40,text='Alibaba Group Holding Limited (BABA) (to 2018-05-31)',anchor=E)
    c.create_text(55,(50+410/5),text=mid4,anchor=E )
    c.create_text(55,(50+410*2/5),text=mid3,anchor=E)
    c.create_text(55,(50+410*3/5),text=mid2,anchor=E)
    c.create_text(55,(50+410*4/5),text=mid1,anchor=E)
    c.create_text(55,470,text=min,anchor=E)
    c.create_text(55,50,text=max,anchor=E)
    c.create_text(55,500+120*30/100,text=70,anchor=E)
    c.create_text(55,500+120*70/100,text=30,anchor=E)
    c.create_text(60,40,text='Black: MA6',anchor=W)
    c.create_text(160,40,text='Orange: MA12',anchor=W)
    c.create_line(60,(50+410/5),770,(50+410/5),fill="grey",dash=(4,3))
    c.create_line(60,(50+410*2/5),770,(50+410*2/5),fill="grey",dash=(4,3))
    c.create_line(60,(50+410*3/5),770,(50+410*3/5),fill="grey",dash=(4,3))
    c.create_line(60,(50+410*4/5),770,(50+410*4/5),fill="grey",dash=(4,3))

    c.create_text(60,630,text='Blue: RSI12',anchor=W)
    c.create_text(160,630,text='Purple: RSI26',anchor=W)
    c.create_rectangle(60,500,770,620,fill="",outline="black")
    c.create_line(60,float(120)/100*30+500,770,float(120)/100*30+500,fill='grey',dash=(4,3))
    c.create_line(60,float(120)/100*70+500,770,float(120)/100*70+500,fill='grey',dash=(4,3))

def movAver(d,n,color):
    pointList = d.movAver(n)
    c.create_line(pointList,fill=color,smooth=1)

def dayCandle(d):
    daySum,xPointList,dateList,greenXList,greenOList,greenCList,greenHList,greenLList,redXList,redOList,redCList,redHList,redLList = d.dayCan()
    green = []
    red = []
    if daySum <= 50:
        a=5
    elif 50 < daySum <= 150:
        a=2
    else:
        a=1
    for i in range(len(xPointList)):
        c.create_text(xPointList[i],485,text = dateList[i][2:10])
    for i in range(len(xPointList)-1):
        c.create_line(xPointList[i],50,xPointList[i],470,fill="grey")
        c.create_line(xPointList[i],500,xPointList[i],620,fill="grey")
    for i in range(len(greenXList)):
        c.create_rectangle((greenXList[i]-a),greenOList[i],(greenXList[i]+a),greenCList[i],fill="green",outline="green")
        c.create_line(greenXList[i],greenHList[i],greenXList[i],greenLList[i],fill="green")

    for i in range(len(redXList)):
        c.create_rectangle((redXList[i]-a),redOList[i],(redXList[i]+a),redCList[i],fill="red",outline="red")
        c.create_line(redXList[i],redHList[i],redXList[i],redLList[i],fill="red")

def rsi(d,n,color):
    pointList = d.rsi(n)
    rsi = c.create_line(pointList,fill=color)
        
def draw(d):
    corSystem(d)
    dayCandle(d)
    rsi(d,12,'blue')
    rsi(d,26,'purple')
    movAver(d,6,'black')
    movAver(d,12,'orange')

def deleteLine():
    x=ALL
    c.delete(x)

def inMon(date):
    deleteLine()
    back1 = c.create_rectangle(60,50,770,470,fill="white",outline="black")
    back2 = c.create_rectangle(60,500,770,620,fill="white",outline="")
    
    d=Candle(date,'BABA.txt')
    draw(d)
    xLine1 = c.create_line(0,0,800,0,fill='black',dash=(4,3))
    xLine2 = c.create_line(0,0,800,0,fill='black',dash=(4,3))
    yLine = c.create_line(0,0,800,0,fill='black',dash=(4,3))

    def printLine(event):
        c.coords(xLine1,event.x,50,event.x,470)
        c.coords(xLine2,event.x,500,event.x,620)
        c.coords(yLine,60,event.y,770,event.y)
    
    c.tag_bind(back1,"<Enter>",printLine)
    c.tag_bind(back2,"<Enter>",printLine)

def inOneMon():
    inMon('2018-05-01')

def inThreeMon():
    inMon('2018-03-01')

def inSixMon():
    inMon('2017-12-01')

def inNineMon():
    inMon('2017-09-01')

def instruRsi():
    Label(root2,text="How to Use a RSI to Buy Stocks").grid(row=0)
    Label(root2,text=" Tops and bottoms are indicated when RSI goes above 70 or drops below 30.").grid(row=1,sticky=W)
    Label(root2,text=" Traditionally, RSI readings greater than the 70 level are considered to be in overbought territory").grid(row=2,sticky=W)
    Label(root2,text=" and RSI readings lower than the 30 level are considered to be in oversold territory.").grid(row=3,sticky=W)
    Label(root2,text=" In between the 30 and 70 level is considered neutral, with the 50 level a sign of no trend.").grid(row=4,sticky=W)
    root2.deiconify()
    def disappear():
        root2.withdraw()
    Button(root2,text='OK',command=disappear).grid(row=5)

def instruMa():
    Label(root3,text="How to Use a Moving Average to Buy Stocks").grid(row=0)
    Label(root3,text=" Crossovers are one of the main moving average strategies. ").grid(row=1,sticky=W)
    Label(root3,text=" 1.The first type is a price crossover, which is when the price crosses above or below a moving average to signal a potential change in trend.").grid(row=2,sticky=W)
    Label(root3,text=" 2.Another strategy is to apply two moving averages to a chart:one longer and one shorter.").grid(row=3,sticky=W)
    Label(root3,text=" When the shorter-term MA crosses above the longer-term MA, it's a buy signal, as it indicates that the trend is shifting up. This is known as a \"golden cross.\"").grid(row=4,sticky=W)
    Label(root3,text=" When the shorter-term MA crosses below the longer-term MA, it's a sell signal, as it indicates that the trend is shifting down. This is known as a \"dead/death cross.\"").grid(row=5,sticky=W)
    root3.deiconify()
    def disappear():
        root3.withdraw()
    Button(root3,text='OK',command=disappear).grid(row=6)

Label(root1,text='Period').grid(row=5,column=1)
Label(root1,text='Instruction').grid(row=15,column=1)
Button(root1,text="1 month",command=inOneMon).grid(row=6,column=1,columnspan=10)
Button(root1,text="3 months",command=inThreeMon).grid(row=7,column=1,columnspan=10)
Button(root1,text="6 months",command=inSixMon).grid(row=8,column=1,columnspan=10)
Button(root1,text="9 months",command=inNineMon).grid(row=9,column=1,columnspan=10)
Button(root1,text="RSI",command=instruRsi).grid(row=16,column=1)
Button(root1,text="MA",command=instruMa).grid(row=17,column=1)

inOneMon()

root1.mainloop()
root2.mainloop()
root3.mainloop()

