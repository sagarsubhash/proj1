<?php

/**
 * @file
 * Implements().
 */
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * @file
 * market_wave theme file.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function market_wave_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
    if ($form['#attributes']['class'][0] == 'system-theme-settings') {
        $form['#attached']['library'][] = 'market_wave/theme.setting';
    }

    // Verticle tabs.
    $form['wave_tabs'] = [
        '#type' => 'vertical_tabs',
        '#prefix' => '<h2><small>' . t('Market wave settings') . '</small></h2>',
        '#weight' => -10,
    ];

    // header settings
    $form['header'] = [
        '#type' => 'details',
        '#title' => t('Header'),
        '#group' => 'wave_tabs',
    ];
    $form['header']['full_width'] = [
        '#type' => 'checkbox',
        '#title' => t('Full width header'),
        '#default_value' => theme_get_setting('full_width', 'market_wave'),
        '#description'   => t("Check this option to show full width header."),
    ];
    $form['header']['header_class'] = [
        '#title' => t('Header custom class'),
        '#type' => 'textfield',
        '#default_value' => theme_get_setting("header_class", "market_wave"),
      ];

    // Home page slider settings.
    $form['Banner'] = [
        '#type' => 'details',
        '#title' => t('Slider settings'),
        '#group' => 'wave_tabs',
    ];
    if(!$form_state->get('num_rows')){
        $total_slide = theme_get_setting('slide_num');
        if($total_slide){
            $form_state->set('num_rows', $total_slide);
        }
        else{
            $form_state->set('num_rows', 2);
        }
    }
    $form['Banner']['slideshow_display'] = [
        '#type' => 'checkbox',
        '#title' => t('Show slideshow'),
        '#default_value' => theme_get_setting('slideshow_display', 'market_wave'),
        '#description'   => t("Check this option to show Slideshow in front page. Uncheck to hide."),
    ];
    $form['Banner']['slide_num'] = [
        '#type' => 'number',
        '#title' => t('Select Number of Slider Display'),
        '#min' => 1,
        '#required' => TRUE,
        '#default_value' => theme_get_setting('slide_num'),
        '#description' => t("Enter Number of slider you want to display"),
        '#access' => false,
    ];
    $form['Banner']['slide'] = [
        '#markup' => t('You can change the title, descriptions, url and image of each slide in the following Slide Setting fieldsets.'),
    ];
    $form['Banner']['slidecontent'] = [
        '#type' => 'container',
        '#attributes' => ['id' => 'slide-wrapper'],
    ];
    for ($i = 1; $i <= $form_state->get('num_rows'); $i++) {
        $form['Banner']['slidecontent']['slide' . $i] = [
            '#type' => 'details',
            '#title' => t('Slide '.$i),
        ];
        $form['Banner']['slidecontent']['slide' . $i]['slide_title_' . $i] = [
            '#type' => 'textfield',
            '#title' => t('Title'),
            '#default_value' => theme_get_setting("slide_title_{$i}", "market_wave"),
        ];
        $form['Banner']['slidecontent']['slide' . $i]['slide_desc_' . $i] = [
            '#type' => 'text_format',
            '#title' => t('Descriptions'),
            '#default_value' => theme_get_setting("slide_desc_{$i}", "market_wave")['value'],
        ];
        $form['Banner']['slidecontent']['slide' . $i]['slide_image_' . $i] = [
            '#type' => 'managed_file',
            '#title' => t('Image'),
            '#description' => t('Use same size for all the slideshow images(Recommented size : 1920 X 603).'),
            '#default_value' => theme_get_setting("slide_image_{$i}", "market_wave"),
            '#upload_location' => 'public://',
        ];
        $form['Banner']['slidecontent']['slide' . $i]['slide_url_' . $i] = [
            '#type' => 'textfield',
            '#title' => t('button URL'),
            '#default_value' => theme_get_setting("slide_url_{$i}", "market_wave"),
        ];
        $form['Banner']['slidecontent']['slide' . $i]['slide_url_title_' . $i] = [
            '#type' => 'textfield',
            '#title' => t('Button text'),
            '#default_value' => theme_get_setting("slide_url_title_{$i}", "market_wave"),
        ];
    }
    $form['Banner']['info'] = [
        '#markup' => t('You can add or remove slider content using both button.'),
    ];
    $form['Banner']['actions'] = [
        '#type' => 'actions',
    ];
    $form['Banner']['actions']['add_more'] = [
        '#type' => 'submit',
        '#value' => t('Add one more'),
        '#submit' => array('addOne'),
        '#attributes' => [
            'class' => ['button-addmore'],
        ],
        '#ajax' => [
            'callback' => 'addmoreCallback',
            'wrapper' => 'slide-wrapper',
        ],
    ];
    if($form_state->get('num_rows') > 2) {
        $form['Banner']['actions']['remove_last'] = [
            '#type' => 'submit',
            '#value' => t('remove last one'),
            '#submit' => array('removelast'),
            '#attributes' => [
                'class' => ['button-remove'],
            ],
            '#ajax' => [
                'callback' => 'removelastCallback',
                'wrapper' => 'slide-wrapper',
            ],
        ];
    }
    $form['actions']['submit']['#value'] = t('Save Custom Settings');
    $form['#submit'][] = 'market_wave_custom_submit_callback';
}

/**
   * Callback for both ajax-enabled buttons.
   *
   * Selects and returns the slide content in it.
   */
function addmoreCallback(array &$form, FormStateInterface $form_state) {
    $number_of_slide = $form_state->get('num_rows');
    return $form['Banner']['slidecontent'];
  }

  /**
   * Submit handler for the "add-one-more" button.
   *
   * Increments the max counter and causes a rebuild.
   */
function addOne(array &$form, FormStateInterface $form_state) {
    $number_of_slide = $form_state->get('num_rows');
    $add_button = $number_of_slide + 1;
    $form_state->set('num_rows', $add_button);
    $form_state->setRebuild();
}

/**
   * Callback for both ajax-enabled buttons.
   *
   * Selects and returns the slide content in it.
   */
function removelastCallback(array &$form, FormStateInterface $form_state) {
    $number_of_slide = $form_state->get('num_rows');
    return $form['Banner']['slidecontent'];
}

/**
 * Submit handler for the "add-one-more" button.
 *
 * Increments the max counter and causes a rebuild.
 */
function removelast(array &$form, FormStateInterface $form_state) {
    $config_market_wave =  \Drupal::configFactory()->getEditable('market_wave.settings');
    $number_of_slide = $form_state->get('num_rows');
    $add_button = $number_of_slide - 1;
    $form_state->set('num_rows', $add_button);
    $keys = ["slide_image_$number_of_slide",
    "slide_url_$number_of_slide",
    "slide_url_title_$number_of_slide",
    "slide_title_$number_of_slide",
    "slide_desc_$number_of_slide"];
    foreach($keys as $slide_index){
        $config_market_wave->delete($slide_index);
    }
    $form_state->setRebuild();
}

/**
 * Custom submit callback for the theme settings form.
 */
function market_wave_custom_submit_callback(&$form, FormStateInterface $form_state) {
    // Retrieve the submitted value for 'slide_num'.
    $slide_num_value = $form_state->get('num_rows');
    $form_state->setValue('slide_num', $slide_num_value);
    // Set the value using the Configuration API.
    \Drupal::configFactory()->getEditable('theme.market_wave')->set('slide_num', $slide_num_value)->save();
}