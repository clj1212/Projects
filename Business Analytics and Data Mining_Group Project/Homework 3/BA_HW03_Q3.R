library(stringr)
library(ggplot2)
library(plyr)
library(MASS)
setwd('D:/BA/Homework/HW03')
Tayko <- read.csv('Tayko.csv')

#a)
aggregate(Spending ~ source_a,data=Tayko,mean)#��1����ʾ����������Ŀ¼source_a����������ƽ�����ѽ����247.8985
aggregate(Spending ~ source_b,data=Tayko,mean)#��1����ʾ����������Ŀ¼source_b����������ƽ�����ѽ����197.6111

#b)
Spending_Model <- Tayko[,c('US','Freq','last_update_days_ago','Web.order','Gender.male','Address_is_res','Spending')]
#����ĿҪ�����������ݷ���Spending_Model������ݿ�
fit <- lm(Spending ~ .,data=Spending_Model)
#�����ͱ�����Spending, Spending_Model���ݿ��е����������ǽ��ͱ���
summary(fit)
#Freq,last_update_days_ago,address_is_res��������ˮƽ5%�����������ٵõ�һ���ǣ�

#c)
min_model_1 = lm(Spending ~ 1, data=Tayko)
biggest_1 <-formula(lm(Spending ~ ., data = Tayko))
#д��lm(Spending~.,data=Tayko),  R���Ա������ͻ��Tayko���г���Spending֮������������������������ͱ���,
stepf <- stepAIC(min_model_1, direction='forward',scope=biggest_1)
#ʹ��ǰ��ѡ�񷨶Ա�������ѡ��
stepf$anova
summary(stepf)
#����ģ�ͱ���ʽΪSpending ~ Freq + Address_is_res + last_update_days_ago + source_r + source_a + source_u + X1st_update_days_ago

#d)
min_model_2 = lm(Spending ~ 1, data=Spending_Model)
biggest_2 <-formula(lm(Spending ~ ., data = Spending_Model))
# ��3(b)���е�ģ����Ϊ���ģ��
stepf <- stepAIC(min_model_2, direction='forward',scope=biggest_2)
#ʹ��ǰ��ѡ�񷨶Ա�������ѡ��
stepf$anova
summary(stepf)
#����ģ�ͱ���ʽΪ��Spending ~ Freq + Address_is_res + last_update_days_ago