
USE mysql;
CREATE user 'root'@'%';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';
UPDATE user SET password=PASSWORD("Re:Start!9") WHERE user='root';
flush privileges;
