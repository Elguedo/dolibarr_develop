<?php
require_once '../../vendor/autoload.php';

use Statickidz\GoogleTranslate;

// Función para detectar el idioma del navegador del usuario
function detectLanguage()
{
    if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        return $languages[0];
    }
    return 'en'; // Idioma por defecto si no se detecta ningún idioma
}
// Obtener el idioma detectado
$detectedLanguage = detectLanguage();

$errorMessages = [
  'en' => 'Sorry. You are not allowed to access this resource.',
  'es' => 'No está autorizado para acceder a este recurso.',
  // Agrega más mensajes de error en diferentes idiomas según sea necesario
];

// Verificar si se ha definido un mensaje de error para el idioma detectado
if (isset($errorMessages[$detectedLanguage])) {
  $errorMessage = $errorMessages[$detectedLanguage];
} else {
  // Si no hay un mensaje de error definido para el idioma detectado, usa el mensaje por defecto en inglés
  $errorMessage = $errorMessages['en'];
}

// Traducir el mensaje de error si no está en el idioma por defecto
if ($detectedLanguage !== 'en') {
  $translate = new GoogleTranslate();
  $translatedErrorMessage = $translate->translate('en', $detectedLanguage, $errorMessage);
} else {
  $translatedErrorMessage = $errorMessage;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Dolibarr 401 error page</title>
  </head>

  <body>
    <div>
      <h1>Error</h1>
      <br>
      <?php echo $translatedErrorMessage; ?>
      <br>
      <?php echo isset($_SERVER["HTTP_REFERER"]) ? 'You come from '.htmlentities($_SERVER["HTTP_REFERER"], ENT_COMPAT, 'UTF-8').'.' : ''; ?>
      <hr>
    </div>
  </body>
</html>
