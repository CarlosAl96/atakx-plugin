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
                         <div class="atakx-section-head">
                              <div class="atakx-flex">
                                   <h1 style="font-size: 1.5rem;">Configuración</h1>
                                   <button class="atakx-button">Guardar</button>
                              </div>
                              <div class="atakx-separator" style="margin-top: 0.5rem;"></div>
                         </div>

                         <form class="atakx-form" action="" id="form-config" method="post">

                              <div class="row">
                                   <label class="atakx-label" for="apiKey">API Key:</label>
                                   <input class="atakx-input" type="text" id="apiKey" name="apiKey" value="<?php echo $api_key; ?>" required>
                                   <p id="apiInvalid" style="display: none; color: #d60000;">Esta Api Key no es válida</p>
                                   <button class="atakx-button-sec" onclick="goto('https://app.atakx.com')" style="margin-right: 1rem; margin-top: 0.5rem;">Generar API Key</button>
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
                                   <h1 style="font-size: 1.5rem;">Call to actions (CTA)</h1>
                                   <div class="atakx-separator"></div>
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
                                   <h1 style="font-size: 1.5rem;">Programación semanal</h1>
                                   <div class="atakx-separator"></div>
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

                    <div class="atakx-value-us">
                         <img class="star" src="<?php echo plugin_dir_url(__FILE__) . '../assets/img/star.jpeg'; ?>" width="60px" />
                         <div class="atakx-value-us-content">
                              <h1>¿Disfrutas de Atakx?</h1>
                              <p style="font-size: 1rem; font-weight: 400;">Comentanos que te parece tu experiencia con Atakx</p>
                              <a class="value-us-link" href="#">Valóranos</a>
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

               const responseValidate = await fetch('http://localhost:4000/api/v1/plugin-wp/validateApiKey', {
                    method: 'POST',
                    headers: {
                         'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(obj)
               })

               if (responseValidate.ok) {
                    document.getElementById("apiInvalid").style.display = "none";
                    const maxArticlesPerMonth = await responseValidate.json();
                    console.log(maxArticlesPerMonth.response.num_articles_for_month);
                    formData.set("maxArticlesPerMonth", maxArticlesPerMonth.response.num_articles_for_month);
                    fetch('../save-config.php', {
                              method: 'POST',
                              body: formData
                         })
                         .then(response => response)
                         .then(data => {
                              console.log(data);
                              //location.reload();
                         })
                         .catch(error => {
                              console.error('Error al enviar los datos:', error);
                         });
               } else {
                    document.getElementById("apiInvalid").style.display = "block";
               }
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