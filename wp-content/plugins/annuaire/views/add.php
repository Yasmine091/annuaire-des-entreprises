<?php

do_action( 'admin_notices' );

global $wpdb;

    if (isset($_POST['ann-add'])) {
        $nom_e = esc_attr__($_POST['nom-e']);
        $localisation_e = esc_attr__($_POST['localisation-e']);
        $prenom_c = esc_attr__($_POST['prenom-c']);
        $nom_c = esc_attr__($_POST['nom-c']);
        $mail_c = esc_attr__($_POST['mail-c']);
        
        $wpdb->insert($wpdb->prefix . 'annuaire', array(
            'nom_entreprise' => $nom_e,
            'localisation_entreprise' => $localisation_e,
            'prenom_contact' => $prenom_c,
            'nom_contact' => $nom_c,
            'mail_contact' => $mail_c
        ));
        
        echo '<div class="notice notice-success is-dismissible">
        <p>L\'annuaire a été ajouté avec succès!</p>
        </div>';
    }

    ?>

<form method="post">
    <h2>Ajouter un annuaire</h2>
    <p>
        <label for="nom-e">Nom de l'entreprise</label><br>
        <input type="text" name="nom-e" placeholder="Endives">
    </p>
    <p>
        <label for="localisation-e">Localisation de l'entreprise</label><br>
        <input type="text" name="localisation-e" placeholder="Îles canaries">
    </p>
    <p>
        <label for="prenom-c">Prénom du contact</label><br>
        <input type="text" name="prenom-c" placeholder="Poussin">
    </p>
    <p>
        <label for="nom-c">Nom du contact</label><br>
        <input type="text" name="nom-c" placeholder="PIO">
    </p>
    <p>
        <label for="mail-c">Mail du contact</label><br>
        <input type="email" name="mail-c" placeholder="p.pio@assos-oiseaux-chanteurs.org">
    </p>
    <p>
        <?php
            submit_button('Ajouter cet annuaire', 'primary', 'ann-add');
        ?>
    </p>
</form>