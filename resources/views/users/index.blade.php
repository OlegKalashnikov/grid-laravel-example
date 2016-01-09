<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Пользователи</title>
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<body ng-app="app">
<div class="container">
{!!
    $grid->render([
        'id' => [
            'title' => 'ИД',
            'type' => 'string',
            'class' => 'col-lg-1'
        ],
        'name' => [
            'title' => 'Имя',
            'type' => 'string',
        ],
        'email' => [
            'title' => 'E-Mail',
            'type' => 'string',
            'cell' => "<a href='mailto:@{{ item.email }}'>@{{ item.email }}</a>"
        ],
        'user_companies.title' => [
            'title' => 'Компания',
            'type' => 'multiselect',
            'options' => \App\UserCompany::query()->lists('title', 'id')
        ],
        'created_at' => [
            'title' => 'Создан',
            'type' => 'daterange',
            'cell' => "@{{ item.created_at | date:'dd.MM.yyyy HH:mm' }}",
            'data-class' => 'text-center',
            'class' => 'col-lg-2'
        ],
        'updated_at' => [
            'title' => 'Обновлен',
            'type' => 'daterange',
            'cell' => "@{{ item.created_at | date:'dd.MM.yyyy HH:mm' }}",
            'data-class' => 'text-center',
            'class' => 'col-lg-2'
        ]
    ])
 !!}
</div>

<script src="/js/scripts.js" type="application/javascript"></script>
</body>
</html>
