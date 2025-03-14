<?php
class UsersController extends Controller {

    public function __construct($name, $request) {
        parent::__construct($name, $request);
    }

    public function processRequest() {
        switch ($this->request->getHttpMethod()) {
            case 'GET':
                if (empty($this->request->uriParameters)) {
                    return $this->getAllUsers();
                } else {
                    return $this->getUserById($this->request->uriParameters[0]);
                }
            case 'POST':
                if (empty($this->request->uriParameters)) {
                    return $this->createUser();
                }
                return Response::errorInParametersResponse(json_encode(['message' => 'No ID allowed for POST']));
            case 'PUT':
                if (!empty($this->request->uriParameters)) {
                    return $this->updateUser($this->request->uriParameters[0]);
                }
                return Response::errorInParametersResponse(json_encode(['message' => 'User ID required']));
            case 'DELETE':
                if (!empty($this->request->uriParameters)) {
                    return $this->deleteUser($this->request->uriParameters[0]);
                }
                return Response::errorInParametersResponse(json_encode(['message' => 'User ID required']));
        }
        return Response::errorResponse("unsupported parameters or method in users");
    }

    protected function getAllUsers() {
        $users = User::getList();
        $usersArray = array_map(function($user) {
            return [
                'id' => $user->USER_ID,
                'login' => $user->USER_LOGIN,
                'email' => $user->USER_EMAIL,
                'role' => $user->USER_ROLE,
                'name' => $user->USER_NAME,
                'surname' => $user->USER_SURNAME
            ];
        }, $users);
        return Response::okResponse(json_encode($usersArray));
    }

    protected function getUserById($id) {
        $user = User::getById($id);
        if ($user) {
            $userArray = [
                'id' => $user->USER_ID,
                'login' => $user->USER_LOGIN,
                'email' => $user->USER_EMAIL,
                'role' => $user->USER_ROLE,
                'name' => $user->USER_NAME,
                'surname' => $user->USER_SURNAME
            ];
            return Response::okResponse(json_encode($userArray));
        }
        return Response::notFoundResponse(json_encode(['message' => "User with ID $id not found"]));
    }

    protected function updateUser($id) {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data || !is_array($data)) {
            return Response::errorInParametersResponse(json_encode(['message' => 'Invalid JSON data']));
        }

        $existingUser = User::getById($id);
        if (!$existingUser) {
            return Response::notFoundResponse(json_encode(['message' => "User with ID $id not found"]));
        }

        $success = User::update($id, $data);
        if ($success) {
            $updatedUser = User::getById($id);
            $userArray = [
                'id' => $updatedUser->USER_ID,
                'login' => $updatedUser->USER_LOGIN,
                'email' => $updatedUser->USER_EMAIL,
                'role' => $updatedUser->USER_ROLE,
                'name' => $updatedUser->USER_NAME,
                'surname' => $updatedUser->USER_SURNAME
            ];
            return Response::okResponse(json_encode($userArray));
        }
        return Response::serverErrorResponse(json_encode(['message' => 'Failed to update user']));
    }

    protected function createUser() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data || !is_array($data) || empty($data['login']) || empty($data['email']) || empty($data['role']) || empty($data['pwd'])) {
            return Response::errorInParametersResponse(json_encode(['message' => 'Missing required fields (login, email, role, pwd)']));
        }

        $newId = User::create($data);
        if ($newId) {
            $newUser = User::getById($newId);
            $userArray = [
                'id' => $newUser->USER_ID,
                'login' => $newUser->USER_LOGIN,
                'email' => $newUser->USER_EMAIL,
                'role' => $newUser->USER_ROLE,
                'name' => $newUser->USER_NAME,
                'surname' => $newUser->USER_SURNAME
            ];
            return Response::okResponse(json_encode($userArray));
        }
        return Response::serverErrorResponse(json_encode(['message' => 'Failed to create user']));
    }

    protected function deleteUser($id) {
        $existingUser = User::getById($id);
        if (!$existingUser) {
            return Response::notFoundResponse(json_encode(['message' => "User with ID $id not found"]));
        }

        $success = User::delete($id);
        if ($success) {
            return Response::okResponse(json_encode(['message' => "User with ID $id deleted"]));
        }
        return Response::serverErrorResponse(json_encode(['message' => 'Failed to delete user']));
    }
}