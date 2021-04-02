<?php

/**
 * Plugin Name: Annuaire
 * Description: Plugin from scratch, permet de créer, éditer et d'afficher l'annuaire de cette entreprise.
 * Author: Yasmine
 */

global $wpdb;


add_action('wp_enqueue_scripts', "styles");
function styles()
{
    wp_enqueue_style('ann_affichage', plugins_url('/assets/css/affichage.css', __FILE__), false, '1.0.0', 'all');
}

add_action('admin_menu', 'annuaire_menu');
function annuaire_menu()
{
    add_menu_page(
        __('Gérér les annuaires des entreprises'), // Titre de la page
        __('Annuaires'), // Titre du menu
        'manage_options', //le niveau de droits nécessaire pour y acceder
        'annuaires', // le slug de ma page
        'gestion_annuaire_page', // fonction qui affiche ma page
        '', //plugin_dir_url(__FILE__) . 'assets/img/building.png', // icone
        4 // position dans le back office
    );

    add_submenu_page(
        __('Ajouter un annuaire'), // Titre de la page
        __('Ajouter'), // Titre du menu
        'manage_options', //le niveau de droits nécessaire pour y acceder
        'ajouter-annuaire', // le slug de ma page
        'ajout_annuaire_page', // fonction qui affiche ma page
        '', //plugin_dir_url(__FILE__) . 'assets/img/building.png', // icone
        4 // position dans le back office
    );
}

function ajout_annuaire_page(){
    include 'views/add.php';
}


function gestion_annuaire_page()
{

?>
    <h1>Géstion des annuaires</h1>
    <hr>
    <?php include 'views/list.php';?>
    <hr>
            <?php include 'views/add.php';?>
<?php
}

add_shortcode('annuaire', 'shortcode_annuaire');
function shortcode_annuaire()
{
    $wpdb = $GLOBALS['wpdb'];

    if (isset($_POST['search'])) {
        $searchTerm = esc_attr__($_POST['terms']);

        $query = "SELECT * FROM {$wpdb->prefix}annuaire
        WHERE nom_entreprise LIKE '%$searchTerm%'
        OR localisation_entreprise LIKE '%$searchTerm%'
        OR prenom_contact LIKE '%$searchTerm%'
        OR nom_contact LIKE '%$searchTerm%'";

        $results = $wpdb->get_results($query, OBJECT);

        //die($query);
    } else if (isset($_POST['filter'])) {
        $filter = esc_attr__($_POST['filtre']);

        if ($filter === 'nom') {
            $filterBy = 'nom_entreprise';
        }
        if ($filter === 'localisation') {
            $filterBy = 'localisation_entreprise';
        }

        if ($filter === null || $filter === '') {

            $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}annuaire ORDER BY prenom_contact, nom_contact ASC", OBJECT);
        }

        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}annuaire ORDER BY $filterBy ASC", OBJECT);
    } else {
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}annuaire ORDER BY prenom_contact, nom_contact ASC", OBJECT);
    }

    ob_start();
?>
    <nav id="ann-nav">
        <form method="POST">

            <label for="filtre">Rechercher :</label>

            <div class="ann-container" role="search">
                <input type="search" name="terms" placeholder="Entreprise, localisation, nom, prénom, mail.." required>
                </select>

                <input type="submit" name="search" value="Rechercher">
            </div>

        </form>

        <form method="POST">

            <label for="filtre">Trier par :</label>

            <div class="ann-container">
                <select name="filtre" id="filtre">
                    <option value="" selected disabled hidden>- Choisissez une option -</option>
                    <option value="localisation">Localisation</option>
                    <option value="nom">Entreprise</option>
                </select>

                <input type="submit" name="filter" value="Trier">
            </div>

        </form>
    </nav>
    <?php
    foreach ($results as $ann) {
    ?>

        <ul class="ann-card">
            <li><b>Entreprise: </b><?= $ann->nom_entreprise; ?></li>
            <li><b>Localisation: </b><?= $ann->localisation_entreprise; ?></li>
            <li><b>Prénom: </b><?= $ann->prenom_contact; ?></li>
            <li><b>Nom: </b><?= $ann->nom_contact; ?></li>
            <li><b>Mail: </b><?= $ann->mail_contact; ?></li>
        </ul>
    <?php
    }

    return ob_get_clean();
}
