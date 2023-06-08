<?php
namespace Core;

use Core\Request;
use Core\Floor;
use Core\Response;

abstract class Controller {
    protected Floor $floor;

    public function __construct(Request $request, Response $response){
        $this->floor = new Floor();
        if(method_exists($this, "extendCheckers") === true){
            $extendCheckers = "extendCheckers";
            $extendCheckers = $this->$extendCheckers($request);
            self::launchCheckers($extendCheckers, $this->floor, $response);
        } 
        
        $checkers = $this->checkers($request);
        self::launchCheckers($checkers, $this->floor, $response);

        if(method_exists($this, "extendHandler") === true){
            $extendHandler = "extendHandler";
            $this->$extendHandler($request, $response);
        }
        $this->handler($request, $response);
    }
    
    abstract public function checkers(Request $request): array;
    abstract public function handler(Request $request, Response $response): void;

    static private function launchCheckers(array $checkers, Floor $floor, Response $response): void
    {
        $lastChecker = "";

        try{
            foreach($checkers as $checker){
                $function = self::autoLoadChecker($checker[0]);
                $lastChecker = $function;
                if(is_callable($checker[1])){
                    $checker[1] = $checker[1]();
                }
                $value = $function($checker[1], $floor, $response);
                $floor->droped($checker[2] ?? $checker[0], $value);
            }
        }
        catch(\TypeError $th){
            $data = [
                "info" => "Checker type error.",
                "message" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine(),
                "checker" => $lastChecker
            ];
            
            $response->code(400)->info("ERROR.BAD_TYPE")->send($data);
        }
    }

    static function autoLoadChecker(string $checker): string
    {
        $function = "checker/{$checker}";
        $function = str_replace("/", "\\", $function);
        $function = str_replace("\\\\", "\\", $function);
        $function = rtrim($function, "\\");
        
        if(function_exists($function) === false){
            $path = explode("/", rtrim($checker, "/"));
            array_pop($path);
            $path = __DIR__ ."/../Checker/" . implode("/", $path) . ".php";
            
            if(file_exists($path) === false)
            {
                die("File '" . $path . "' not exist.");
            }

            include $path;

            if(function_exists($function) === false)
            {
                die("Function '" . $function . "' not exist.");
            }
        }

        return $function;
    }
}

abstract class OverrideController extends Controller {
    public function extendCheckers(Request $request): array
    {
        return [];
    }

    public function extendHandler(Request $request, Response $response): void
    {
        
    }
}

abstract class LiteController {
    public function __construct(Request $request, Response $response){
        $this->handler($request, $response);
    }
    abstract public function handler(Request $request, Response $response): void;
}

function callChecker(string $checker, mixed $value){
    $checkerFunction = Controller::autoLoadChecker($checker);
    $floor = new Floor();
    try{
        return $checkerFunction($value, $floor, Response::getCurrentResponse());
    }
    catch(\TypeError $th){
        $data = [
            "info" => "Checker type error.",
            "message" => $th->getMessage(),
            "file" => $th->getFile(),
            "line" => $th->getLine(),
            "checker" => $checkerFunction
        ];
        
        Response::getCurrentResponse()->code(400)->info("ERROR.BAD_TYPE")->send($data);
    }
}