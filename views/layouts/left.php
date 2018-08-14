<?php
/**
 * @var $company \app\models\Company
 */
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?php
        $items = [];
        if ($company) {
            $subitems = [
                [
                    'label' => Yii::t('app', 'Kinds of activity'),
                    'url' => ['/ved', 'company_id' => $company->id],
                    'icon' => 'list',
                ],
                [
                    'label' => Yii::t('app', 'Employees'),
                    'url' => ['/employee', 'company_id' => $company->id],
                    'icon' => 'user',
                ],
                [
                    'label' => 'Переменные',
                    'url' => ['/company/var-index', 'id' => $company->id],
                    'icon' => 'at',
                ],
                [
                    'label' => 'Шаблоны',
                    'url' => ['/company/template-index', 'id' => $company->id],
                    'icon' => 'list-alt',
                ],
            ];
            $items = [
                [
                    'label' => $company->name,
//                    'options' => ['class' => 'header'],
                    'items' => $subitems,
                    'icon' => 'building',
                ],
            ];
        }
        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => array_merge($items, [
                    ['label' => 'Основные', 'options' => ['class' => 'header']],
                    ['label' => 'Организации', 'icon' => 'building', 'url' => ['/company']],
                    ['label' => 'Настройки', 'options' => ['class' => 'header']],
                    ['label' => 'Шаблоны', 'icon' => 'list-alt', 'url' => '/template'],
                    ['label' => 'Переменные', 'icon' => 'at', 'url' => '/variable'],
                    ['label' => 'Профили', 'icon' => 'sitemap', 'url' => '/profile'],
                ]),
            ]
        ) ?>

    </section>

</aside>
