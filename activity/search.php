<form method="post">
<nav
          class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
          id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class ="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
              <div class="nav-item d-flex align-items-center">
                <div class="mx-2">Rechercher par: </div>
                <div>
                    <select name="search" class="form-select" id="select" onchange="modify(event)">
                        <option value="id">Numéro</option>
                        <option value="date">Date</option>
                        <option value="id_fou">Nom</option>
                    </select>
                </div>
                <div id="label" class="mx-2">
                </div>
                <div id="contenu">
                </div>
                <div class="mx-2">Trier par: </div>
                <div>
                    <select name="try" class="form-select">
                        <option value="ASC">Croissante</option>
                        <option value="DESC">Decroissante</option>
                    </select>
                </div> 
                </div>
            </div>
            <!-- /Search -->
            
            
        </div>
        <button class="btn btn-primary" type="submit" name="btn_search">Rechercher</button>
        </nav>
        </form>
        <script>
            let select = document.querySelector('#select').value;
            var label = document.querySelector('#label');
            var contenu = document.querySelector('#contenu');

            function modify(e) {
                if(e.target.value =="date") {
                    label.innerHTML = "Choisir une date: ";
                    contenu.innerHTML = `<input type="date" name="date" class="form-control">`;
                }else {
                    label.innerHTML = "";
                    contenu.innerHTML = ``;
                }
            }
        </script>