<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= $config['HOST'] ?></loc>

        <changefreq>always</changefreq>

        <priority>0.5</priority>
    </url>

    <url>
        <loc><?= $config['HOST'] ?>/catalogue</loc>

        <changefreq>weekly</changefreq>

        <priority>0.5</priority>
    </url>

    <url>
        <loc><?= $config['HOST'] ?>/inscription</loc>

        <priority>0</priority>
    </url>

    <url>
        <loc><?= $config['HOST'] ?>/connexion</loc>

        <priority>0</priority>
    </url>

    <url>
        <loc><?= $config['HOST'] ?>/notfound</loc>

        <priority>0</priority>
    </url>

    <url>
        <loc><?= $config['HOST'] ?>/mot-de-passe-oublie</loc>

        <priority>0</priority>
    </url>

    <?php foreach($pages as $page) echo "
        <url>
            <loc>{$config['HOST']}/pages/{$page['name']}</loc>

            <changefreq>always</changefreq>

            <priority>0.5</priority>
        </url>
    ";?>

    <?php foreach($movies as $movie) echo "
        <url>
            <loc>{$config['HOST']}/film/{$movie->getId()}</loc>

            <lastmod>{$movie->getUpdatedAt()}</lastmod>

            <priority>1</priority>
        </url>
    ";?>

    <?php foreach($episodes as $episode) echo "
        <url>
            <loc>{$config['HOST']}/serie/{$episode->getSerieId()}/saison/{$episode->getSeason()}/episode/{$episode->getEpisode()}</loc>

            <lastmod>{$episode->getUpdatedAt()}</lastmod>

            <priority>1</priority>
        </url>
    ";?>
</urlset> 