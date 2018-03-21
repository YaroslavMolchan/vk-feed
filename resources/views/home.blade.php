<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>VK Feed mBot</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="/css/grayscale.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <a class="navbar-brand" href="#page-top">VK Feed mBot</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#about">О боте</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#connect">Подключение</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contact">Контакты</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Intro Header -->
<header class="masthead">
    <div class="intro-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="brand-heading">VK Feed mBot</h1>
                    <p class="intro-text">Перенесите свою стену из VK в Telegram.</p>
                    <a href="#about" class="btn btn-circle page-scroll">
                        <i class="fa fa-angle-double-down animated"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- About Section -->
<section id="about" class="content-section text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>О боте</h2>
                <p>Бот с помощью VK API получает новостную ленту с Вашей страницы и перенаправляет сообщения в чат с ботом.</p>
                <p>Так же бот пропускает рекламные посты и посты с ссылками (возможно в будущем с ссылками будет доставлять)</p>
                <p>Сообщения доставляются 1 раз в минуту, ограничение на стену в 60 сообщений в минуту, если на стене их больше - придут первые 60.</p>
                <p>Рекомендую настроить стену и добавить только те группы и паблики которые действительно надо, потому что может быть куча спама и лишних постов.</p>
                <p><strong>Важно.</strong> По поводу предупреждения VK чтобы не передавать код, действительно узнав код можно получить много данных с аккаунта.</p>
                <p>Но в данном случае разрешение выдается только на те вещи, которые нужны для просмотра Вашей стены и не более.</p>
            </div>
        </div>
    </div>
</section>

<!-- Download Section -->
<section id="connect" class="download-section content-section text-center">
    <div class="container">
        <div class="col-lg-8 mx-auto">
            <h2>Подключение</h2>
            <p>1. Начните чат с <a href="https://t.me/vkfeedmbot" target="_blank">ботом</a> написав /start.</p>
            <p>2. <a href="{!! route('login') !!}" target="_blank">Разрешите</a> боту просматривать вашу стену VK.</p>
            <p>3. Скопируйте URL на который вы были перенаправлены после разрешения и вставьте его <a class="form-toggler" href="#">сюда</a>.
                <div class="code-form">
                    @if(empty($telegramId) || !ctype_digit($telegramId))
                        <p class="text-warning" style="margin-bottom: 5px;">Мы не знаем ваш Telegram ID. Перейдите по ссылке, которую вам дал бот.</p>
                    @endif
                    <form action="{!! route('register') !!}">
                        <input type="input" class="input" name="code" />
                        <input type="hidden" name="telegram_id" value="{!! $telegramId !!}" />
                        <input type="submit" class="btn-default" value="OK" />
                    </form>
                </div>
            </p>
            <p>4. Читайте ленту новостей в чате с ботом. (Рекомендую отключить уведомления от бота)</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="content-section text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Контакты</h2>
                <p>Если у вас есть вопросы или предложения можете связаться со мной.</p>
                <ul class="list-inline banner-social-buttons">
                    <li class="list-inline-item">
                        <a href="https://twitter.com/MolchanYaroslav" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://t.me/YaroslavMolchan" class="btn btn-default btn-lg"><i class="fa fa-telegram fa-fw"></i> <span class="network-name">Telegram</span></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.facebook.com/yaroslav.molchan" class="btn btn-default btn-lg"><i class="fa fa-facebook-official fa-fw"></i> <span class="network-name">Facebook</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<div id="map"></div>

<!-- Footer -->
<footer>
    <div class="container text-center">
        <p>Copyright &copy; Jadson {!! date('Y') !!}</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/js/jquery.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/sweetalert2.all.js"></script>

<!-- Plugin JavaScript -->
<script src="/js/jquery.easing.min.js"></script>

<!-- Custom scripts for this template -->
<script src="/js/grayscale.js"></script>

</body>

</html>
