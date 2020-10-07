
    <?php ob_start();?>
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <p class="alert alert-danger"> Error 404 page Not Found</p>
            </div>
        </div>
    </div>
<?php 
$content = ob_get_clean();
require('template/template.php');