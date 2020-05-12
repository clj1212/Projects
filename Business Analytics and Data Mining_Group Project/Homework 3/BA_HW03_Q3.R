library(stringr)
library(ggplot2)
library(plyr)
library(MASS)
setwd('D:/BA/Homework/HW03')
Tayko <- read.csv('Tayko.csv')

#a)
aggregate(Spending ~ source_a,data=Tayko,mean)#‘1’表示购买了软件目录source_a的软件，其平均消费金额是247.8985
aggregate(Spending ~ source_b,data=Tayko,mean)#‘1’表示购买了软件目录source_b的软件，其平均消费金额是197.6111

#b)
Spending_Model <- Tayko[,c('US','Freq','last_update_days_ago','Web.order','Gender.male','Address_is_res','Spending')]
#按题目要求把所需的数据放入Spending_Model这个数据框
fit <- lm(Spending ~ .,data=Spending_Model)
#被解释变量是Spending, Spending_Model数据框当中的其他变量是解释变量
summary(fit)
#Freq,last_update_days_ago,address_is_res在显著性水平5%上显著（至少得到一颗星）

#c)
min_model_1 = lm(Spending ~ 1, data=Tayko)
biggest_1 <-formula(lm(Spending ~ ., data = Tayko))
#写成lm(Spending~.,data=Tayko),  R语言编译器就会把Tayko当中除了Spending之外的所有其他变量都当做解释变量,
stepf <- stepAIC(min_model_1, direction='forward',scope=biggest_1)
#使用前向选择法对变量进行选择
stepf$anova
summary(stepf)
#最终模型表达式为Spending ~ Freq + Address_is_res + last_update_days_ago + source_r + source_a + source_u + X1st_update_days_ago

#d)
min_model_2 = lm(Spending ~ 1, data=Spending_Model)
biggest_2 <-formula(lm(Spending ~ ., data = Spending_Model))
# 以3(b)当中的模型做为最大模型
stepf <- stepAIC(min_model_2, direction='forward',scope=biggest_2)
#使用前向选择法对变量进行选择
stepf$anova
summary(stepf)
#最终模型表达式为：Spending ~ Freq + Address_is_res + last_update_days_ago