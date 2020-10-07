

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse  " id="navbarNav">
        <ul class="navbar-nav ">
            <?php  
            setLinkNav('all');         
            if (isset($_SESSION['pseudoUser'])) {
                setLinkNav('reserve');
            } else {
                setLinkNav('Nconnecte');
            }
            ?>
            
        </ul>
    </div>
</nav>
        </br>