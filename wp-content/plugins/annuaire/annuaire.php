<?php
/**
 * Plugin Name: Annuaire
 * Description: Plugin from scratch, permet de créer, éditer et d'afficher l'annuaire de cette entreprise.
 * Author: Yasmine
 */

global $wpdb;
$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}annuaire", OBJECT);

/* if(isset(filter)){

} */

function styles(){
    wp_enqueue_style( 'ann_affichage', plugins_url('/css/affichage.css', __FILE__), false, '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', "styles");

function shortcode_annuaire($atts, $content = null) {
    ob_start();
    $results = (array) $GLOBALS['results'];
    ?>
    <nav id="ann-nav">
        <form method="POST">

            <label for="filtre">Rechercher :</label>

            <div class="ann-container">
            <input type="search" placeholder="Entreprise, localisation, nom, prénom, mail..">
            </select>

            <input type="submit" name="search" value="Rechercher">
            </div>
            
        </form>

        <form method="POST">

            <label for="filtre">Filtrer par :</label>

            <div class="ann-container">
            <select name="filtre" id="filtre">
            <option value="entreprise">Localisation</option>
            <option value="entreprise">Entreprise</option>
            </select>

            <input type="submit" name="filter" value="Filtrer">
            </div>
            
        </form>
    </nav>
    <?php
    foreach ($results as $ann) {
	?>
    <ul class="ann-card">
    <li><b>Entreprise: </b><?php echo $ann->nom_entreprise; ?></li>
    <li><b>Localisation: </b><?php echo $ann->localisation_entreprise; ?></li>
    <li><b>Prénom: </b><?php echo $ann->prenom_contact; ?></li>
    <li><b>Nom: </b><?php echo $ann->nom_contact; ?></li>
    <li><b>Mail: </b><?php echo $ann->mail_contact; ?></li>
    </ul>
    <?php
    }
    return ob_get_clean();
}

add_shortcode('annuaire', 'shortcode_annuaire');