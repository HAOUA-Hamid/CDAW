<?php
class Role extends Model {

    protected static $table_name = 'ROLE';

    public static function getList() {
        $stm = parent::exec('ROLE_LIST');
        return $stm->fetchAll();
    }

    public static function getById($id) {
        $stm = parent::exec('ROLE_GET_BY_ID', ['id' => $id]);
        return $stm->fetch();
    }

    public static function create($data) {
        $params = [
            'name' => $data['name'] ?? null,
            'description' => $data['description'] ?? null
        ];
        $stm = parent::exec('ROLE_CREATE', $params);
        return static::db()->lastInsertId();
    }

    public static function update($id, $data) {
        $params = [
            'id' => $id,
            'name' => $data['name'] ?? null,
            'description' => $data['description'] ?? null
        ];
        $stm = parent::exec('ROLE_UPDATE', $params);
        return $stm->rowCount() > 0;
    }

    public static function delete($id) {
        $stm = parent::exec('ROLE_DELETE', ['id' => $id]);
        return $stm->rowCount() > 0;
    }
}