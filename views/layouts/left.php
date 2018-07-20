<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Основные', 'options' => ['class' => 'header']],
                    ['label' => 'Организации', 'icon' => 'building', 'url' => ['/company']],
                    ['label' => 'Настройки', 'options' => ['class' => 'header']],
                    ['label' => 'Шаблоны', 'icon' => 'list-alt', 'url' => '/template'],
                    ['label' => 'Переменные', 'icon' => 'at', 'url' => '/variable'],
                    ['label' => 'Профили', 'icon' => 'sitemap', 'url' => '/profile'],
                ],
            ]
        ) ?>

    </section>

</aside>
