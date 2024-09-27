<?php

global $wpdb;
$table_config = $wpdb->prefix . 'atakx_config';
$table_config_cta = $wpdb->prefix . 'atakx_config_cta';
$config = $wpdb->get_row("SELECT * FROM $table_config LIMIT 1", ARRAY_A);
$config_cta = $wpdb->get_row("SELECT * FROM $table_config_cta LIMIT 1", ARRAY_A);

$api_key = "";
$description_business = "";
$name_business = "";
$key_words = "";
$is_image_general = 0;
$is_enable_cta = 0;
$is_with_content_table = 0;
$max_articles_per_month = 0;
$articles_per_week = 2;

$background_image = "";
$overlay_color = "";
$overlay_opacity = 0.5;
$title = "";
$button_title = "";
$button_color = "";
$font = "";
$lead_email = "";
$logo = "";
$with_rounded_border = 0;

if ($config) {
     $api_key = isset($config['api_key']) ? esc_attr($config['api_key']) : '';
     $name_business = isset($config['name_business']) ? esc_textarea($config['name_business']) : '';
     $description_business = isset($config['description_business']) ? esc_textarea($config['description_business']) : '';
     $key_words = isset($config['key_words']) ? esc_attr($config['key_words']) : '';
     $is_image_general = isset($config['is_image_general']) ? $config['is_image_general'] : 0;
     $is_enable_cta = isset($config['is_enable_cta']) ? $config['is_enable_cta'] : 0;
     $is_with_content_table = isset($config['is_with_content_table']) ? $config['is_with_content_table'] : 0;
     $articles_per_week = isset($config['articles_per_week']) ? intval($config['articles_per_week']) : 2;
     $max_articles_per_month = isset($config['max_articles_per_month']) ? intval($config['max_articles_per_month']) : 2;
}

if ($config_cta) {
     $background_image = isset($config_cta['background_image']) ? $config_cta['background_image'] : "";
     $overlay_color = isset($config_cta['overlay_color']) ? esc_attr($config_cta['overlay_color']) : "#fc6736";
     $overlay_opacity = isset($config_cta['overlay_opacity']) ? $config_cta['overlay_opacity'] : 0.5;
     $title = isset($config_cta['title']) ? esc_attr($config_cta['title']) : "";
     $button_title = isset($config_cta['button_title']) ? $config_cta['button_title'] : "";
     $button_color = isset($config_cta['button_color']) ? $config_cta['button_color'] : "#fc6736";
     $font = isset($config_cta['font']) ? $config_cta['font'] : "";
     $lead_email = isset($config_cta['lead_email']) ? $config_cta['lead_email'] : "";
     $logo = isset($config_cta['logo']) ? $config_cta['logo'] : "";
     $with_rounded_border = isset($config_cta['with_rounded_border']) ? $config_cta['with_rounded_border'] : 0;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <title>Configuración de Atakx Plugin</title>
</head>

<body>

     <div id="preview" class="atakx-preview">
          <div class="modal-content">
               <span class="close">&times;</span>
               <div id="cta-container" style="display: flex; flex-direction: row; justify-content: center; align-items: center; margin: 2rem; width: 900px; height: 380px; background-color: #f2f3f5;">
                    <style>
                         .cta-button:hover {
                              -webkit-box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.6);
                              -moz-box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.6);
                              box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.6);
                              transition: all 0.3s;
                         }

                         .cta-input[type="text"]:focus,
                         .cta-input[type="email"]:focus {
                              border: none;
                              outline: none;
                              box-shadow: none;
                         }
                    </style>
                    <div style="position: relative; width: 50%; height: 100%; display: flex; justify-content: center; align-items: center;">
                         <img id="prevLogoCTA" src="<?php echo $logo; ?>" style="z-index: 9; width: 150px;">
                         <img id="prevBackgroundImageCTA" src="<?php echo $background_image; ?>" style="position: absolute; top: 0; left: 0; object-fit: cover; width: 100%; height: 100%;">
                         <div id="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
                    </div>
                    <div style="width: 50%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem;">
                         <span id="prevTitleCTA" style="margin-left: 10px; margin-right: 10px; line-height: 2.5rem; font-size: 2.5rem; font-weight: 700;"></span>
                         <div style="display: flex; justify-content: space-between; width: 95%; margin-right: 10px; margin-left: 10px; gap: 10px;">
                              <div style="display: flex; flex-direction: column; width: 50%;">
                                   <label style="font-size: 16px; font-weight: 500; margin-bottom: 5px; color: #333;">Nombre:</label>
                                   <input class="cta-input" placeholder="Nombre" type="text" id="name" name="name" value="" style="background-color: #e8e9eb; padding: 5px; border: none; font-size: 14px; color: #333; width: 100%;">
                              </div>
                              <div style="display: flex; flex-direction: column; width: 50%;">
                                   <label style="font-size: 16px; font-weight: 500; margin-bottom: 5px; color: #333;">Correo electrónico:</label>
                                   <input class="cta-input" placeholder="Correo electrónico" type="email" id="email" name="email" value="" style="background-color: #e8e9eb; padding: 5px; border: none; font-size: 14px; color: #333; width: 100%;">
                              </div>
                         </div>
                         <button class="cta-button" id="prevButtonCTA" style="padding: 0.7rem 1.2rem; cursor: pointer; border: none; border-radius: 5px; color: white; font-size: 1.2rem; font-weight: 600;"></button>
                    </div>
               </div>
               <div id="message" class="cta-message" style="display: none;">
                    <span>Debes rellenar todos los campos del formulario para poder previsualizar el CTA.</span>
               </div>
          </div>
     </div>

     <div class="atakx-container">

          <div class="atakx-header">
               <img src="<?php echo plugin_dir_url(__FILE__) . '../assets/img/brand.png'; ?>" width="150px" />
               <p>Atakx / Creación de contenido, impulsado por AI</p>
          </div>

          <div class="atakx-sub-container">
               <div class="column-left">
                    <div class="atakx-banner">
                         <div class="atakx-banner-content">
                              <span class="atakx-banner-text">Publica entradas cada semana, sin esfuerzos</span>
                              <h2 style="color: white;">Impulsado con AI</h2>
                              <button class="atakx-banner-btn">MEJORAR AHORA</button>
                         </div>
                    </div>

                    <div class="atakx-forms-config">

                         <div class="atakx-center" style="padding: 1rem;">
                              <div class="atakx-congrats-container">
                                   <div class="atakx-flex" style="justify-content: space-between;">
                                        <span>¡Felicidades!</span>
                                        <span>&times;</span>
                                   </div>
                                   <p>Atakx ya está activado y está trabajando para tu sitio. Tu web empezará a posicionar mejor gracias a la estrategia de contenidos.</p>
                                   <p>Para garantizar resultados en el posicionamiento de tu página web, te recomendamos hacer seguimiento a palabras claves con poca dificultad y buen volumen de busquedas mensuales.</p>
                              </div>
                         </div>

                         <div class="atakx-section-head">
                              <h1 style="font-size: 1.5rem; color: #fc6736;">Primeros pasos</h1>
                              <div class="atakx-separator"></div>
                         </div>

                         <div class="atakx-center" style="padding: 1rem;">
                              <div class="atakx-firts-steps-container">
                                   <p>¿Cómo obtener tu API Key?</p>
                                   <p>¿Cómo seleccionar tus palabras claves?</p>
                                   <p>¿Qué es el CTA de Atakx?</p>
                                   <p>¿Con que frecuencia recomendamos publicar entradas?</p>
                              </div>
                         </div>

                         <div class="atakx-section-head">
                              <div class="atakx-flex">
                                   <div class="atakx-icon-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="30px" height="30px" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fc6736" class="size-6">
                                             <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                             <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                   </div>
                                   <h1 style="font-size: 1.5rem; color: #575757;">Configuración</h1>
                              </div>
                              <div class="atakx-separator-container">
                                   <div class="atakx-separator-wi"></div>
                                   <div class="atakx-separator"></div>
                              </div>
                         </div>

                         <form class="atakx-form" action="" id="form-config" method="post">

                              <div class="row">
                                   <label class="atakx-label" for="apiKey">API Key:</label>
                                   <input class="atakx-input" type="text" id="apiKey" name="apiKey" value="<?php echo $api_key; ?>" required>
                                   <p id="apiInvalid" style="display: none; color: #d60000;">Esta Api Key no es válida</p>
                                   <!-- <button class="atakx-button-sec" onclick="goto('https://app.atakx.com')" style="margin-right: 1rem; margin-top: 0.5rem;">Generar API Key</button> -->
                              </div>

                              <div class="row">
                                   <label class="atakx-label" for="nameBusiness">Nombre del negocio:</label>
                                   <input class="atakx-input" type="text" id="nameBusiness" name="nameBusiness" value="<?php echo $name_business; ?>" required>
                              </div>

                              <div class="row">
                                   <label class="atakx-label" for="descriptionBusiness">Descripción del negocio (lo más explicito posible):</label>
                                   <textarea class="atakx-textarea" id="descriptionBusiness" name="descriptionBusiness" rows="3" required><?php echo $description_business; ?></textarea>
                              </div>

                              <div class="row">
                                   <label class="atakx-label" for="keyWords">Palabras claves separadas por coma (,):</label>
                                   <input class="atakx-input" type="text" id="keyWords" name="keyWords" value="<?php echo $key_words; ?>" required>
                              </div>

                              <div class="row">
                                   <label class="atakx-label" for="isImageGeneral">¿Quieres que la imágen principal sea generada por IA?</label>
                                   <input class="atakx-input" type="checkbox" id="isImageGeneral" name="isImageGeneral" <?php checked($is_image_general, 1); ?>>
                              </div>

                              <div class="row">
                                   <label class="atakx-label" for="isEnableCta">¿Quieres habilitar CTA?</label>
                                   <input class="atakx-input" type="checkbox" id="isEnableCta" name="isEnableCta" <?php checked($is_enable_cta, 1); ?>>
                              </div>

                              <div class="row">
                                   <label class="atakx-label" for="isWithContentTable">¿Mostrar tabla de contenido?</label>
                                   <input class="atakx-input" type="checkbox" id="isWithContentTable" name="isWithContentTable" <?php checked($is_with_content_table, 1); ?>>
                              </div>

                              <div class="row-btn">
                                   <button class="atakx-button" type="submit">Guardar</button>
                              </div>
                         </form>

                         <?php if ($config && $is_enable_cta == 1): ?>

                              <div class="atakx-section-head">
                                   <div class="atakx-flex">
                                        <div class="atakx-icon-container">
                                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="30px" height="30px" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fc6736" class="size-6">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                                             </svg>
                                        </div>
                                        <h1 style="font-size: 1.5rem; color: #575757;">Call to actions (CTA)</h1>
                                   </div>
                                   <div class="atakx-separator-container">
                                        <div class="atakx-separator-wi"></div>
                                        <div class="atakx-separator"></div>
                                   </div>
                              </div>

                              <form class="atakx-form" action="" id="form-cta" method="post" enctype="multipart/form-data">

                                   <div class="row">
                                        <label class="atakx-label">Imagen de fondo:</label>
                                        <input class="atakx-input" type="file" id="backgroundImageCTA" name="backgroundImageCTA" accept="image/*" <?php if ($background_image == ""): ?>required<?php endif; ?>>
                                        <label class="atakx-label-file" id="labelBackgroundImageCTA" for="backgroundImageCTA"><span>Seleccione una imágen</span></label>
                                        <?php if ($background_image != ""): ?>
                                             <p>Imágen actual:</p>
                                             <img src="<?php echo esc_url($background_image); ?>" alt="Imagen actual" style="max-width: 120px;">
                                        <?php endif; ?>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label" for="overlayColor">Color de la capa superpuesta:</label>
                                        <input class="atakx-input" type="color" id="overlayColor" name="overlayColor" value="<?php echo $overlay_color; ?>" required>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label" for="overlayOpacity">Nivel de opacidad:</label>
                                        <input type="range" id="overlayOpacity" name="overlayOpacity" min="0" max="1" step="0.1" value="<?php echo $overlay_opacity; ?>" required>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label" for="titleCTA">Título:</label>
                                        <input class="atakx-input" type="text" id="titleCTA" name="titleCTA" value="<?php echo $title; ?>" required>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label" for="buttonTitleCTA">Título del botón:</label>
                                        <input class="atakx-input" type="text" id="buttonTitleCTA" name="buttonTitleCTA" value="<?php echo $button_title; ?>" required>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label" for="buttonColorCTA">Color del botón:</label>
                                        <input class="atakx-input" type="color" id="buttonColorCTA" name="buttonColorCTA" value="<?php echo $button_color; ?>" required>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label" for="CTAFont">Fuente tipográfica del CTA:</label>
                                        <input class="atakx-input" type="text" id="CTAFont" name="CTAFont" value="<?php echo $font; ?>" required>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label" for="leadEmail">Correo para los leads:</label>
                                        <input class="atakx-input" type="email" id="leadEmail" name="leadEmail" value="<?php echo $lead_email; ?>" required>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label">Logotipo:</label>
                                        <input class="atakx-input" type="file" id="logoCTA" name="logoCTA" accept="image/*" <?php if ($logo == ""): ?>required<?php endif; ?>>
                                        <label class="atakx-label-file" id="labelLogoCTA" for="logoCTA"><span>Seleccione una imágen</span></label>
                                        <?php if ($logo != ""): ?>
                                             <p>Logotipo actual:</p>
                                             <img src="<?php echo esc_url($logo); ?>" alt="Imagen actual" style="max-width: 120px;">
                                        <?php endif; ?>
                                   </div>

                                   <div class="row">
                                        <label class="atakx-label" for="roundedBordersCTA">Bordes redondeados:</label>
                                        <input class="atakx-input" type="checkbox" id="roundedBordersCTA" name="roundedBordersCTA" <?php checked($with_rounded_border, 1); ?>>
                                   </div>

                                   <div class="row-btn sec">
                                        <button id="openModalBtn" type="button" class="atakx-button-sec" style="margin-right: 1rem;">Vista previa del CTA</button>
                                        <button class="atakx-button" type="submit">Guardar</button>
                                   </div>
                              </form>

                         <?php endif; ?>

                         <?php if ($config): ?>

                              <div class="atakx-section-head">
                                   <div class="atakx-flex">
                                        <div class="atakx-icon-container">
                                             <svg xmlns="http://www.w3.org/2000/svg" fill="#fc6736" width="30px" height="30px" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fc6736" class="size-6">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                             </svg>
                                        </div>
                                        <h1 style="font-size: 1.5rem; color: #575757;">Programación semanal</h1>
                                   </div>
                                   <div class="atakx-separator-container">
                                        <div class="atakx-separator-wi"></div>
                                        <div class="atakx-separator"></div>
                                   </div>
                              </div>

                              <form class="atakx-form" action="" id="form-post-rate" method="post">

                                   <div class="row">
                                        <label class="atakx-label" for="articlesPerWeek">Seleccione la cantidad de artículos por semana:</label>
                                        <div class="atakx-select">
                                             <select name="articlesPerWeek" id="articlesPerWeek">
                                                  <option value="2" <?php if ($articles_per_week == 2): ?>selected<?php endif; ?>>2</option>
                                                  <?php if ($max_articles_per_month >= 4): ?><option value="4" <?php if ($articles_per_week == 4): ?>selected<?php endif; ?>>4</option><?php endif; ?>
                                                  <?php if ($max_articles_per_month >= 8): ?><option value="8" <?php if ($articles_per_week == 8): ?>selected<?php endif; ?>>8</option><?php endif; ?>
                                             </select>
                                             <div class="select-arrow"></div>
                                        </div>
                                   </div>
                                   <div class="row-btn">
                                        <button class="atakx-button" type="submit">Guardar</button>
                                   </div>
                              </form>

                         <?php endif; ?>
                    </div>

                    <div class="atakx-footer">
                         <img src="<?php echo plugin_dir_url(__FILE__) . '../assets/img/logo.png'; ?>" width="150px" />
                         <span style="color: white; margin-top: 1rem;">Copyright &copy; 2024 Atakx, All rights reserved</span>
                    </div>

                    <p style="font-size: 1rem; font-weight: 400;">¡Esperamos que estés disfrutando de Atakx! <br> Déjanos una <strong>valoración</strong> y cuéntanos sobre tu experiencia.</p>

               </div>
               <div class="column-right">
                    <div class="atakx-banner-right">
                         <div class="atakx-banner-right-content">
                              <span class="atakx-banner-text" style="font-size: x-large;">Potencia tu SEO</span>
                              <p style="font-size: 1rem; font-weight: 400;">Con tecnología de Open AI</p>
                              <button class="atakx-banner-btn" style="margin-top: 1rem;">VER MÁS</button>
                         </div>
                    </div>

                    <div class="atakx-right-banner" style="background-color: #f9f9f9;">
                         <div class="atack-icon-container">
                              <svg xmlns="http://www.w3.org/2000/svg" class="star-shadow" width="40px" height="40px" viewBox="0 0 24 24" fill="#FFFFFF" class="size-8">
                                   <path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z" clip-rule="evenodd" />
                              </svg>
                         </div>
                         <div class="atakx-right-banner-content">
                              <h1 style="color: #575757;">¿Disfrutas de Atakx?</h1>
                              <p style="font-size: 1rem; font-weight: 400; color: #575757;">Comentanos que te parece tu experiencia con Atakx</p>
                              <a class="atakx-right-banner-link" style="color: #575757;" href="#">Valóranos</a>
                         </div>
                    </div>

                    <div class="atakx-right-banner" style="background-color: #fc6736; color: #FFFFFF;">
                         <div class="atack-icon-container">
                              <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" fill="#fc6736" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                              </svg>
                         </div>
                         <div class="atakx-right-banner-content" style="color: #FFFFFF;">
                              <h1 style="color: #FFFFFF;">Documentación</h1>
                              <p style="font-size: 1rem; font-weight: 400;">¿Necesitas ayuda? Aquí documentamos las preguntas más frecuentes</p>
                              <a class="atakx-right-banner-link" style="color: #FFFFFF;" href="#">Leer documentación</a>
                         </div>
                    </div>

                    <div class="atakx-right-banner" style="background-color: #191919; color: #FFFFFF;">
                         <div class="atack-icon-container">
                              <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" fill="#FFFFFF" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M16.712 4.33a9.027 9.027 0 0 1 1.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 0 0-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 0 1 0 9.424m-4.138-5.976a3.736 3.736 0 0 0-.88-1.388 3.737 3.737 0 0 0-1.388-.88m2.268 2.268a3.765 3.765 0 0 1 0 2.528m-2.268-4.796a3.765 3.765 0 0 0-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 0 1-1.388.88m2.268-2.268 4.138 3.448m0 0a9.027 9.027 0 0 1-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0-3.448-4.138m3.448 4.138a9.014 9.014 0 0 1-9.424 0m5.976-4.138a3.765 3.765 0 0 1-2.528 0m0 0a3.736 3.736 0 0 1-1.388-.88 3.737 3.737 0 0 1-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 0 1-1.652-1.306 9.027 9.027 0 0 1-1.306-1.652m0 0 4.138-3.448M4.33 16.712a9.014 9.014 0 0 1 0-9.424m4.138 5.976a3.765 3.765 0 0 1 0-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 0 1 1.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 0 0-1.652 1.306A9.025 9.025 0 0 0 4.33 7.288" />
                              </svg>
                         </div>
                         <div class="atakx-right-banner-content" style="color: #FFFFFF;">
                              <h1 style="color: #FFFFFF; line-height: 2rem;">¿Sigues necesitando ayuda?</h1>
                              <p style="font-size: 1rem; font-weight: 400;">Contacta nuestro equipo de soporte</p>
                              <a class="atakx-right-banner-link" style="color: #FFFFFF;" href="#">Abre un ticket</a>
                         </div>
                    </div>

               </div>
          </div>


     </div>
     <script>
          const formConfig = document.getElementById('form-config');
          const formConfigPostRate = document.getElementById('form-post-rate');
          const formConfigCta = document.getElementById('form-cta');

          formConfig.addEventListener('submit', async function(event) {
               event.preventDefault();

               const formData = new FormData(this);
               const url = location.href.split("/")[0] + "//" + location.href.split("/")[2];
               const obj = {
                    page_url: url,
                    apiKey: formData.get('apiKey')
               }

               // const responseValidate = await fetch('http://localhost:4000/api/v1/plugin-wp/validateApiKey', {
               //      method: 'POST',
               //      headers: {
               //           'Content-Type': 'application/json'
               //      },
               //      body: JSON.stringify(obj)
               // })

               //if (responseValidate.ok) {
               document.getElementById("apiInvalid").style.display = "none";
               //const maxArticlesPerMonth = await responseValidate.json();
               const maxArticlesPerMonth = 8;
               console.log(maxArticlesPerMonth);
               formData.set("maxArticlesPerMonth", maxArticlesPerMonth);
               fetch('../save-config.php', {
                         method: 'POST',
                         body: formData
                    })
                    .then(response => response)
                    .then(data => {
                         console.log(data);
                         location.reload();
                    })
                    .catch(error => {
                         console.error('Error al enviar los datos:', error);
                    });
               //} else {
               //     document.getElementById("apiInvalid").style.display = "block";
               //}
          });

          if (formConfigPostRate) {
               formConfigPostRate.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const formData = new FormData(this);

                    console.log(formData.get('articlesPerWeek'));

                    fetch('../save-config-post-rate.php', {
                              method: 'POST',
                              body: formData
                         })
                         .then(response => response)
                         .then(data => {
                              console.log(data);
                              location.reload();
                         })
                         .catch(error => {
                              console.error('Error al enviar los datos:', error);
                         });
               });
          }

          if (formConfigCta) {
               formConfigCta.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const oldLogo = "<?php echo $logo; ?>";
                    const oldBg = "<?php echo $background_image; ?>";

                    const formData = new FormData(this);
                    formData.set("oldBg", oldBg);
                    formData.set("oldLogo", oldLogo);

                    fetch('../save-config-cta.php', {
                              method: 'POST',
                              body: formData
                         })
                         .then(response => response)
                         .then(data => {
                              console.log(data);
                              location.reload();
                         })
                         .catch(error => {
                              console.error('Error al enviar los datos:', error);
                         });
               });

          }

          function goto(url) {
               var win = window.open(url, '_blank');
               win.focus();
          }

          let inputBackground = document.getElementById("backgroundImageCTA");
          let labelBackground = document.getElementById("labelBackgroundImageCTA");
          let inputLogo = document.getElementById("logoCTA");
          let labelLogo = document.getElementById("labelLogoCTA");

          if (inputBackground) {
               inputBackground.addEventListener('change', (event) => {
                    let fileName = '';
                    if (this.files && this.files.length > 1)
                         fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                    else
                         fileName = event.target.value.split('\\').pop();

                    if (fileName)
                         labelBackground.querySelector('span').innerHTML = fileName;
               })
          }

          if (inputLogo) {
               inputLogo.addEventListener('change', (event) => {
                    let fileName = '';
                    if (this.files && this.files.length > 1)
                         fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                    else
                         fileName = event.target.value.split('\\').pop();

                    if (fileName)
                         labelLogo.querySelector('span').innerHTML = fileName;
               })
          }

          var modal = document.getElementById("preview");
          var openModalBtn = document.getElementById("openModalBtn");
          var closeModal = document.getElementsByClassName("close")[0];

          if (openModalBtn) {
               openModalBtn.onclick = function() {

                    modal.style.display = 'block';

                    const backgroundImageCTA = document.getElementById('backgroundImageCTA');
                    const overlayColor = document.getElementById('overlayColor').value.trim();
                    const overlayOpacity = document.getElementById('overlayOpacity').value.trim();
                    const titleCTA = document.getElementById('titleCTA').value.trim();
                    const buttonTitleCTA = document.getElementById('buttonTitleCTA').value.trim();
                    const buttonColorCTA = document.getElementById('buttonColorCTA').value.trim();
                    const CTAFont = document.getElementById('CTAFont').value.trim();
                    const leadEmail = document.getElementById('leadEmail').value.trim();
                    const logoCTA = document.getElementById('logoCTA');
                    const roundedBordersCTA = document.getElementById('roundedBordersCTA').checked;

                    const message = document.getElementById('message');
                    const preview = document.getElementById('cta-container');

                    if (!overlayColor || !overlayOpacity || !titleCTA || !buttonTitleCTA || !buttonColorCTA || !CTAFont || !leadEmail) {
                         message.style.display = 'flex';
                         preview.style.display = 'none';
                         return;
                    }

                    message.style.display = 'none';
                    preview.style.display = 'flex';

                    const prevTitleCTA = document.getElementById('prevTitleCTA');
                    const prevButtonCTA = document.getElementById('prevButtonCTA');
                    const overlay = document.getElementById('overlay');

                    const prevLogoCTA = document.getElementById('prevLogoCTA');
                    const prevBackgroundImageCTA = document.getElementById('prevBackgroundImageCTA');

                    prevTitleCTA.textContent = titleCTA;
                    prevButtonCTA.textContent = buttonTitleCTA;
                    prevButtonCTA.style.backgroundColor = buttonColorCTA;
                    overlay.style.backgroundColor = overlayColor;
                    overlay.style.opacity = overlayOpacity;

                    if (roundedBordersCTA) {
                         overlay.style.borderTopLeftRadius = '10px';
                         overlay.style.borderBottomLeftRadius = '10px';
                         prevBackgroundImageCTA.style.borderTopLeftRadius = '10px';
                         prevBackgroundImageCTA.style.borderBottomLeftRadius = '10px';
                         preview.style.borderRadius = '10px';
                    } else {
                         overlay.style.borderTopLeftRadius = '0px';
                         overlay.style.borderBottomLeftRadius = '0px';
                         prevBackgroundImageCTA.style.borderTopLeftRadius = '0px';
                         prevBackgroundImageCTA.style.borderBottomLeftRadius = '0px';
                         preview.style.borderRadius = '0px';
                    }

                    const backgroundImageFile = backgroundImageCTA.files[0];
                    const readerBackground = new FileReader();

                    readerBackground.onload = function(e) {
                         prevBackgroundImageCTA.src = e.target.result;
                    };

                    readerBackground.readAsDataURL(backgroundImageFile);

                    const logoFile = logoCTA.files[0];
                    const readerLogo = new FileReader();

                    readerLogo.onload = function(e) {
                         prevLogoCTA.src = e.target.result;
                    };

                    readerLogo.readAsDataURL(logoFile);
               }
          }

          closeModal.onclick = function() {
               modal.style.display = "none";
          }

          window.onclick = function(event) {
               if (event.target == modal) {
                    modal.style.display = "none";
               }
          }
     </script>
</body>

</html>