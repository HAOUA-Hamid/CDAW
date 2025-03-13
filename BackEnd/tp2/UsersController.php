<?php

class UsersController {
    private $requestMethod;
    private $userId;

    public function __construct($requestMethod, $userId = null) {
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getUser($this->userId);
                } else {
                    $response = $this->getAllUsers();
                }
                break;
            case 'POST':
                $response = $this->createUser();
                break;
            case 'PUT':
                if ($this->userId) {
                    $response = $this->updateUser($this->userId);
                } else {
                    $response = $this->unprocessableEntityResponse();
                }
                break;
            case 'DELETE':
                if ($this->userId) {
                    $response = $this->deleteUser($this->userId);
                } else {
                    $response = $this->unprocessableEntityResponse();
                }
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllUsers() {
        $users = UserModel::getAllUsers();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($users);
        return $response;
    }

    private function getUser($id) {
        $user = UserModel::getUserById($id);
        if (!$user) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($user);
        return $response;
    }

    private function createUser() {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['name']) || !isset($input['email'])) {
            return $this->unprocessableEntityResponse();
        }

        $userId = UserModel::createUser($input['name'], $input['email']);
        if ($userId) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(["id" => $userId]);
            return $response;
        }

        return $this->serverErrorResponse();
    }

    private function updateUser($id) {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['name']) || !isset($input['email'])) {
            return $this->unprocessableEntityResponse();
        }

        $updated = UserModel::updateUser($id, $input['name'], $input['email']);
        if ($updated) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(["message" => "User updated"]);
            return $response;
        }

        return $this->notFoundResponse();
    }

    private function deleteUser($id) {
        $deleted = UserModel::deleteUser($id);
        if ($deleted) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(["message" => "User deleted"]);
            return $response;
        }

        return $this->notFoundResponse();
    }

    private function notFoundResponse() {
        return [
            'status_code_header' => 'HTTP/1.1 404 Not Found',
            'body' => json_encode(["message" => "User not found"])
        ];
    }

    private function unprocessableEntityResponse() {
        return [
            'status_code_header' => 'HTTP/1.1 422 Unprocessable Entity',
            'body' => json_encode(["message" => "Invalid input"])
        ];
    }

    private function serverErrorResponse() {
        return [
            'status_code_header' => 'HTTP/1.1 500 Internal Server Error',
            'body' => json_encode(["message" => "Something went wrong"])
        ];
    }
}
?>
