<?php
// Webhook de Teams
$webhookUrl = "https://unicesareduco.webhook.office.com/webhookb2/c06da63b-a905-47f0-93da-b0006a95a69b@e2bf1c48-1dae-47ba-9808-67da61e2588d/IncomingWebhook/77101925423a4dddb82271b3c6673b2e/27b15873-77b0-406c-8137-c6aca39b17af/V2MwoXu1HEOBbNvFQhSGUxqdw4ewuWHxdGscDxGajx4OI1";

// Capturar datos del formulario
$name    = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'No especificado';
$email   = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'No especificado';
$message = isset($_POST['soporte']) ? htmlspecialchars($_POST['soporte']) : 'No especificado';

// Armamos la tarjeta AdaptiveCard
$cardData = [
    "type" => "message",
    "attachments" => [
        [
            "contentType" => "application/vnd.microsoft.card.adaptive",
            "content" => [
                "\$schema" => "http://adaptivecards.io/schemas/adaptive-card.json",
                "type" => "AdaptiveCard",
                "version" => "1.4",
                "body" => [
                    [
                        "type" => "TextBlock",
                        "size" => "Large",
                        "weight" => "Bolder",
                        "text" => "📩 Soporte Frigidaire",
                        "color" => "Accent"
                    ],
                    [
                        "type" => "TextBlock",
                        "text" => "👤 Nombre: $name",
                        "wrap" => true
                    ],
                    [
                        "type" => "TextBlock",
                        "text" => "📧 Email: $email",
                        "wrap" => true
                    ],
                    [
                        "type" => "TextBlock",
                        "text" => "💬 Mensaje: $message",
                        "wrap" => true
                    ]
                ]
            ]
        ]
    ]
];

// Convertimos a JSON
$jsonData = json_encode($cardData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Inicializamos cURL
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutamos
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Mostrar alerta y redirigir
echo "<script>
    alert('✅ Mensaje enviado, pronto un asesor se contactará contigo');
    window.location.href = 'index.php';
</script>";