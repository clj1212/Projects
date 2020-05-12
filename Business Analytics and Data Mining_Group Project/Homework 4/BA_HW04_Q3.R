library(arules) 
setwd("C:/BA/Homework/HW04")
Cosmetics <- read.csv("Cosmetics.csv",header = TRUE)
#读取Cosmetics.csv文件

#3.1）----------------
rules1 <- apriori(Cosmetics, parameter = list(minlen=2, supp=0.1, conf=0.5),
                 appearance = list(lhs = c("Nail.Polish=yes"), default="rhs"),
                 control = list(verbose=F))
#支持度supp设置为0.1，置信度conf设置为0.5，前件控制为Nail.Polish=yes的情况

rules1.sorted <- sort(rules1, by="lift") #按照提升度由高到低排序

# 移除冗余规则
rules1.pruned <- rules1.sorted[!is.redundant(rules1.sorted)]
inspect(rules1.pruned) #查看所有规则

#3.2）----------------
rules2 <- apriori(Cosmetics, parameter = list(minlen=2, supp=0.2, conf=0.5),
                 appearance = list(lhs = c("Mascara=yes"), default="rhs"),
                 control 
                 = list(verbose=F))
#支持度supp设置为0.2，置信度conf设置为0.5，前件控制为Mascara=yes的情况
rules2.sorted <- sort(rules2, by="lift") #按照提升度由高到低排序

# 移除冗余规则
rules2.pruned <- rules2.sorted[!is.redundant(rules2.sorted)]
inspect(rules2.pruned) #查看所有规则