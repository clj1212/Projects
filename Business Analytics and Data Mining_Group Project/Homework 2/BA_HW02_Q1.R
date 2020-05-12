options(warn=-1) #turn off warning messages but should not do this before testing the scripts.
#�����������Ҫ�İ�
library(ggplot2)
library(plyr)
library(RColorBrewer)
library(mapproj)
library(Hmisc) #needed for cut2
library(dplyr) #needed for %>%, group_by and summarise

#����λ��Ϊ"D:/BA/Homework/HW02"
setwd("D:/BA/Homework/HW02")


CHNmapdata<-read.csv("ProvMapData.csv")#����ProvMapData����
ProvIndex<-read.csv("ProvIndex.csv")#����ProvIndex����
CHNSales_data<-read.csv("SalesData.csv")#����SalesData����

SalesData_Index <-merge(CHNSales_data,ProvIndex,by="ProvNames")#�ϲ�CHNSales_data��ProvIndex�������ݱ�,����ProvNames�еļ�ֵ���������кϲ���
SalesData_Map <- merge(CHNmapdata,SalesData_Index,by.x="id",by.y="ProvID")#��SalesData_Index�͵�ͼ���ݱ�CHNmapdata���кϲ����õ������ϲ�֮������ݱ�SalesData_Map��
SalesData_Map <- arrange(SalesData_Map,id,order) #�Ȱ�id�ٰ�order��С����Դ�����

SalesData_Map$Sales_Scale <- cut(SalesData_Map$SalesData,breaks=c(0,3000,6000,12000,22000,26000,32000,42000))#��SalesData��Ϊ7�����䣬��������Sales_scale��
mymap <- ggplot(SalesData_Map, aes(x=long, y=lat, group=id,fill=Sales_Scale))+geom_polygon(colour="black")+coord_map()#�����۷���ͳ��ͼ
mymap <- mymap + scale_fill_manual(values=colorRampPalette(c("lightgoldenrod1", "red3"))(7),
                                   name = "����",labels=c('<=3000','<=6000','<=12000','<=22000','<=26000', '<=32000','<=42000'))#�ı��ʾ��ɫ���޸��ұ�ͼʾ�ı������ɫ��ǩ
mymap <- mymap + labs(x="����",y="γ��",title="��������ͳ��ͼ") #�޸�x�ᡢy���ǩ�������ϱ���
mymap <- mymap + theme(plot.title = element_text(hjust = 0.5)) #�ñ������

mymap