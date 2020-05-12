library(cluster) #needed for hierachical clustering
library(plyr) #needed for arrange
library(ggplot2) #needed for qplot

setwd("D:/BA/Homework/HW04")
EastWestData <- read.csv("EastWestAirlines.csv",header = TRUE)
set.seed(1200) #�����������
EastWest <- EastWestData[sample(nrow(EastWestData),1000),] #��������ݿ�EastWestData�г��1000�����ݽ��о��ࡣ
EastWestModel <- EastWest[,  c('Balance','Qual_miles','Bonus_miles','Bonus_trans',
                               'Flight_miles_12mo','Flight_trans_12')]

#
EastWestAgg = agnes(EastWestModel,diss=FALSE,metric="euclidian",method="average",stand=TRUE)
#����ͼ���20��clusters��stand=TRUE��ζ�ž���֮ǰ�ȶ����ݽ��б�׼��������
treeidx <- cutree(EastWestAgg, k=20)
#�ڸ��������ϴ��ϱ�ǩ˵�����������ǵڼ���cluster����ǩ����Class�С�
EastWestClusters <- data.frame(EastWest, Class=treeidx) 
#��Class��ת����factor�ͱ�����
EastWestClusters$Class <- as.factor(EastWestClusters$Class)

aggregate(Balance ~ Class, data=EastWestClusters, length) #�������ݼ�¼ͨ�� class ���з������֮��� Balance ��ֵ���ɵ������ڸ���ļ���
aggregate(. ~ Class, data=EastWestClusters, mean) #�������ݼ�¼ͨ�� class ���з������֮��ÿ�������ڸ���ľ�ֵ��mean��

EastWestClusters <- data.frame(EastWest, Class=2-(treeidx %in% c(1,4,8,9,15,17,19)) ) #��Qual_miles��ֵ��С�ķ�Ϊһ�࣬ʣ�µķ�Ϊ����һ��
EastWestClusters$Class <- as.factor(EastWestClusters$Class) #��Class��ת����factor�ͱ�����
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
#�������ָ�꣺ward
EastWestAgg = agnes(EastWestModel,diss=FALSE,metric="euclidian",method="ward",stand=TRUE)
treeidx <- cutree(EastWestAgg, k=4)
#�ڸ��������ϴ��ϱ�ǩ˵�����������ǵڼ���cluster����ǩ����Class�С�
EastWestClusters <- data.frame(EastWestModel, Class=treeidx) 
#��Class��ת����factor�ͱ�����
EastWestClusters$Class <- as.factor(EastWestClusters$Class)
#EastWestClusters
aggregate(Qual_miles ~ Class, data=EastWestClusters, length)
aggregate(. ~ Class, data=EastWestClusters, mean) 
EastWestClusters <- data.frame(EastWest, Class=2-(treeidx %in% c(2)) )
EastWestClusters$Class <- as.factor(EastWestClusters$Class) #��Class��ת����factor�ͱ�����
aggregate(Balance ~ Class, data=EastWestClusters, length) 
aggregate(. ~ Class, data=EastWestClusters, mean) 

qplot(Balance,Qual_miles,data=EastWestClusters,colour = Class)
qplot(Bonus_trans,Bonus_miles,data=EastWestClusters,colour = Class)
qplot(Flight_trans_12,Flight_miles_12mo,data=EastWestClusters,colour = Class)