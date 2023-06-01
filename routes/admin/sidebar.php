<?php

use App\Facades\Admin\Sidebar;

Sidebar::link('Dashboard', 'admin.home');

Sidebar::section('', function () {
    Sidebar::link('Категории', 'admin.category');
});

Sidebar::section('Товары', function () {
    Sidebar::link('Карточки Товаров', 'admin.product');
    Sidebar::link('Данные товаров', 'admin.products.content');
    Sidebar::link('Характеристики', 'admin.characteristic');
});

Sidebar::section('Ресурсы', function () {
    Sidebar::link('Пользователи', 'admin.user');
    Sidebar::link('Акции', 'admin.offer');
});

Sidebar::section('Заказы', function () {
    Sidebar::link('Заказы', 'admin.order');
});

Sidebar::section('Настройки', function () {
    Sidebar::link('Доступы', 'admin.access');
});