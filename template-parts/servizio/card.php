<?php
global $servizio, $hide_categorie, $post;

$prefix = '_dci_servizio_';
$categorie = get_the_terms($servizio->ID, 'categorie_servizio');
$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $servizio->ID);
if($post->post_status == "publish") {
    ?>
        <div class="cmp-card-latest-messages card-wrapper" data-bs-toggle="modal" data-bs-target="#">
            <div class="card shadow-sm px-4 pt-4 pb-4 rounded border border-light">
                <?php if (!$hide_categories) { ?>
                <span class="visually-hidden">Categoria:</span>
                <div class="card-header border-0 p-0">
                    <?php if (is_array($categorie) && count($categorie)) {
                        $count = 1;
                        foreach ($categorie as $categoria) {
                            echo $count == 1 ? '' : ' - ';
                            echo '<a class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase" href="'.get_term_link($categoria->term_id).'">';
                            echo $categoria->name ;                                    
                            echo '</a>';
                            ++$count;
                        }
                    }                        
                    ?>
                </div>
                <?php } ?>
                <div class="card-body p-0 my-2">
                <h3 class="green-title-big t-primary mb-8">
                    <a class="text-decoration-none" href="<?php echo get_permalink($servizio->ID); ?>" data-element="service-link"><?php echo $servizio->post_title; ?></a>
                </h3>
                <p class="text-paragraph">
                    <?php echo $descrizione_breve; ?>
                </p>
                </div>
            </div>
        </div>
    <?php
}

<?php
// Funzione per ottenere i dati dal servizio web
function get_procedures_data() {
    $url = "https://sportellotelematico.comune.roccalumera.me.it/rest/pnrr/procedures";
    $response = wp_remote_get( $url );

    if ( is_array( $response ) && ! is_wp_error( $response ) ) {
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( $data ) {
                foreach ( $data as $procedure ) {
                    $name = $procedure['nome'];
                    $description = $procedure['descrizione_breve'];
                    $category = is_array($procedure['categoria']) ? implode(', ', $procedure['categoria']) : $procedure['categoria'];
                    $arguments = is_array($procedure['argomenti']) ? implode(', ', $procedure['argomenti']) : $procedure['argomenti'];
                    $url = $procedure['url'];
                
                    // Output dei dati nel template
                    echo "<p>Name: $name</p>";
                    echo "<p>Description: $description</p>";
                    echo "<p>Category: $category</p>";
                    echo "<p>Arguments: $arguments</p>";
                    echo '<p><a href="' . esc_url( $url ) . '">Link</a></p>';
                }
        }
    } else {
        echo "Failed to fetch data.";
    }
}

// Aggiungi il codice HTML/PHP nel tuo template dove desideri visualizzare i dati
?>
<div class="procedures-list">
    <h2>Procedures List</h2>
    <?php get_procedures_data(); ?>
</div>
