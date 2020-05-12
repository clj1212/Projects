options(warn=-1) #turn off warning messages but should not do this before testing the scripts.
#载入各种所需要的包
library(ggplot2)
library(plyr)
library(RColorBrewer)
library(mapproj)
library(Hmisc) #needed for cut2
library(dplyr) #needed for %>%, group_by and summarise

#设置位置为"D:/BA/Homework/HW02"
setwd("D:/BA/Homework/HW02")


CHNmapdata<-read.csv("ProvMapData.csv")#读入ProvMapData数据
ProvIndex<-read.csv("ProvIndex.csv")#读入ProvIndex数据
CHNSales_data<-read.csv("SalesData.csv")#读入SalesData数据

SalesData_Index <-merge(CHNSales_data,ProvIndex,by="ProvNames")#合并CHNSales_data和ProvIndex两张数据表,根据ProvNames列的键值对两表进行合并。
SalesData_Map <- merge(CHNmapdata,SalesData_Index,by.x="id",by.y="ProvID")#将SalesData_Index和地图数据表CHNmapdata进行合并，得到三表合并之后的数据表SalesData_Map。
SalesData_Map <- arrange(SalesData_Map,id,order) #先按id再按order从小到达对此排序

SalesData_Map$Sales_Scale <- cut(SalesData_Map$SalesData,breaks=c(0,3000,6000,12000,22000,26000,32000,42000))#将SalesData分为7个区间，并保存在Sales_scale中
mymap <- ggplot(SalesData_Map, aes(x=long, y=lat, group=id,fill=Sales_Scale))+geom_polygon(colour="black")+coord_map()#画销售分区统计图
mymap <- mymap + scale_fill_manual(values=colorRampPalette(c("lightgoldenrod1", "red3"))(7),
                                   name = "销量",labels=c('<=3000','<=6000','<=12000','<=22000','<=26000', '<=32000','<=42000'))#改变标示颜色并修改右边图示的标题和颜色标签
mymap <- mymap + labs(x="经度",y="纬度",title="销量分区统计图") #修改x轴、y轴标签，并加上标题
mymap <- mymap + theme(plot.title = element_text(hjust = 0.5)) #让标题居中

mymap
