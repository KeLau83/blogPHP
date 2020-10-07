<?php
 function setLinkNav($infoJson) {
    $jsonConfig = file_get_contents("./config/menu.json");
    $config = json_decode($jsonConfig, true);
    $data = $config[$infoJson][0];
            foreach ($data as $key => $value) {
                ?>
                <li class="nav-item">
                <a class="nav-link " href="<?=$value?>"><?= $key
                ?> </a>
                </li>
                <?php
            } 
};