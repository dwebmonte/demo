sudo yum install php-mysqli
sudo yum install php-mbstring

sudo yum install wget
sudo wget https://dev.mysql.com/get/mysql57-community-release-el7-9.noarch.rpm
sudo rpm -ivh mysql57-community-release-el7-9.noarch.rpm
sudo yum install mysql-server

sudo systemctl start mysqld
sudo systemctl start httpd

sudo grep 'temporary password' /var/log/mysqld.log
sudo mysql_secure_installation
sudo mysql -u root -p < /var/www/html/install_sql.sql

sudo chcon -t httpd_sys_content_t /var/www/html -R
sudo chcon -t httpd_sys_rw_content_t /var/www/html -R

sudo crontab /var/www/html/scripts/cron