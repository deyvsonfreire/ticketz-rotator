<?php
// Função para adicionar o menu
function ticketz_rotator_menu() {
    add_menu_page(
        'Ticketz Rotator Settings',   // Título da página
        'Ticketz Rotator',            // Título do menu
        'manage_options',             // Capacidade
        'ticketz_rotator',            // Slug do menu
        'ticketz_rotator_settings_page', // Função de callback
        'dashicons-admin-links',      // Ícone
        80                            // Posição no menu
    );
}

// Função de callback para renderizar a página de configurações
function ticketz_rotator_settings_page() {
    include plugin_dir_path(__FILE__) . 'settings.php';
}

// Adicionar ação para criar o menu
add_action('admin_menu', 'ticketz_rotator_menu');
