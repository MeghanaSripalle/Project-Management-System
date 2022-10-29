create user 'company'@'localhost' identified by 'Company_Apple1';
grant all privileges on Apple.* to 'company'@'localhost';
-- use this command 'mysql -u company -p;' to access the user