library(fmsb)
MyData <- data.frame(Name = c('诸葛亮','张飞','赵云'), 
                     Attack=c(5,100,90),
                     Defense=c(5,80,95),
                     Witchcraft = c(100,0,60),
                     Healing= c(100,0,80), 
                     Strategy=c(100,30,80),stringsAsFactors=FALSE)
MinScore =0; MaxScore=100;
############
#将五项数据绘制成图，并设定Max=100,Min=0.
MaxMin <- data.frame(Attack=c(MaxScore,MinScore), Defense=c(MaxScore,MinScore),
                     Witchcraft=c(MaxScore,MinScore),Healing=c(MaxScore,MinScore),Strategy=c(MaxScore,MinScore))
rownames(MaxMin) <- c('Max','Min')#添加行名Max,Min
SpiderData <- rbind(MaxMin, MyData[,2:6])#将MaxmMin与Mydata的2至6列横向连接
rownames(SpiderData) <- c('Max','Min',MyData[,1])#添加行名

############

MyColor <- function (Myclr, ClrTransparency) {
  TT <- col2rgb(Myclr)/255;
  return(rgb(TT[1],TT[2],TT[3],ClrTransparency))
} 
#define a function to caculate RGB Hex constants for a specific color with a specific transparency

colors_border=c( "blue", "green3", "red3")
colors_in=c( MyColor("green2",0.3) , MyColor("red4",0.3) , MyColor("orange3",0.3))
############
radarchart( SpiderData  , axistype=0 , 
            #custom polygon
            pcol=colors_border , pfcol=colors_in , plwd=1.5, plty=1,
            #custom the grid
            cglcol="gray", cglty=3, cglwd=1, #grids
            vlcex=1)#绘制雷达图
legend(x=1, y=0.2, legend = rownames(SpiderData[-c(1,2),]), 
       bty = "n", pch=16 , col=colors_in , cex=1,text.col = "black" ,pt.cex=2)#添加图例


############