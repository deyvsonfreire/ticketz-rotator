<?php

// Função para criar a tabela quando o plugin for ativado
function ticketz_rotator_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ticketz_rotator';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        whatsapp_number varchar(255) NOT NULL,
        message text NOT NULL,
        click_count mediumint(9) DEFAULT 0,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'ticketz_rotator_create_table');

// Função para adicionar um número
function ticketz_rotator_add_number($number, $message) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ticketz_rotator';

    $wpdb->insert(
        $table_name,
        array(
            'whatsapp_number' => $number,
            'message' => $message,
        )
    );
}

// Função para obter os números
function ticketz_rotator_get_numbers() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ticketz_rotator';

    return $wpdb->get_results("SELECT * FROM $table_name");
}

// Função para incrementar o clique
function ticketz_rotator_increment_click($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ticketz_rotator';

    $wpdb->query($wpdb->prepare("UPDATE $table_name SET click_count = click_count + 1 WHERE id = %d", $id));
}

// Função para validar o número de WhatsApp
function ticketz_rotator_validate_whatsapp_number($number) {
    return preg_match('/^55\d{10,11}$/', $number); // Adapte conforme necessário
}
?>
