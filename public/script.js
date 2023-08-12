jQuery(document).ready(function ($) {
    // Função para gerar um ID de sessão único
    function generateSessionID() {
        return Math.floor(Math.random() * 8999999999) + 1000000000; // Gera um número aleatório de 10 dígitos
    }

    // Função para obter o sessionID do cookie ou gerar um novo
    function getSessionID() {
        var name = "sessionID=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        // Se não encontrar o sessionID, gera um novo
        var newSessionID = generateSessionID();
        document.cookie = "sessionID=" + newSessionID + "; path=/";
        return newSessionID;
    }

    // Função para codificar o sessionID
    function encodeSessionID(num) {
        var NON_PRINTABLES = ['\u200a', '\u200b', '\u200c', '\u200d', '\u200e'];
        var base = NON_PRINTABLES.length;
        var output = "";

        while (num > 0) {
            output = NON_PRINTABLES[num % base] + output; // MSB -> LSB
            num = Math.floor(num / base);
        }

        return output;
    }

    // Obter números de WhatsApp e mensagem inicial
    var whatsappNumbers = ticketz_rotator_data.numbers; // Definido no PHP
    var whatsappMessage = ticketz_rotator_data.message; // Definido no PHP
    var sessionID = getSessionID();
    var encodedSessionID = encodeSessionID(sessionID);

    // Substituir todos os botões do WhatsApp
    $('.whatsapp-button').each(function (index) {
        var numberIndex = index % whatsappNumbers.length;
        var whatsappNumber = whatsappNumbers[numberIndex];
        var whatsappUrl = "https://api.whatsapp.com/send/?phone=" + whatsappNumber + "&text=" + encodedSessionID + whatsappMessage;
        $(this).attr('href', whatsappUrl);
    });
});
