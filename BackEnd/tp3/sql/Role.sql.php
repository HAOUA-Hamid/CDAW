<?php
Role::addSqlQuery('ROLE_LIST',
    'SELECT * FROM ROLE ORDER BY ROLE_NAME');

Role::addSqlQuery('ROLE_GET_BY_ID',
    'SELECT * FROM ROLE WHERE ROLE_ID = :id');

Role::addSqlQuery('ROLE_CREATE',
    'INSERT INTO ROLE (ROLE_ID, ROLE_NAME, ROLE_DESCRIPTION) VALUES (NULL, :name, :description)');

Role::addSqlQuery('ROLE_UPDATE',
    'UPDATE ROLE SET ROLE_NAME = :name, ROLE_DESCRIPTION = :description WHERE ROLE_ID = :id');

Role::addSqlQuery('ROLE_DELETE',
    'DELETE FROM ROLE WHERE ROLE_ID = :id');