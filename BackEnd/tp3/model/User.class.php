<?php
class User extends Model {

    protected static $table_name = 'USER';

    public static function getList() {
        $stm = parent::exec('USER_LIST');
        return $stm->fetchAll();
    }

    public static function getById($id) {
        $stm = parent::exec('USER_GET_BY_ID', ['id' => $id]);
        return $stm->fetch();
    }

    public static function update($id, $data) {
        $params = [
            'id' => $id,
            'login' => $data['login'] ?? null,
            'email' => $data['email'] ?? null,
            'role' => $data['role'] ?? null,
            'pwd' => $data['pwd'] ?? null,
            'name' => $data['name'] ?? null,
            'surname' => $data['surname'] ?? null
        ];
        $stm = parent::exec('USER_UPDATE', $params);
        return $stm->rowCount() > 0;
    }

    public static function create($data) {
        $params = [
            'login' => $data['login'] ?? null,
            'email' => $data['email'] ?? null,
            'role' => $data['role'] ?? null,
            'pwd' => $data['pwd'] ?? null,
            'name' => $data['name'] ?? null,
            'surname' => $data['surname'] ?? null
        ];
        $stm = parent::exec('USER_CREATE', $params);
        return static::db()->lastInsertId(); // Return new user ID
    }

    public static function delete($id) {
        $stm = parent::exec('USER_DELETE', ['id' => $id]);
        return $stm->rowCount() > 0; // Return true if deleted
    }
}