<?php
if (!current_user_can('manage_options')) {
    wp_die(__('Você não tem permissão suficiente para acessar esta página.'));
}

function sanitize_whatsapp_number($number) {
    return preg_replace('/[^0-9]/', '', $number); // Remove caracteres não numéricos
}

// Salva as configurações se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $whatsapp_numbers = array();

    if (isset($_POST['whatsapp_numbers']) && isset($_POST['whatsapp_messages'])) {
        $posted_numbers = $_POST['whatsapp_numbers'];
        $posted_messages = $_POST['whatsapp_messages'];

        foreach ($posted_numbers as $index => $posted_number) {
            $number = sanitize_whatsapp_number($posted_number);
            $message = sanitize_text_field($posted_messages[$index]);

            if (preg_match('/^\d{10,15}$/', $number)) {
                $whatsapp_numbers[] = ['whatsapp_number' => $number, 'message' => $message];
            }
        }

        update_option('ticketz_rotator_numbers', json_encode($whatsapp_numbers));
    }
}

// Recupera as configurações salvas
$whatsapp_numbers = json_decode(get_option('ticketz_rotator_numbers', '[]'), true);
?>

<div class="wrap">
    <h2>Ticketz Rotator Settings</h2>
    <form method="post" action="">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Números de WhatsApp</th>
                <td>
                    <?php foreach ($whatsapp_numbers as $number): ?>
                        <input type="text" name="whatsapp_numbers[]" value="<?php echo esc_attr($number['whatsapp_number']); ?>" pattern="^\d{10,15}$" required />
                        <input type="text" name="whatsapp_messages[]" value="<?php echo esc_attr($number['message']); ?>" required /><br>
                    <?php endforeach; ?>
                    <input type="text" name="whatsapp_numbers[]" pattern="^\d{10,15}$" />
                    <input type="text" name="whatsapp_messages[]" /><br>
                    <p class="description">Insira os números de WhatsApp. Cada número deve ter entre 10 e 15 dígitos.</p>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="Salvar Alterações" />
        </p>
    </form>
</div>
