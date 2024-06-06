<!-- <?php
      // session_start();
      ?> -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center active" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <h3 class="card-header text-black"><?= $title ?></h3>
      </div>
    </div>
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Place this tag where you want the button to render. -->
      <li>
        <a class="dropdown-item btn btn-primary" href="../nav/deconnexion.php">
          <i class="bx bx-power-off me-2"></i>
          <span class="align-middle">Se déconnecter</span>
        </a>
      </li>

      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="../assets/img/logo.jpg" alt class="w-px-40 h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" type="button" class="btn btn-secondary d-grid w-100" data-bs-toggle="modal" data-bs-target="#basical" href="#">
              <i class="bx bx-cog me-2"></i>
              <span class="align-middle">Changer le Mot de passe</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" type="button" class="btn btn-secondary d-grid w-100" data-bs-toggle="modal" data-bs-target="#ModalUser" href="#">
              <i class="bx bx-cog me-2"></i>
              <span class="align-middle">Ajouter Un Nouvelle Utilisateur</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>

        </ul>
      </li>
      <!--/ User -->
    </ul>


  </div>
</nav>
<div class="modal fade" id="basical" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Modification de Mot de passe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../profil/editpswrd.php" method="POST">
        <input type="hidden" name="iduser" value="<?= $_SESSION["id"] ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Mot de passe Actuel</label>
              <input type="password" id="nameBasic" autocomplete="off" class="form-control" placeholder="Mot de passe actuel" name="actpassword" />
            </div>
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Nouveau Mot de passe</label>
              <input type="password" id="nameBasic" autocomplete="off" class="form-control" placeholder="Nouveau mot de passe" name="newpassword" />
            </div>
          </div>

        </div>
        <div class="modal-footer">

          <button class="btn btn-primary">Enregistrer la modification</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="ModalUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Nouvelle Utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../profil/adduser.php" method="POST">
        <div class="modal-body">
          <div class="col">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Nom De l' utilisateur</label>
              <input type="text" id="nameBasic" autocomplete="off" class="form-control" placeholder="Nom d'utilisateur" name="username" />
            </div>
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Lieu de Travail</label>
              <select name="place" id="" class="form-control">
                <option value=""></option>
                <option value="majunga">Majunga</option>
                <option value="tana">Antananarivo</option>
              </select>
            </div>

            <div class="col m-3">
              <label for="nameBasic" class="form-label">Responsabilité</label>
            </div>
            <div class="col">
              <input type="checkbox" name="action" id="vente">
              <label for="vente">Responsable de Vente</label>
            </div>
            <div class="col">
              <input type="checkbox" name="action1" id="achat">
              <label for="achat">Responsable d' Achat et Traitement</label>
            </div>
            <div class="col">
              <input type="checkbox" name="action2" id="stock">
              <label for="stock">Responsable de Stock et Chargement</label>
            </div>
            <!-- <div class="col">
              <input type="checkbox" name="action3" id="stock">
              <label for="stock">Trésorerie et Dépense</label>
            </div> -->
          </div>

        </div>
        <div class="modal-footer">

          <button class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>