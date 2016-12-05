<aside class="main-sidebar">

    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    /*[
                        'label' => 'Пользователи',
                        'icon' => 'fa fa-users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Пользователи', 'icon' => 'fa fa-user-plus', 'url' => ['/user']],
                            ['label' => 'Роли', 'icon' => 'fa fa-user-secret', 'url' => ['/role']],
                            ['label' => 'Права', 'icon' => 'fa fa-key', 'url' => ['/permission']],
                        ],
                    ],*/
                    ['label' => 'Выход', 'icon' => 'fa fa-plug', 'url' => ['/site/logout']],
                ],
            ]
        ) ?>

    </section>

</aside>
