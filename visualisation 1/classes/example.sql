SELECT A.title , C.title, MATCH (A.`text`) AGAINST ('
Bad news for those who enjoy what they think is a healthy glass of wine a day.
A large new global study published in the Lancet has confirmed previous research which has shown that there is no safe level of alcohol consumption.
The researchers admit moderate drinking may protect against heart disease but found that the risk of cancer and other diseases outweighs these protections.
A study author said its findings were the most significant to date because of the range of factors considered.                                  
' ) koef FROM `cnbc_article` A LEFT JOIN cnbc_article_cat AC ON (AC.article_id=A.id) LEFT JOIN cnbc_category C ON (C.id=AC.category_id)
GROUP BY A.id 
ORDER BY koef DESC 
LIMIT 30


SELECT category_title, COUNT(category_id), SUM(koef) FROM 

(SELECT A.title as article_title , C.title as category_title, C.id as category_id, MATCH (A.`text`) AGAINST ('
Bad news for those who enjoy what they think is a healthy glass of wine a day.
A large new global study published in the Lancet has confirmed previous research which has shown that there is no safe level of alcohol consumption.
The researchers admit moderate drinking may protect against heart disease but found that the risk of cancer and other diseases outweighs these protections.
A study author said its findings were the most significant to date because of the range of factors considered.                                  
' ) koef FROM `cnbc_article` A LEFT JOIN cnbc_article_cat AC ON (AC.article_id=A.id) LEFT JOIN cnbc_category C ON (C.id=AC.category_id)
WHERE C.`level`>0
GROUP BY A.id 
ORDER BY koef DESC 
LIMIT 30) S

GROUP BY category_id ORDER BY SUM(koef) DESC 
