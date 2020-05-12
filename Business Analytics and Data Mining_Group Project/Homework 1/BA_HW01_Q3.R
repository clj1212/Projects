#Q3_1
library(ggplot2)
BeijingTravel <- data.frame(���쵽�������εĽ���=c('��һ��ͨ','���ȫ�۵�','����ȥĽ����','�����촩���','��ȥ'),����=c(23,18,35,30,260)) 
ggplot(BeijingTravel)+geom_bar(aes(x=���쵽�������εĽ���,y=����,fill=���쵽�������εĽ���),stat='identity')

#Q3_2
x <- c(100, 120, 80, 80, 60)
labels <- c('����', '����', '��ͨ','��Ϣ','�Է�')
pie(x,labels,main='�ƻ��еĹ������ʱ�����',col=rainbow(length(x)))

#Q3_3
x <- c(300, 10, 10, 220, 5,10)
labels <- c('�����Ŷ�', '����', '����','��ͨ','��Ϣ','�Է�')
pie(x,labels,main='ʵ�ʵĹ������ʱ�����')

#Q3_4
val_happ = data.frame(���� = c('10.1','10.2','10.3','10.4','10.5','10.6','10.7','10.8'),���ڶ��ҵ����� = c(60, 70, 80, 70, 55, 30, 10, 100 ),����ָ�� = c(80, 90, 100, 70, 40, 10, 50, 0))
boost = 100/100; 
ggplot(val_happ) + geom_bar(aes(x=����, y=����ָ��),stat='identity', fill='gold', colour='black') +geom_line(aes(x=����, y=���ڶ��ҵ�����*boost,group=1), colour='blue') +geom_point(aes(x=����, y=���ڶ��ҵ�����*boost), colour='blue',  size=2) +geom_text(aes(label=���ڶ��ҵ�����, x=����, y=���ڶ��ҵ�����*boost+3), colour='blue') +geom_text(aes(label=����ָ��, x=����, y=����ָ��/2), colour='black') +labs(y = '����ָ��', x ='����', title = '�����ڼ�������仯') + theme(plot.title = element_text(hjust=0.5))+scale_y_continuous(sec.axis = sec_axis(~./boost, name = "���ڶ��ҵ�����"))+theme(axis.text.y.right = element_text(color = 'blue'))