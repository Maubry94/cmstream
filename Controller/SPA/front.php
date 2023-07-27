<?php

namespace Controller\SPA\front;

use Core\File;
use Core\LiteController;
use Core\Logger;
use Services\IndexHandler;
use Core\Request;
use Core\Response;
use Entity\Episode;
use Entity\Movie;
use Entity\Serie;
use Services\Permissions;

/**
 * @GET{/}
 * @GET{/catalogue}
 * @GET{/pages/{name}}
 * @GET{/notfound}
 */
class index extends IndexHandler{}

/**
 * @GET{/connexion}
 * @GET{/inscription}
 * @GET{/validation}
 * @GET{/mot-de-passe-oublie}
 */
class guest extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyGuest", $request->getCookie("token") ?? ""]
        ];
    }
}

/**
 * @GET{/reinitialiser-mot-de-passe}
 */
class resetPassword extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyResetPasswordToken", str_replace(" ", "+", $request->getQuery("token")) ?? ""]
        ];
    }
}

/**
 * @GET{/lists}
 * @GET{/compte}
 */
class connected extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyConnected", $request->getCookie("token") ?? ""]
        ];
    }
}

/**
 * @GET{/dashboard}
 */
class admin extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyConnected", "", "user"],
            ["page/mustHavePermission", Permissions::AccessDashboard]
        ];
    }
}

/**
 * @GET{/dashboard/utilisateurs}
 */
class adminUser extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyConnected", "", "user"],
            ["page/mustHavePermission", Permissions::AccessDashboard],
            ["page/mustHavePermission", Permissions::UserEditor]
        ];
    }
}

/**
 * @GET{/dashboard/roles}
 */
class adminRole extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyConnected", "", "user"],
            ["page/mustHavePermission", Permissions::AccessDashboard],
            ["page/mustHavePermission", Permissions::RoleEditor]
        ];
    }
}

/**
 * @GET{/dashboard/config-app}
 * @GET{/dashboard/config-mail}
 */
class adminConfig extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyConnected", "", "user"],
            ["page/mustHavePermission", Permissions::AccessDashboard],
            ["page/mustHavePermission", Permissions::ConfigEditor]
        ];
    }
}

/**
 * @GET{/dashboard/commentaires}
 */
class dashboardManager extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyConnected", "", "user"],
            ["page/mustHavePermission", Permissions::AccessDashboard],
            ["page/mustHavePermission", Permissions::CommentsManager],
        ];
    }
}

/**
 * @GET{/dashboard/ajouter-contenu}
 * @GET{/dashboard/categories}
 * @GET{/dashboard/editer-video/{typeEdit}/{id}}
 * @GET{/dashboard/series}
 * @GET{/dashboard/films}
 * @GET{/dashboard/pages}
 */
class adminContent extends IndexHandler
{
    public function checkers(Request $request): array
    {
        return [
            ["page/onlyConnected", "", "user"],
            ["page/mustHavePermission", Permissions::AccessDashboard],
            ["page/mustHavePermission", Permissions::ContentsManager]
        ];
    }
}

/**
 * @GET{/film/{id}}
 */
class GetMovie extends IndexHandler{
    public function extendHandler(Request $request, Response $response): void
    {
        $movie = Movie::findFirst(["id" => $request->getParam("id")]);
        if($movie === null){ 
            $this->code = 404;
            return;
        }

        $this->title = $movie->getTitle();
        $this->description = $movie->getDescription();
        $this->keywords = "streaming, {$movie->getTitle()}, movie";

    }
}

/**
 * @GET{/serie/{id}}
 */
class GetSerie extends IndexHandler{
    public function extendHandler(Request $request, Response $response): void
    {
        $serie = Serie::findFirst(["id" => $request->getParam("id")]);
        if($serie === null){
            $this->code = 404;
            return;
        }

        $this->title = $serie->getTitle();
        $this->description = $serie->getDescription();
        $this->keywords = "streaming, {$serie->getTitle()}, serie";
    }
}

/**
 * @GET{/serie/{id}/saison/{season}/episode/{episode}}
 */
class GetEpisode extends IndexHandler{
    public function extendHandler(Request $request, Response $response): void
    {
        $episode = Episode::findFirst([
            "serie_id" => $request->getParam("id"), 
            "season" => $request->getParam("season"),
            "episode" => $request->getParam("episode")
        ]);
        if($episode === null){
            $this->code = 404;
            return;
        }
        if($request->getHeader("Page-Access") === null){
            $this->description = $episode->getDescription();
            $this->keywords = "streaming, {$episode->getTitle()}, s{$episode->getSeason()}, ep{$episode->getEpisode()}, episode";
        }
    }
}

/**
 * @GET{/sitemap.xml}
 */
class GetSitemap extends LiteController
{
    public function handler(Request $request, Response $response): void
    {
        $pages = new File(__DIR__ . "/../../public/cuteVue/pages.json");
        
        $vars = [
            "config" => CONFIG,
            "pages" => json_decode($pages->read(), true),
            "movies" => Movie::findIterator([]),
            "episodes" => Episode::findIterator([]),
        ];

        $response->code(200)->info("sitemap")->setHeader("Content-Type", "text/html")->render("sitemap", "none", $vars);
    }
}
