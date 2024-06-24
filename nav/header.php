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
    <!-- Title -->
    <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <h3 class="card-header text-black"></h3>
      </div>
    </div>
    <!-- /Title -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Logout Button -->
      <li>
        <a class="dropdown-item btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#logoutModal">
          <i class="bx bx-power-off me-2"></i>
          <span class="align-middle">Se déconnecter</span>
        </a>
      </li>

      <!-- User Dropdown -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="../assets/img/logo.jpg" alt class="w-px-40 h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              <i class="bx bx-cog me-2"></i>
              <span class="align-middle">Changer le Mot de passe</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addUserModal">
              <i class="bx bx-user-plus me-2"></i>
              <span class="align-middle">Ajouter Un Nouvelle Utilisateur</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
        </ul>
      </li>
      <!-- /User Dropdown -->
    </ul>
  </div>
</nav>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation de Déconnexion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Êtes-vous sûr de vouloir vous déconnecter?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <a href="../nav/deconnexion.php" class="btn btn-primary">Se déconnecter</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addClient" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modification de Mot de passe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../profil/editpswrd.php" method="POST">
        <input type="hidden" name="iduser" value="<?= $_SESSION['id'] ?>">
        <div class="modal-body">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Mot de passe Actuel</label>
            <input type="password" id="currentPassword" class="form-control" name="actpassword" placeholder="Mot de passe actuel" required>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">Nouveau Mot de passe</label>
            <input type="password" id="newPassword" class="form-control" name="newpassword" placeholder="Nouveau mot de passe" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer la modification</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modification de Mot de passe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../profil/editpswrd.php" method="POST">
        <input type="hidden" name="iduser" value="<?= $_SESSION['id'] ?>">
        <div class="modal-body">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Mot de passe Actuel</label>
            <input type="password" id="currentPassword" class="form-control" name="actpassword" placeholder="Mot de passe actuel" required>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">Nouveau Mot de passe</label>
            <input type="password" id="newPassword" class="form-control" name="newpassword" placeholder="Nouveau mot de passe" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer la modification</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nouvelle Utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../profil/adduser.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label for="username" class="form-label">Nom De l'utilisateur</label>
            <input type="text" id="username" class="form-control" name="username" placeholder="Nom d'utilisateur" required>
          </div>
          <div class="mb-3">
            <label for="place" class="form-label">Lieu de Travail</label>
            <select id="place" class="form-control" name="place" required>
              <option value="">Sélectionnez</option>
              <option value="majunga">Majunga</option>
              <option value="tana">Antananarivo</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="responsibility" class="form-label">Responsabilité</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="responsibility[]" id="vente" value="vente">
              <label class="form-check-label" for="vente">Responsable de Vente</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="responsibility[]" id="achat" value="achat">
              <label class="form-check-label" for="achat">Responsable d'Achat et Traitement</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="responsibility[]" id="stock" value="stock">
              <label class="form-check-label" for="stock">Responsable de Stock et Chargement</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>