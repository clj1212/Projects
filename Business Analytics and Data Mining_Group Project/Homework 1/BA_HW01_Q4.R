#Q4a-------------对此题的解释已在代码旁以注释形式给出-----------------------

setwd('D:/BA/Homework/HW01') #如果没有D盘则把数据文件放在C盘的C:\BA\Homework\HW01中，把这条语句里面的D改成C。
Apple_Assets <- read.csv('Apple_Assets.csv', stringsAsFactors= FALSE)
colnames(Apple_Assets)<- c('Item','2017Sept','2016Sept','2015Sept','2014Sept','2013Sept','2012Sept')


replaceCommas<-function(x){ x<-as.numeric(gsub("\\,", "", x))} #将字符串里面的逗号去掉，然后转换成数值型。
N_cols = ncol(Apple_Assets)
Apple_Assets[,2:N_cols] = apply(Apple_Assets[,2:N_cols],2,replaceCommas)
attach(Apple_Assets)
RowN_to_change = which(Item=='Current assets')
RowN_begin = which (Item=='Cash and cash equivalents')
Apple_Assets[RowN_to_change, 2:N_cols] = sapply(Apple_Assets[RowN_begin:(RowN_to_change-1),2:N_cols],sum)
detach(Apple_Assets)

MySum <- function (df, checkrow, begin, sumitem) {
  attach(df)
  N_cols = ncol(df)
  RowN_to_change = which(checkrow==sumitem)
  RowN_begin = which (checkrow==begin)
  df[RowN_to_change, 2:N_cols] = sapply(df[RowN_begin:(RowN_to_change-1),2:N_cols],sum)
  detach(df)
  return(df)
}
Apple_Assets = MySum(Apple_Assets, Item, "Cash and cash equivalents", "Current assets")

Apple_Assets = MySum(Apple_Assets, Item, "Long-term marketable securities", "Non-current assets")

attach(Apple_Assets)
RowN_to_change = which(Item=='Total assets')
RowN_S1 = which (Item=='Current assets')
RowN_S2 = which (Item=='Non-current assets')
Apple_Assets[RowN_to_change, 2:N_cols] = sapply(Apple_Assets[c(RowN_S1,RowN_S2),2:N_cols],sum)
detach(Apple_Assets)

SumTwoItems <- function (df, checkrow, sumrow, item1, item2) {
  attach(df)
  RowN_to_change = which(checkrow==sumrow)
  RowN_S1 = which (checkrow==item1)
  RowN_S2 = which (checkrow==item2)
  df[RowN_to_change, 2:N_cols] = sapply(df[c(RowN_S1,RowN_S2),2:N_cols],sum)
  detach(df)
  return(df)
}
Apple_Assets = SumTwoItems(Apple_Assets, Item, "Total assets","Current assets","Non-current assets")

Apple_Liabilities <- read.csv('Apple_Liabilities.csv', stringsAsFactors= FALSE)
colnames(Apple_Liabilities)<- c('Item','2017Sept','2016Sept','2015Sept','2014Sept','2013Sept','2012Sept')

N_cols = ncol(Apple_Liabilities)
Apple_Liabilities[,2:N_cols] = apply(Apple_Liabilities[,2:N_cols],2,replaceCommas)

Apple_Liabilities = MySum(Apple_Liabilities, Item, "Accounts payable", "Current liabilities")

Apple_Liabilities = MySum(Apple_Liabilities, Item, "Deferred revenue, non-current", "Non-current liabilities")

Apple_Liabilities = MySum(Apple_Liabilities, Item, "Common stock and additional paid-in capital, $0.00001 par value", "Shareholders' equity")

Apple_Liabilities = SumTwoItems(Apple_Liabilities, Item, "Total liabilities", "Current liabilities","Non-current liabilities")

Apple_Liabilities = SumTwoItems(Apple_Liabilities, Item, "Total liabilities and shareholders' equity", "Total liabilities",
                                "Shareholders' equity")

Apple <- rbind(Apple_Assets, Apple_Liabilities)


#Q4b-----------对此题的解释已在代码旁以注释形式给出----------------------------

attach(Apple)
Apple[Item=='Total assets',2:7]==Apple[Item=="Total liabilities and shareholders' equity",2:7]
detach(Apple)

#Q4c-----------对此题的解释已在代码旁以注释形式给出----------------------------

attach(Apple)
RowN_Type = which (Item=='Current assets')
AppleTree <- Apple[1:(RowN_Type-1), 1:3]
AppleTree <- cbind(AppleTree, data.frame(Type=rep('Current Assets', (RowN_Type-1))))
detach(Apple)

attach(Apple)
RowN_Type1 = which (Item=='Current assets')
RowN_Type2 = which (Item=='Non-current assets')
ATree <- Apple[(1+RowN_Type1):(RowN_Type2-1), 1:3]
ATree <- cbind(ATree, data.frame(Type=rep('Non-Current Assets', (RowN_Type2-RowN_Type1-1))))
AppleTree <- rbind(AppleTree, ATree)
detach(Apple)

attach(Apple)
RowN_Type1 = which (Item=='Total assets')
RowN_Type2 = which (Item=='Current liabilities')
ATree <- Apple[(1+RowN_Type1):(RowN_Type2-1), 1:3]
ATree <- cbind(ATree, data.frame(Type=rep('Current Liabilities', (RowN_Type2-RowN_Type1-1))))
AppleTree <- rbind(AppleTree, ATree)
detach(Apple)

attach(Apple)
RowN_Type1 = which (Item=='Current liabilities')
RowN_Type2 = which (Item=='Non-current liabilities')
ATree <- Apple[(1+RowN_Type1):(RowN_Type2-1), 1:3]
ATree <- cbind(ATree, data.frame(Type=rep('Non-Current Liabilities', (RowN_Type2-RowN_Type1-1))))
AppleTree <- rbind(AppleTree, ATree)
detach(Apple)

attach(Apple)
RowN_Type1 = which (Item=='Accumulated other comprehensive income (loss)')
RowN_Type2 = which (Item=="Total liabilities and shareholders' equity")
ATree <- Apple[(1+RowN_Type1):(RowN_Type2-1), 1:3]
ATree <- cbind(ATree, data.frame(Type=rep("Shareholders' Equity", (RowN_Type2-RowN_Type1-1))))
AppleTree <- rbind(AppleTree, ATree)
AppleTree
detach(Apple)

#Q4d-----------代码如下-------------------------------------


library(treemap)
treemap(AppleTree,index=c("Type","Item"),vSize="2017Sept",vColor="2016Sept",type="comp",
        title="苹果公司财务报表可视化",palette='RdBu',fontfamily.title = "MingLiU-98")


#Q4e---------对此题的解释已在代码旁以注释形式给出------------------

attach(AppleTree)   
#绑定AppleTree，之后便可直接引用AppleTree中的元素
A1 <- AppleTree[Type %in% c('Current Assets','Non-Current Assets'),]  
#调取AppleTree中Type为Current Assets和Non-Current Assets的几行数据组成新的数据框A1
A1$Type <- rep('Assets', nrow(A1))
#把A1中的Type列中的内容全部换成字符“Assets”
A2 <- AppleTree[Type %in% c('Current Liabilities','Non-Current Liabilities',"Shareholders' Equity"),]
#调取AppleTree中Type为Current Liabilities、Non-Current Liabilities和Shareholders' Equity的几行数据组成新的数据框A2
A2$Type <- rep('Liabilities&SE', nrow(A2))
#把A1中的Type列中的内容全部换成字符“Liabilities&SE”
AA <- rbind(A1,A2)
#将A1、A2两个数据框纵向合并成新的数据框AA
AA <- cbind(AA, data.frame(SubType = AppleTree$Type))
#在AA数据框中新加一个SubType列，并将AppleTree中的Type列信息复制到SubType列中
detach(AppleTree)
#解除绑定AppleTree
AA
#输出AA数据框


#Q4f----------代码如下-----------------

treemap(AA,index=c("Type","SubType","Item"),vSize="2017Sept",vColor="2016Sept",type="comp",
        palette="RdBu",title='苹果公司财务报表可视化',fontfamily.title = "MingLiU-98")