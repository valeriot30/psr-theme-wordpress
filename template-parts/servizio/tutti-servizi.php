<?php
    global $posts, $the_query, $load_posts, $servizio, $load_card_type;

    $max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 6;
    $load_posts = 6;
    $query = isset($_GET['search']) ? $_GET['search'] : null;
    $args = array(
        's' => $query,
        'posts_per_page' => $max_posts,
        'post_type'      => 'servizio',
        'orderby'        => 'post_title',
        'order'          => 'ASC'
    );
    $the_query = new WP_Query( $args );

    $posts = $the_query->posts;

    // Per selezionare i contenuti in evidenza tramite flag
    // $post_types = dci_get_post_types_grouped('servizi');
    // $servizi_evidenza = dci_get_highlighted_posts( $post_types, 10);

    //Per selezionare i contenuti in evidenza tramite configurazione
    $servizi_evidenza = dci_get_option('servizi_evidenziati','servizi');
?>

<div class="bg-grey-card">
    <form role="search" id="search-form" method="get" class="search-form">
        <button type="submit" class="d-none"></button>
        <div class="container">
            <div class="row">
            <div class="col-12">
                <h2 class="title-xxlarge mb-4 mt-5 mb-lg-10">
                Esplora tutti i servizi
                </h2>
            </div>
            <div class="col-12 col-lg-8 pt-lg-50 pb-lg-50">
                <div class="cmp-input-search">
                    <div class="form-group autocomplete-wrapper mb-2 mb-lg-4">
                        <div class="input-group">
                        <label for="autocomplete-two" class="visually-hidden"
                        >Cerca una parola chiave</label
                        >
                        <input
                        type="search"
                        class="autocomplete form-control"
                        placeholder="Cerca una parola chiave"
                        id="autocomplete-two"
                        name="search"
                        value="<?php echo $query; ?>"
                        data-bs-autocomplete="[]"
                        />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="button-3">
                                Invio
                            </button>
                        </div>
                        <span class="autocomplete-icon" aria-hidden="true"
                        ><svg
                            class="icon icon-sm icon-primary"
                            role="img"
                            aria-labelledby="autocomplete-label"
                        >
                            <use
                            href="#it-search"
                            ></use></svg></span>
                        </div>
                    </div>
                    <p id="autocomplete-label" class="mb-4">
                    <strong><?php echo $the_query->found_posts; ?> </strong>servizi trovati in ordine alfabetico
                    </p>
                </div>
                <div id="load-more">
                    <?php foreach ($posts as $servizio) { 
                        $load_card_type = "servizio";
                        get_template_part("template-parts/servizio/card");    
                    } ?>
                </div>
                <?php get_template_part("template-parts/search/more-results"); ?>
            </div>
            <?php if (is_array($servizi_evidenza) && count($servizi_evidenza)) { ?>
            <div class="col-12 col-lg-4 pt-30 pt-lg-5 ps-lg-5 order-first order-md-last">
                <div class="link-list-wrap">
                    <h2 class="title-xsmall-semi-bold">
                        <span>SERVIZI IN EVIDENZA</span>
                    </h2>
                    <ul class="link-list t-primary">
                        <?php foreach ($servizi_evidenza as $servizio_id) { 
                            $post = get_post($servizio_id);    
                        ?>
                        <li class="mb-3 mt-3">
                            <a class="list-item ps-0 title-medium underline" href="<?php echo get_permalink($post->ID); ?>">
                                <span><?php echo $post->post_title; ?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </form>
</div>


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
                $category = $procedure['categoria'];
                $arguments = $procedure['argomenti'];
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
    <?php get_procedures_data(); ?>
</div>

















