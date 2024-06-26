<?php if ( ! defined('OC_ADMIN')) exit('Direct access is not allowed.');

osc_add_filter('admin_body_class', 'admin_modeCompact_class');
function admin_modeCompact_class($args){
    $compactMode = osc_get_preference('compact_mode','modern_admin_theme');
    if($compactMode == true){
        $args[] = 'compact';
    }
    return $args;
}
osc_add_hook('ajax_admin_compactmode','modern_compactmode_actions');
function modern_compactmode_actions(){
    $compactMode = osc_get_preference('compact_mode','modern_admin_theme');
    $modeStatus  = array('compact_mode'=>true);
    if($compactMode == true){
        $modeStatus['compact_mode'] = false;
    }
    osc_set_preference('compact_mode', $modeStatus['compact_mode'], 'modern_admin_theme');
    echo json_encode($modeStatus);
}

// favicons
function admin_header_favicons() {
    $favicons   = array();
    $favicons[] = array(
        'rel'   => 'shortcut icon',
        'sizes' => '',
        'href'  => osc_current_admin_theme_url('images/favicon-48.png')
    );
    $favicons[] = array(
        'rel'   => 'apple-touch-icon-precomposed',
        'sizes' => '144x144',
        'href'  => osc_current_admin_theme_url('images/favicon-144.png')
    );
    $favicons[] = array(
        'rel'   => 'apple-touch-icon-precomposed',
        'sizes' => '114x114',
        'href'  => osc_current_admin_theme_url('images/favicon-114.png')
    );
    $favicons[] = array(
        'rel'   => 'apple-touch-icon-precomposed',
        'sizes' => '72x72',
        'href'  => osc_current_admin_theme_url('images/favicon-72.png')
    );
    $favicons[] = array(
        'rel'   => 'apple-touch-icon-precomposed',
        'sizes' => '',
        'href'  => osc_current_admin_theme_url('images/favicon-57.png')
    );

    $favicons = osc_apply_filter('admin_favicons', $favicons);

    foreach($favicons as $f) { ?>
        <link <?php if($f['rel'] !== '') { ?>rel="<?php echo $f['rel']; ?>" <?php } if($f['sizes'] !== '') { ?>sizes="<?php echo $f['sizes']; ?>" <?php } ?>href="<?php echo $f['href']; ?>">
    <?php }
}
osc_add_hook('admin_header', 'admin_header_favicons');

// admin footer
function admin_footer_html() { ?>
    <div class="float-left">
        <a title="<?php _e('Documentation'); ?>" href="https://docs.enterprise-classifieds.com/" target="_blank"><?php _e('Documentation'); ?></a>
    </div>
    <div class="float-right">
        <strong>Version <?php echo OSCLASS_VERSION; ?></strong>
    </div>
    <a id="ninja" href="<?php echo osc_admin_base_url(true); ?>?page=tools&action=version" class="ico ico-48 ico-dash-white"></a>
    <div class="clear"></div>
<?php
}
osc_add_hook('admin_content_footer', 'admin_footer_html');

// scripts
function admin_theme_js() {
    osc_load_scripts();
}
osc_add_hook('admin_header', 'admin_theme_js', 9);

// css
function admin_theme_css() {
    osc_load_styles();
}
osc_add_hook('admin_header', 'admin_theme_css', 9);

function printLocaleTabs($locales = null) {
    if($locales==null) { $locales = osc_get_locales(); }
    $num_locales = count($locales);
    if($num_locales>1) {
    echo '<div id="language-tab" class="ui-osc-tabs ui-tabs ui-widget ui-widget-content ui-corner-all"><ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">';
        foreach($locales as $locale) {
            echo '<li class="ui-state-default ui-corner-top"><a href="#'.$locale['pk_c_code'].'">'.$locale['s_name'].'</a></li>';
        }
    echo '</ul></div>';
    };
}

function printLocaleTitle($locales = null, $item = null) {
    if($locales==null) { $locales = osc_get_locales(); }
    if($item==null) { $item = osc_item(); }
    $num_locales = count($locales);
    foreach($locales as $locale) {
        echo '<div class="input-has-placeholder input-title-wide"><label for="title">' . __('Enter title here') . ' *</label>';
        $title = (isset($item) && isset($item['locale'][$locale['pk_c_code']]) && isset($item['locale'][$locale['pk_c_code']]['s_title'])) ? $item['locale'][$locale['pk_c_code']]['s_title'] : '';
        if( Session::newInstance()->_getForm('title') != "" ) {
            $title_ = Session::newInstance()->_getForm('title');
            if( $title_[$locale['pk_c_code']] != "" ){
                $title = $title_[$locale['pk_c_code']];
            }
        }
        $title = osc_apply_filter('admin_item_title', $title, $item, $locale);

        $name = 'title'. '[' . $locale['pk_c_code'] . ']';
        echo '<input id="' . $name . '" type="text" name="' . $name . '" value="' . osc_esc_html(htmlentities($title, ENT_COMPAT, "UTF-8")) . '"  />';
        echo '</div>';
    }
}

function printLocaleTitlePage($locales = null,$page = null) {
    if($locales==null) { $locales = osc_get_locales(); }
    $aFieldsDescription = Session::newInstance()->_getForm("aFieldsDescription");
    $num_locales = count($locales);
    echo '<label for="title">' . __('Title') . ' *</label>';

    foreach($locales as $locale) {
        $title = '';
        if(isset($page['locale'][$locale['pk_c_code']])) {
            $title = $page['locale'][$locale['pk_c_code']]['s_title'];
        }
        if( isset($aFieldsDescription[$locale['pk_c_code']]) && isset($aFieldsDescription[$locale['pk_c_code']]['s_title']) &&$aFieldsDescription[$locale['pk_c_code']]['s_title'] != '' ) {
            $title = $aFieldsDescription[$locale['pk_c_code']]['s_title'];
        }
        $name = $locale['pk_c_code'] . '#s_title';

        $title = osc_apply_filter('admin_page_title', $title, $page, $locale);

        echo '<div class="input-has-placeholder input-title-wide"><label for="title">' . __('Enter title here') . ' *</label>';
        echo '<input id="' . $name . '" type="text" name="' . $name . '" value="' . osc_esc_html(htmlentities($title, ENT_COMPAT, "UTF-8")) . '"  />';
        echo '</div>';
    }
}

function printLocaleDescription($locales = null, $item = null) {
    if($locales==null) { $locales = osc_get_locales(); }
    if($item==null) { $item = osc_item(); }
    $num_locales = count($locales);
    foreach($locales as $locale) {
        $name = 'description'. '[' . $locale['pk_c_code'] . ']';

        echo '<div><label for="description">' . __('Description') . ' *</label>';
        $description = (isset($item) && isset($item['locale'][$locale['pk_c_code']]) && isset($item['locale'][$locale['pk_c_code']]['s_description'])) ? $item['locale'][$locale['pk_c_code']]['s_description'] : '';

        if( Session::newInstance()->_getForm('description') != "" ) {
            $description_ = Session::newInstance()->_getForm('description');
            if( $description_[$locale['pk_c_code']] != "" ){
                $description = $description_[$locale['pk_c_code']];
            }
        }

        $description = osc_apply_filter('admin_item_description', $description, $item, $locale);

        echo '<textarea id="' . $name . '" name="' . $name . '" rows="10">' . $description . '</textarea></div>';
    }
}

function printLocaleDescriptionPage($locales = null, $page = null) {
    if($locales==null) { $locales = osc_get_locales(); }
    $aFieldsDescription = Session::newInstance()->_getForm("aFieldsDescription");
    $num_locales = count($locales);

    foreach($locales as $locale) {
        $description = '';
        if(isset($page['locale'][$locale['pk_c_code']])) {
            $description = $page['locale'][$locale['pk_c_code']]['s_text'];
        }
        if( isset($aFieldsDescription[$locale['pk_c_code']]) && isset($aFieldsDescription[$locale['pk_c_code']]['s_text']) &&$aFieldsDescription[$locale['pk_c_code']]['s_text'] != '' ) {
            $description = $aFieldsDescription[$locale['pk_c_code']]['s_text'];
        }

        $description = osc_apply_filter('admin_page_description', $description, $page, $locale);

        $name = $locale['pk_c_code'] . '#s_text';
        echo '<div><label for="description">' . __('Description') . ' *</label>';
        echo '<textarea id="' . $name . '" name="' . $name . '" rows="10">' . $description . '</textarea></div>';
    }
}

function check_market_language_compatibility($slug, $language_version) {
    return osc_check_language_update($slug);
}

function check_market_compatibility($versions) {
    $versions = explode(',',$versions);
    $current_version = OSCLASS_VERSION;

    foreach($versions as $_version) {
        $result = version_compare2(OSCLASS_VERSION, $_version);

        if( $result == 0 || $result == -1 ) {
            return true;
        }
    }
    return false;
}

function check_version_admin_footer() {
    if( (time() - osc_last_version_check()) > (24 * 3600) ) {
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $.getJSON(
                    '<?php echo osc_admin_base_url(true); ?>?page=ajax&action=check_version',
                    {},
                    function(data){}
                );
            });
        </script>
        <?php
    }
}
osc_add_hook('admin_footer', 'check_version_admin_footer');

function check_languages_admin_footer() {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON(
                '<?php echo osc_admin_base_url(true); ?>?page=ajax&action=check_languages',
                {},
                function(data){}
            );
        });
    </script>
<?php
}

function check_themes_admin_footer() {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON(
                '<?php echo osc_admin_base_url(true); ?>?page=ajax&action=check_themes',
                {},
                function(data){}
            );
        });
    </script>
<?php
}

function check_plugins_admin_footer() {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON(
                '<?php echo osc_admin_base_url(true); ?>?page=ajax&action=check_plugins',
                {},
                function(data){}
            );
        });
    </script>
<?php
}

// Notify the admin about the minimum PHP version required
function admin_warn_php_version() {
    $php_min = '7.1';

    if(!version_compare(PHP_VERSION, $php_min . '.0', '>=')) {
    ?>
        <div id="flashmessage" class="flashmessage flashmessage-error" style="display:block;">
            <?php echo sprintf(__('Your server does not meet the minimum PHP version requirements. Your version is %s, minimum required version is %s! Please update your PHP version in order to avoid errors.'), PHP_VERSION, $php_min . '.0'); ?>
        </div>
    <?php 
    }
}

osc_add_hook('admin_dashboard_top', 'admin_warn_php_version');

// Inform admin about Maintenance Mode being enabled
function admin_warn_maintenance() {
    if(defined('__OSC_MAINTENANCE__') && __OSC_MAINTENANCE__ === true) {
    ?>
        <div id="flashmessage" class="flashmessage flashmessage-warning" style="display:block;">
            <?php _e('The website is in maintenance mode, users will not be able to access it.'); ?>
            <a href="<?php echo osc_admin_base_url(true); ?>?page=tools&amp;action=maintenance"><?php _e('Manage maintenance mode'); ?></a>.
        </div>
    <?php 
    }
}

osc_add_hook('admin_dashboard_top', 'admin_warn_maintenance');

/* end of file */
