<style>
  /* custom.css */
  .menu-inner {
    padding: 0;
  }

  .menu-item {
    border-bottom: 1px solid #ddd;
  }

  .menu-item a {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    color: #333;
    text-decoration: none;
  }

  .menu-item a:hover {
    background-color: #f0f0f0;
  }

  .menu-item i {
    margin-right: 10px;
  }

  .menu-header {
    background-color: #f8f9fa;
    padding: 10px 20px;
    font-weight: bold;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
  }

  .menu-header-text {
    color: #333;
  }

  .menu-item button {
    background: none;
    border: none;
    color: inherit;
    font: inherit;
    cursor: pointer;
    padding: 0;
  }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <br><br>
  <center>
    <img src="../assets/img/logonordine.jpg" alt="Logo" class="w-px-100 h-auto rounded-circle" />
  </center>
  <ul class="menu-inner py-1">
    <li class="menu-item active">
      <a href="../html/index.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text"><strong>Opération</strong></span>
    </li>
    <li class="menu-item">
      <a href="../html/choixFournisseur.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div>Nouvelle Achat</div>
      </a>
    </li>

    <?php
    if ($_SESSION['lieukandra'] == 'majunga') {
      ?>
      <li class="menu-item">
        <a href="../html/listeFact.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-dock-top"></i>
          <div>Suivi Traitement</div>
        </a>
      </li>
      <?php
    } else {
      ?>
      <li class="menu-item">
        <a href="../chargement/all_charge.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-dock-top"></i>
          <div>Traitement TANA</div>
        </a>
      </li>
      <?php
    }
    ?>


    <li class="menu-item">
      <a href="../stock" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div>Gestion de Stock</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="../livraison" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div>Chargement</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="../personnel" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div>Controle des personnel</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="../depense" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div>Gestion de dépenses</div>
      </a>
    </li>

    <?php
    if ($_SESSION['lieukandra'] == 'majunga') {
      ?>
      <li class="menu-item">
        <form action="../particulier/factmj.php" method="post">
          <a href="" class="menu-link">
            <i class="menu-icon tf-icons bx bx-dock-top"></i>
            <button>Vente Majunga</button>
          </a>
        </form>
      </li>
      <?php
    } else {
      ?>
      <li class="menu-item">
        <form action="../particulier/factmj.php" method="post">
          <a href="" class="menu-link">
            <i class="menu-icon tf-icons bx bx-dock-top"></i>
            <button>Vente Tana</button>
          </a>
        </form>
      </li>
      <?php
    }
    ?>

  </ul>
</aside>