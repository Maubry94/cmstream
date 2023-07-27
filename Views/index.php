<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- general -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName ?><?= $title ? " - " . $title : "" ?></title>
    <meta name="title" content="<?= $appName ?><?= $title ? " - " . $title : "" ?>">
    <meta name="description" content="<?= $description ? $description : "Streamez en toute simplicité." ?>">
    <meta name="theme-color" content="#5499C7" />
    <?= $keywords ? "<meta name=\"keywords\" content=\"$keywords\">" : '' ?>
    <!-- facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>">
    <meta property="og:title" content="<?= $appName ?><?= $title ? " - " . $title : "" ?>">
    <meta property="og:description" content="<?= $description ? $description : "Streamez en toute simplicité." ?>">
    <meta property="og:image" content="<?= $thumbnail ? $thumbnail : "/public/img/icons/logo-big.png" ?>">
    <!-- twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="<?= $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>">
    <meta property="twitter:title" content="<?= $appName ?><?= $title ? " - " . $title : "" ?>">
    <meta property="twitter:description" content="<?= $description ? $description : "Streamez en toute simplicité." ?>">
    <meta property="twitter:image" content="<?= $thumbnail ? $thumbnail : "/public/img/icons/logo-big.png" ?>">
    <link rel="icon" href="/public/img/icons/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer base {
            :root {
                --color-black: #000;
                --color-blackless: #141519;
                --color-darkblue: #23252B;
                --color-midblue: #000AFF;
                --color-skyblue: #5499C7;
                --color-grey: #A0A0A0;
                --color-darkgrey: #797979;
                --color-whitesmoke: #F9FAFB;
                --color-whiteless: #DADADA;
                --color-white: #FFF;
                --color-adminblack: #23252B;
                --color-adminblacker: #141519;
                --color-lightgrey: #F5F5F9;
                --color-pinkred: #DD1533;
                --color-pinkredhover: #dd1533ca;
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        black: "var(--color-black)",
                        blackless: "var(--color-blackless)",
                        darkblue: "var(--color-darkblue)",
                        midblue: "var(--color-midblue)",
                        skyblue: "var(--color-skyblue)",
                        grey: "var(--color-grey)",
                        darkgrey: "var(--color-darkgrey)",
                        whitesmoke: "var(--color-whitesmoke)",
                        whiteless: "var(--color-whiteless)",
                        white: "var(--color-white)",
                        adminblack: "var(--color-adminblack)",
                        adminblacker: "var(--color-adminblacker)",
                        lightgrey: "var(--color-lightgrey)",
                        pinkred: "var(--color-pinkred)",
                        pinkredhover: "var(--color-pinkredhover)",
                    },
                }
            },
        }
  </script>
  <script type="module" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="module" src="https://www.unpkg.com/toanotherback@2.1.5/dist/taob.min.mjs"></script>
  <script type="module" src="/public/cuteVue/main.js" defer></script>
  <style>
        body {
            background-color: #000;
            color: #DADADA;
        }
  </style>
</head>
<body>
    <div 
    id="app"
    class="w-full h-[100vh] flex items-center justify-center text-[50px] text-center"
    >
        Chargement de la page en cours...
    </div>
</body>
</html>