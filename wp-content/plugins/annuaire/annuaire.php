<?php
/**
 * Plugin Name: Annuaire
 * Description: Plugin from scratch, permet de créer, éditer et d'afficher l'annuaire de cette entreprise.
 * Author: Yasmine
 */

global $wpdb;
$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}annuaire", OBJECT);



function shortcode_annuaire($atts, $content = null) {
    ob_start();
    $results = (array) $GLOBALS['results'];
    ?>
    
    <?php
    foreach ($results as $ann) {
	?>
    <ul>
    <li><?php echo $ann->nom_entreprise; ?></li>
    <li><?php echo $ann->localisation_entreprise; ?></li>
    <li><?php echo $ann->prenom_contact; ?></li>
    <li><?php echo $ann->nom_contact; ?></li>
    <li><?php echo $ann->mail_contact; ?></li>
    </ul>
    <?php
    }
    return ob_get_clean();
}

add_shortcode('annuaire', 'shortcode_annuaire');