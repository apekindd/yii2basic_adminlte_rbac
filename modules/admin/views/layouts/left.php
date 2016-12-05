<aside class="main-sidebar">

    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    [
                        'label' => 'Пользователи',
                        'icon' => 'fa fa-users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Пользователи', 'icon' => 'fa fa-user-plus', 'url' => ['/admin/user']],
                            ['label' => 'Роли', 'icon' => 'fa fa-user-secret', 'url' => ['/admin/role']],
                            ['label' => 'Права', 'icon' => 'fa fa-key', 'url' => ['/admin/permission']],
                        ],
                    ],
                    ['label' => 'Выход', 'icon' => 'fa fa-plug', 'url' => ['/site/logout']],
                ],
            ]
        ) ?>

    </section>

</aside>
