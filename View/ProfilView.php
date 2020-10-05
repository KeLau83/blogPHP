 <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-8">
                <h2><?= $_SESSION['pseudoUser']?></h2>
                <form method="POST">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="submit" value="Déconnexion">
                    </div>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</body>
</html>