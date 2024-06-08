<?php

// Recupera il valore dell'opzione
$servizi_maggioli_url = dci_get_option('servizi_maggioli_url', 'servizi');

if (strlen($servizi_maggioli_url) > 1) {

    // Funzione per ottenere i dati dal servizio web
    function get_procedures_data()
    {
        $url =  dci_get_option('servizi_maggioli_url', 'servizi');
        $response = wp_remote_get($url);
        $total_services = 0; // Inizializza il contatore

        if (is_array($response) && !is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            if ($data) {
                // Inizializza array per servizi in evidenza e non in evidenza
                $in_evidenza_services = [];
                $non_in_evidenza_services = [];

                foreach ($data as $procedure) {
                    $name = $procedure['nome'];
                    $description = $procedure['descrizione_breve'];
                    $category = is_array($procedure['categoria']) ? implode(', ', $procedure['categoria']) : $procedure['categoria'];
                    $arguments = is_array($procedure['argomenti']) ? implode(', ', $procedure['argomenti']) : $procedure['argomenti'];
                    $in_evidenza = $procedure['in_evidenza'];
                    $url = $procedure['url'];

                    // Aggiungi il servizio all'array corretto
                    if ($in_evidenza) {
                        $in_evidenza_services[] = [
                            'name' => $name,
                            'description' => $description,
                            'category' => $category,
                            'url' => $url
                        ];
                    } else {
                        $non_in_evidenza_services[] = [
                            'name' => $name,
                            'description' => $description,
                            'category' => $category,
                            'url' => $url
                        ];
                    }

                    // Incrementa il contatore ad ogni iterazione
                    $total_services++;
                }

                // Output dei titoli
                echo "<h2>Servizi in Evidenza</h2>";
                output_services($in_evidenza_services);

                echo "<h2>Altri Servizi</h2>";
                output_services($non_in_evidenza_services);
            }
        } else {
            echo "Non riesco a leggere i servizi aggiuntivi.";
        }

        // Restituisci il totale dei servizi caricati
        return $total_services;
    }

    // Funzione per stampare i servizi
    function output_services($services)
    {
        foreach ($services as $service) {
            ?>
            <div class="cmp-card-latest-messages card-wrapper" data-bs-toggle="modal" data-bs-target="#">
                <div class="card shadow-sm px-4 pt-4 pb-4 rounded border border-light">
                    <span class="visually-hidden">Categoria:</span>
                    <div class="card-header border-0 p-0">
                        <?php if ($service['category']) {
                            echo '<div class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase">' . $service['category'] . '</div>';
                        } ?>
                    </div>
                    <div class="card-body p-0 my-2">
                        <h3 class="green-title-big t-primary mb-8">
                            <a class="text-decoration-none" href="<?php echo esc_url($service['url']); ?>" data-element="service-link"><?php echo $service['name']; ?></a>
                        </h3>
                        <p class="text-paragraph">
                            <?php echo $service['description']; ?>
                        </p>
                    </div>
                </div>
            </div><p></p>
        <?php
        }
    }

    // Aggiungi il codice HTML/PHP nel tuo template dove desideri visualizzare i dati
    ?>
    <div class="row g-4" id="load-more">
        <div class="procedures-list">
            <div class="col-12">
                <h2 class="title-xxlarge mb-4 mt-5 mb-lg-10">
                    Servizi Aggiuntivi
                </h2>
            </div>

            <?php
            // Chiamata alla funzione per ottenere i dati e salvare il totale dei servizi
            $total_services_loaded = get_procedures_data();
            echo "<p>Servizi aggiuntivi: $total_services_loaded</p>";
            ?>
        </div>
    </div>
<?php } ?>
