#Q3_1
library(ggplot2)
BeijingTravel <- data.frame(国庆到北京旅游的建议=c('办一卡通','别吃全聚德','长城去慕田峪','看升旗穿多点','别去'),数量=c(23,18,35,30,260)) 
ggplot(BeijingTravel)+geom_bar(aes(x=国庆到北京旅游的建议,y=数量,fill=国庆到北京旅游的建议),stat='identity')

#Q3_2
x <- c(100, 120, 80, 80, 60)
labels <- c('游览', '拍照', '交通','休息','吃饭')
pie(x,labels,main='计划中的国庆出行时间分配',col=rainbow(length(x)))

#Q3_3
x <- c(300, 10, 10, 220, 5,10)
labels <- c('景区排队', '游览', '拍照','交通','休息','吃饭')
pie(x,labels,main='实际的国庆出行时间分配')

#Q3_4
val_happ = data.frame(日期 = c('10.1','10.2','10.3','10.4','10.5','10.6','10.7','10.8'),假期对我的意义 = c(60, 70, 80, 70, 55, 30, 10, 100 ),开心指数 = c(80, 90, 100, 70, 40, 10, 50, 0))
boost = 100/100; 
ggplot(val_happ) + geom_bar(aes(x=日期, y=开心指数),stat='identity', fill='gold', colour='black') +geom_line(aes(x=日期, y=假期对我的意义*boost,group=1), colour='blue') +geom_point(aes(x=日期, y=假期对我的意义*boost), colour='blue',  size=2) +geom_text(aes(label=假期对我的意义, x=日期, y=假期对我的意义*boost+3), colour='blue') +geom_text(aes(label=开心指数, x=日期, y=开心指数/2), colour='black') +labs(y = '开心指数', x ='日期', title = '国庆期间的情绪变化') + theme(plot.title = element_text(hjust=0.5))+scale_y_continuous(sec.axis = sec_axis(~./boost, name = "假期对我的意义"))+theme(axis.text.y.right = element_text(color = 'blue'))