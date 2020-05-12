#a)

library(caret)
setwd("D:/BA/Homework/HW03")
fgl <- read.csv('fgl.csv',header=TRUE)
#读取fgl.csv文件，转化成fgl数据框

Predictors=fgl[,c('RI','Na','Mg','Al','Si','K','Ca','Ba','Fe')]
model<-train(Predictors,fgl[,'type'],method = 'knn',tuneGrid = data.frame(k=1:8),
             metric = 'Accuracy', trControl = trainControl(method='repeatedcv',number = 5,repeats = 20))
#先列出Predictors（折射率和其他八种元素）, 接着是结果变量（玻璃的类型），接着是说明使用KNN方法
#模型当中k的取值范围从1到8，评价指标是“准确率” 
#用重复交叉验证，number=5的意思是做5-fold重复交叉验证，repeats=20指该验证重复20次

model
#得出最佳k值为1

plot(model)
#画出不同 k 值下的 KNN 模型的预测准确率

confusionMatrix(model)
#最终的模型的混淆矩阵

#b)问解答请见word文档