library(TH.data)
library(rpart)
library(rpart.plot) # for the function rpart.plot
library(rattle) # for the function fancyRpartPlot

setwd("D:/BA/Homework/HW04")
rm(list=ls())
Seg<-read.csv("Segmentation.csv")
str(Seg)
dim(Seg)

set.seed(1234)#产生一个随机样本，以方便结果重现
ind <- sample(2, nrow(Seg), replace=TRUE, prob=c(0.7, 0.3))
Seg.train <- Seg[ind==1,]#设置训练集和测试集
Seg.test <- Seg[ind==2,]
myFormula <- Class ~ .#class做因变量，其余的做自变量
Seg_rpart <- rpart(myFormula, data = Seg.train,
                 control = rpart.control(minsplit = 100))
print(Seg_rpart)
attributes(Seg_rpart)
plot(Seg_rpart,margin=0.05)#设置边界距离
text(Seg_rpart,use.n=T)##添加节点文字信息
print(Seg_rpart$cptable)

