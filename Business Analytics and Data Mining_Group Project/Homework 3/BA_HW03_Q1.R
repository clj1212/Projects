setwd("D:/BA/Homework/HW03")
wine=read.table('Wine.csv',  header=TRUE, sep=",")
#把Wine.csv文件转化成wine数据框

#1)
wine_PCA_1<-prcomp(na.omit(wine[,2:14]),scale=FALSE) 
#不进行标准化处理，对wine中对第 2 列到第 14 列数据进行主成分分析
summary(wine_PCA_1)
#由输出结果可知，只需要1个主成分变量即可捕捉到90%以上的总方差

#2)
wine_PCA_2<-prcomp(na.omit(wine[,2:14]),scale=TRUE)
#进行标准化处理，对wine中对第 2 列到第 14 列数据进行主成分分析
summary(wine_PCA_2)
#由输出结果可知，需要8个主成分变量可捕捉到90%以上的总方差

#3）
#第二种方法好，方法二消除了量纲的影响，是表达信息量的有效方式，避免了某一变量量纲选择过小，而成为主要因素。

