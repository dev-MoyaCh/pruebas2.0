<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Inventario') ?> — Sistema MVC</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<header>
    <h1>📦 Sistema de Inventario <small style="font-size:14px; opacity:0.7;">MVC + POO</small></h1>
</header>

<nav>
    <a href="index.php?controller=dashboard&action=index">🏠 Dashboard</a>
    <a href="index.php?controller=productos&action=index">📦 Productos</a>
    <a href="index.php?controller=movimientos&action=index">🔄 Movimientos</a>
    <a href="index.php?controller=movimientos&action=historial">📜 Historial</a>
</nav>

<main class="container">