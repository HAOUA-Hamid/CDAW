<?php
abstract class Controller {

    protected $name;
    protected $request;

    public function __construct($name, $request) {
        $this->request = $request;
        $this->name = $name;
    }

    public abstract function processRequest();

    public function execute() {
        $response = $this->processRequest();
        if (empty($response)) {
            $response = Response::serverErrorResponse("error processing request in " . static::class);
        }
        return $response;
    }
}