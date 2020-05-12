library(class)
library(plyr) #needed for arrange
library(e1071) ## needed for Naive Bayes
setwd("D:/BA/Homework/HW04")
Accidents <- read.csv("Accidents.csv",header = TRUE)

#将MAX_SEV_IR等于1或者2的值全部设置为1。
Accidents[Accidents[,'MAX_SEV_IR']>0,'MAX_SEV_IR'] = 1
#将1-13,15-17,19-20,22-24列转换成类别型变量。
AA <- c(1:13,15:17,19:20,22:24);
for (i in 1:length(AA)) {
  Accidents[,AA[i]] <- factor(Accidents[,AA[i]])
}

#Q1.1
#取出Accidents数据集的子集前12条记录，只取WEATHER_R和TRAF_CON_R为预测变量。
AccSub <- Accidents[c(1:12),c('WEATHER_R','TRAF_CON_R','MAX_SEV_IR')]
AccSub <- data.frame(AccSub,COUNT=rep(1,nrow(AccSub)))
#下面列出分类汇总表：
attach(AccSub)
arrange(aggregate(COUNT~WEATHER_R+TRAF_CON_R+MAX_SEV_IR,data=AccSub,sum),WEATHER_R,TRAF_CON_R)
detach(AccSub)
#Q1.2 
#1/（5+1）=1/6

#Q1.3
attach(AccSub)
table(MAX_SEV_IR,WEATHER_R)
table(MAX_SEV_IR,TRAF_CON_R)
table(MAX_SEV_IR)
detach(AccSub)

#Q1.4: 使用Naive Bayes模型
AccSub[2,]
Predictors <- AccSub[,c('WEATHER_R','TRAF_CON_R')]
Target <- AccSub[,'MAX_SEV_IR']
classifier<-naiveBayes(Predictors, Target) 
Probs <- predict(classifier, Predictors, type='raw',threshold=0.01)
Probs
#在AccSub中新增加一列，列名为PredictInj，初始值为0,1,0,1...
AccSub <- data.frame(AccSub,PredictInj = rep(0:1,6))
for(i in 1:12)
{  if(Probs[i,2]>0.4){ AccSub[i,5]=1}
  else {AccSub[i,5]=0}}
AccSub[,"PredictInj"]
mypred <- data.frame(pred =ifelse(Probs[,2]>0.4,'1','0'),
                     obs = AccSub[,"MAX_SEV_IR"])
table(mypred)
#Q1.5
AccidentModel <- Accidents[,c('HOUR_I_R','ALIGN_I','WRK_ZONE','WKDY_I_R','INT_HWY','RELJCT_I_R',
                              'REL_RWY_R','TRAF_CON_R','TRAF_WAY','MAX_SEV_IR')] #选取预测因素和预测目标
set.seed(1000)#设定随机数种子
RowNum <- nrow(AccidentModel)#读取行数即样本总数
SampleIndex <- sample(1:RowNum,round(RowNum*0.8),replace = FALSE)#随机取样从行数范围内取行数的0.8个（用来作为训练集）
TrainData <- AccidentModel[SampleIndex,] #用上行生成的下标作为训练集
ValidationData <- AccidentModel[-SampleIndex,] #余下为验证集
TargetIndex <- which(colnames(AccidentModel)=='MAX_SEV_IR') #预测目标所在列数
Predictors <- TrainData[,-TargetIndex]#选择预测因素的集合即去掉预测目标

#Q1.6
#注意下面的空白处是由你来填写代码，而不是让你通过注释回答问题。
#对问题的所有回答都应该写在Word文档里面。
#不过你可以写注释帮助TA理解你写的代码是什么意思，以便你在出错时TA可以找到理由给你部分分数。
classifier<-naiveBayes(Predictors, TrainData[,TargetIndex]) #用naiveBayes函数生成朴素贝叶斯容器
MyPridict<-data.frame(predict(classifier, ValidationData))#进行预测
MyPridict[,1] <- as.numeric(as.character(MyPridict[,1]))#将factor类型转为numeric类型
print(table(MyPridict[,1], ValidationData[,TargetIndex]))#画混淆矩阵
#Q1.7
ones=length(which(TrainData[,TargetIndex]==1))#TrainData中目标为1的个数
zeros=length(which(TrainData[,TargetIndex]==0))#TrainData中目标为0的个数
#因为ones>zeros，故认为训练集结果均为1

#Q1.8
#1.7的正确率
ones2=length(which(ValidationData[,TargetIndex]==1))#验证集中目标为1的个数
zeros2=length(which(ValidationData[,TargetIndex]==0))#验证集中目标为0的个数
ratio1=ones2/(ones2+zeros2)  
ratio1
#1.6的正确率
ratio2=(1911+2578)/(ones2+zeros2)
ratio2
#由于ratio1<ratio2,因此使用朴素贝叶斯分类器的预测错误率低。
#有用，但由于提升并不明显，故作用不大
#Q1.9
