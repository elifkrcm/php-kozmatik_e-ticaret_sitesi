
<div class="hero_area">
  <!-- Header section starts -->
  <header class="header_section">
    <nav class="navbar navbar-expand-lg custom_nav-container">
      <a class="navbar-brand" href="index.php">
        <span>DEMAC</span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""></span>
      </button>

      <div class="collapse navbar-collapse innerpage_navbar" id="navbarSupportedContent">
        <!-- Sol Menü -->
        <ul class="navbar-nav">
          <li class="nav-item <?= ($aktif_sayfa == 'index') ? 'active' : '' ?>">
            <a class="nav-link" href="index.php">Ana Sayfa</a>
          </li>
          <li class="nav-item <?= ($aktif_sayfa == 'shop') ? 'active' : '' ?>">
            <a class="nav-link" href="shop.php">Alışveriş</a>
          </li>
          <li class="nav-item <?= ($aktif_sayfa == 'why') ? 'active' : '' ?>">
            <a class="nav-link" href="why.php">Neden Biz</a>
          </li>
          <li class="nav-item <?= ($aktif_sayfa == 'contact') ? 'active' : '' ?>">
            <a class="nav-link" href="contact.php">Bize Ulaşın</a>
          </li>
        </ul>

        <!-- Sağ Menü -->
        <div class="user_option d-flex align-items-center">
          <div class="nav-item <?= ($aktif_sayfa == 'giris') ? 'active' : '' ?>">
            <a class="nav-link" href="giris.php">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>Giriş Yap</span>
            </a>
          </div>

          <div class="nav-item <?= ($aktif_sayfa == 'sepet') ? 'active' : '' ?>">
            <a class="nav-link" href="sepet.php">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            </a>
          </div>

          <div class="nav-item <?= ($aktif_sayfa == 'profil') ? 'active' : '' ?>">
            <a class="nav-link" href="profil.php">
              <i class="fa fa-user-circle-o" aria-hidden="true"></i>
              <span>Profil</span>
            </a>
          </div>

          <div class="nav-item <?= ($aktif_sayfa == 'siparis') ? 'active' : '' ?>">
            <a class="nav-link" href="siparislerim.php">Siparişlerim</a>
          </div>

          <!-- Arama -->
          <div class="nav-item <?= ($aktif_sayfa == 'search') ? 'active' : '' ?>">
            <form class="form-inline" action="search.php" method="GET" style="background: none; border: none; padding: 0; margin: 0;">
              <div class="input-group">
                <button class="btn nav_search-btn" type="button" id="searchBtn">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </div>

              <div id="searchBox" class="search-box">
                <input type="text" name="q" placeholder="Ürün ara..." id="searchInput" required>
                <button type="submit">Ara</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <!-- Header section ends -->
</div>
