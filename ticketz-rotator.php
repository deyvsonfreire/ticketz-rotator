<?php
/**
 * Plugin Name: Ticketz Rotator
 * Description: Este plugin roteia números de WhatsApp e monitora cliques, incluindo uma função de codificação de sessionID.
 * Version: 1.0
 * Author: Deyvson
 */

// Incluir arquivos necessários
require_once plugin_dir_path(__FILE__) . 'admin/menu.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Enfileirar scripts
function ticketz_rotator_enqueue_scripts() {
    wp_enqueue_script('ticketz-rotator', plugin_dir_url(__FILE__) . 'public/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'ticketz_rotator_enqueue_scripts');

// Inicializar o plugin
function ticketz_rotator_init() {
    // Registre post types, taxonomias, ou outras inicializações aqui
}
add_action('init', 'ticketz_rotator_init');

// Inicializar configurações de administração
function ticketz_rotator_admin_init() {
    // Inicializar as configurações de administração aqui
}
add_action('admin_init', 'ticketz_rotator_admin_init');
