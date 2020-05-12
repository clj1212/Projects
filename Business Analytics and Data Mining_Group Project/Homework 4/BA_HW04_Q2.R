library(cluster) #needed for hierachical clustering
library(plyr) #needed for arrange
library(ggplot2) #needed for qplot

setwd("D:/BA/Homework/HW04")
EastWestData <- read.csv("EastWestAirlines.csv",header = TRUE)
set.seed(1200) #设置随机种子
EastWest <- EastWestData[sample(nrow(EastWestData),1000),] #随机从数据框EastWestData中抽出1000个数据进行聚类。
EastWestModel <- EastWest[,  c('Balance','Qual_miles','Bonus_miles','Bonus_trans',
                               'Flight_miles_12mo','Flight_trans_12')]

#
EastWestAgg = agnes(EastWestModel,diss=FALSE,metric="euclidian",method="average",stand=TRUE)
#把树图割成20个clusters。stand=TRUE意味着聚类之前先对数据进行标准化处理。
treeidx <- cutree(EastWestAgg, k=20)
#在各行数据上打上标签说明该行数据是第几个cluster，标签存在Class列。
EastWestClusters <- data.frame(EastWest, Class=treeidx) 
#将Class列转换成factor型变量。
EastWestClusters$Class <- as.factor(EastWestClusters$Class)

aggregate(Balance ~ Class, data=EastWestClusters, length) #所有数据记录通过 class 进行分组汇总之后的 Balance 数值构成的向量在各组的计数
aggregate(. ~ Class, data=EastWestClusters, mean) #所有数据记录通过 class 进行分组汇总之后，每个变量在各组的均值（mean）

EastWestClusters <- data.frame(EastWest, Class=2-(treeidx %in% c(1,4,8,9,15,17,19)) ) #将Qual_miles均值较小的分为一类，剩下的分为另外一类
EastWestClusters$Class <- as.factor(EastWestClusters$Class) #将Class列转换成factor型变量。
aggregate(Balance ~ Class, data=EastWestClusters, length) 
aggregate(. ~ Class, data=EastWestClusters, mean) 

qplot(Balance,Qual_miles,data=EastWestClusters,colour = Class)
qplot(Bonus_trans,Bonus_miles,data=EastWestClusters,colour = Class)
qplot(Flight_trans_12,Flight_miles_12mo,data=EastWestClusters,colour = Class)

A1 <- arrange(aggregate(Balance ~ Class + as.factor(Award.), data=EastWestClusters, length), Class)
A1
A2 <- t(A1)
A2
AA <- rbind(as.numeric(A2[3,1:2]),as.numeric(A2[3,3:4]))
colnames(AA) <- c('no.Award','with.Award')
AA
labels <- c('no.Award','with.Award')
barplot(AA, offset = 0, axis.lty = 1, names.arg = labels, col = c('blue1','green2'))

#Q1.8
#聚类距离指标：ward
EastWestAgg = agnes(EastWestModel,diss=FALSE,metric="euclidian",method="ward",stand=TRUE)
treeidx <- cutree(EastWestAgg, k=4)
#在各行数据上打上标签说明该行数据是第几个cluster，标签存在Class列。
EastWestClusters <- data.frame(EastWestModel, Class=treeidx) 
#将Class列转换成factor型变量。
EastWestClusters$Class <- as.factor(EastWestClusters$Class)
#EastWestClusters
aggregate(Qual_miles ~ Class, data=EastWestClusters, length)
aggregate(. ~ Class, data=EastWestClusters, mean) 
EastWestClusters <- data.frame(EastWest, Class=2-(treeidx %in% c(2)) )
EastWestClusters$Class <- as.factor(EastWestClusters$Class) #将Class列转换成factor型变量。
aggregate(Balance ~ Class, data=EastWestClusters, length) 
aggregate(. ~ Class, data=EastWestClusters, mean) 

qplot(Balance,Qual_miles,data=EastWestClusters,colour = Class)
qplot(Bonus_trans,Bonus_miles,data=EastWestClusters,colour = Class)
qplot(Flight_trans_12,Flight_miles_12mo,data=EastWestClusters,colour = Class)
