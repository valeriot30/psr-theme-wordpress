<div class="it-header-slim-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="it-header-slim-wrapper-content">

          <a class="d-lg-block navbar-brand" target="_blank" href="<?php echo dci_get_option("url_sito_regione"); ?>" target="_blank" aria-label="Vai al portale <?php echo dci_get_option("nome_regione"); ?> - link esterno - apertura nuova scheda" title="Vai al portale <?php echo dci_get_option("nome_regione"); ?>">
            
            <?php echo dci_get_option("nome_regione"); ?></a>
          <div class="it-header-slim-right-zone" role="navigation">
            <?php if(dci_get_option("link_ammtrasparente")) { ?>
            <div class="it-user-wrapper nav-item dropdown">
               <a aria-expanded="false" class="d-lg-block navbar-brand" data-toggle="dropdown" target="_blank" aria-label="Amministrazione trasparente" href=" <?php echo dci_get_option("link_ammtrasparente"); ?>" data-focus-mouse="false">
                  Amministrazione trasparente
               </a>
            </div>
            <?php }?>
            <?php if(dci_get_option("link_albopretorio")) { ?>
            <div class="it-user-wrapper nav-item dropdown">
               <a aria-expanded="false" class="d-lg-block navbar-brand" target="_blank" data-toggle="dropdown"  aria-label="Albo pretorio" href="<?php echo dci_get_option("link_albopretorio"); ?>" data-focus-mouse="false">
                  Albo pretorio
               </a>
            </div>
            <?php }?>
                
            <?php echo do_shortcode('[google-translator]'); ?>
                     
            <?php
                if(!is_user_logged_in()) {
                    get_template_part("template-parts/header/header-anon");
                }else{
                    get_template_part("template-parts/header/header-logged");
                }
              ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

