<?php
namespace Services;

use Core\Logger;
use Core\OverrideController;
use Core\Request;
use Core\Response;

abstract class IndexHandler extends OverrideController{
    public int $code = 200;

    public string $appName = CONFIG["APP_NAME"];
    public ?string $title = null;
    public ?string $description = null;
    public ?string $keywords = null;

    public function extendCheckers(Request $request): array
    {
        return [];
    }

    public function checkers(Request $request): array
    {
        return [];
    }

    public function handler(Request $request, Response $response): void
    {
        if($request->getHeader("Page-Access") !== null){
            $response
            ->code($this->code)
            ->setHeader("App-Name", $this->appName)
            ->setHeader("Page-Title", $this->title)
            ->addExpose("App-Name")
            ->addExpose("Page-Title")
            ->send();
        }

        $response
        ->code($this->code)
        ->render(
            "index", 
            "none", 
            [
                "appName" => $this->appName,
                "title" => $this->title,
                "description" => $this->description,
                "keywords" => $this->keywords
            ]
        );
    }
}
