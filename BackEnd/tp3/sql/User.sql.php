<?php
User::addSqlQuery('USER_LIST',
    'SELECT * FROM USER ORDER BY USER_LOGIN');

User::addSqlQuery('USER_GET_WITH_LOGIN',
    'SELECT * FROM USER WHERE USER_LOGIN=:login');

User::addSqlQuery('USER_CREATE',
    'INSERT INTO USER (USER_ID, USER_LOGIN, USER_EMAIL, USER_ROLE, USER_PWD, USER_NAME, USER_SURNAME) VALUES (NULL, :login, :email, :role, :pwd, :name, :surname)');

User::addSqlQuery('USER_CONNECT',
    'SELECT * FROM USER WHERE USER_LOGIN=:login and USER_PWD=:password');

User::addSqlQuery('USER_GET_BY_ID',
    'SELECT * FROM USER WHERE USER_ID = :id');

User::addSqlQuery('USER_UPDATE',
    'UPDATE USER SET USER_LOGIN = :login, USER_EMAIL = :email, USER_ROLE = :role, USER_PWD = :pwd, USER_NAME = :name, USER_SURNAME = :surname WHERE USER_ID = :id');