<?php
class RolesController extends Controller {

    public function __construct($name, $request) {
        parent::__construct($name, $request);
    }

    public function processRequest() {
        switch ($this->request->getHttpMethod()) {
            case 'GET':
                if (empty($this->request->uriParameters)) {
                    return $this->getAllRoles();
                } else {
                    return $this->getRoleById($this->request->uriParameters[0]);
                }
                
            case 'POST':
                if (empty($this->request->uriParameters)) {
                    return $this->createRole();
                }
                return Response::errorInParametersResponse(json_encode(['message' => 'No ID allowed for POST']));
                
            case 'PUT':
                if (!empty($this->request->uriParameters)) {
                    return $this->updateRole($this->request->uriParameters[0]);
                }
                return Response::errorInParametersResponse(json_encode(['message' => 'Role ID required']));
                
            case 'DELETE':
                if (!empty($this->request->uriParameters)) {
                    return $this->deleteRole($this->request->uriParameters[0]);
                }
                return Response::errorInParametersResponse(json_encode(['message' => 'Role ID required']));
               
        }
        return Response::errorResponse("unsupported parameters or method in roles");
    }

    protected function getAllRoles() {
        $roles = Role::getList();
        $rolesArray = array_map(function($role) {
            return [
                'id' => $role->ROLE_ID,
                'name' => $role->ROLE_NAME,
                'description' => $role->ROLE_DESCRIPTION
            ];
        }, $roles);
        return Response::okResponse(json_encode($rolesArray));
    }

    protected function getRoleById($id) {
        $role = Role::getById($id);
        if ($role) {
            $roleArray = [
                'id' => $role->ROLE_ID,
                'name' => $role->ROLE_NAME,
                'description' => $role->ROLE_DESCRIPTION
            ];
            return Response::okResponse(json_encode($roleArray));
        }
        return Response::notFoundResponse(json_encode(['message' => "Role with ID $id not found"]));
    }

    protected function createRole() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data || !is_array($data) || empty($data['name'])) {
            return Response::errorInParametersResponse(json_encode(['message' => 'Missing required field: name']));
        }

        $newId = Role::create($data);
        if ($newId) {
            $newRole = Role::getById($newId);
            $roleArray = [
                'id' => $newRole->ROLE_ID,
                'name' => $newRole->ROLE_NAME,
                'description' => $newRole->ROLE_DESCRIPTION
            ];
            return Response::okResponse(json_encode($roleArray));
        }
        return Response::serverErrorResponse(json_encode(['message' => 'Failed to create role']));
    }

    protected function updateRole($id) {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data || !is_array($data)) {
            return Response::errorInParametersResponse(json_encode(['message' => 'Invalid JSON data']));
        }

        $existingRole = Role::getById($id);
        if (!$existingRole) {
            return Response::notFoundResponse(json_encode(['message' => "Role with ID $id not found"]));
        }

        $success = Role::update($id, $data);
        if ($success) {
            $updatedRole = Role::getById($id);
            $roleArray = [
                'id' => $updatedRole->ROLE_ID,
                'name' => $updatedRole->ROLE_NAME,
                'description' => $updatedRole->ROLE_DESCRIPTION
            ];
            return Response::okResponse(json_encode($roleArray));
        }
        return Response::serverErrorResponse(json_encode(['message' => 'Failed to update role']));
    }

    protected function deleteRole($id) {
        $existingRole = Role::getById($id);
        if (!$existingRole) {
            return Response::notFoundResponse(json_encode(['message' => "Role with ID $id not found"]));
        }

        $success = Role::delete($id);
        if ($success) {
            return Response::okResponse(json_encode(['message' => "Role with ID $id deleted"]));
        }
        return Response::serverErrorResponse(json_encode(['message' => 'Failed to delete role']));
    }
}