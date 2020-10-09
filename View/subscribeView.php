
 <div class="container">
     <div class="row">
         <div class="col-2"></div>
         <div class="col-8">
             <h2>Formulaire inscription</h2>
             <form method="POST">
                 <div class="form-group">
                     <label for="exampleInputEmail1">Email</label>
                     <input type="email" class="form-control" name="email" aria-describedby="emailHelp"   required>
                 </div>
                 <div class="form-group">
                     <label for="exampleInputPassword1">Pseudo</label>
                     <input type="texte" class="form-control" name="pseudo"  required>

                 </div>
                 <div class="form-group">
                     <label for="exampleInputPassword1">Mot de passe</label>
                     <input type="password" class="form-control" name="password1" required>
                 </div>
                 <div class="form-group">
                     <label for="exampleInputPassword1">Confirmer Mot de passe</label>
                     <input type="password" class="form-control" name="password2" required>
                 </div>
                 <div class="form-group">
                     <label for="exampleInputPassword1"> Pour voir si tu mérites de t'inscrire : <br /> <?= $viewData['questionCaptcha'] ?></label>

                     <input type="text" class="form-control" name="captcha" required>
                 </div>
                 <button type="submit" class="btn btn-dark">Envoyer</button>
             </form>
         </div>
         <div class="col-2"></div>
     </div>
 </div>
