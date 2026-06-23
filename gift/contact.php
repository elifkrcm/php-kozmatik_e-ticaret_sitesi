<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>
    DEMAC
  </title>
  
  <script>
        // Sekme değiştiğinde başlık değiştirme
        let originalTitle = document.title; // Başlangıçtaki başlık

        // Kullanıcı sekme değiştirdiğinde
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Sekme gizlendiğinde (yani başka bir sekme açıldığında)
                document.title = "Bizi Unutma <3";
            } else {
                // Sekme geri aktif olduğunda
                document.title = originalTitle; // Başlangıç başlığına geri dön
            }
        });
    </script>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
  
<?php 
$aktif_sayfa = 'contact';
include("header.php"); 
?>
	


  <!-- contact section -->

  <section class="contact_section layout_padding">
    <div class="container px-0">
      <div class="heading_container ">
        <h2 class="">
          Bize Ulaşın
        </h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3011.528477735048!2d28.69670237571008!3d40.991804771352854!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa05e7a6e9d29%3A0x617400f3f8628fde!2zxLBTVEFOQlVMIEdFTMSwxZ7EsE0gw5xOxLBWRVJTxLBURVPEsCAtIE1FU0xFSyBZw5xLU0VLT0tVTFU!5e0!3m2!1str!2str!4v1734271134621!5m2!1str!2str" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
          <form action="#">
            <div>
              <input type="text" placeholder="İsim" />
            </div>
            <div>
              <input type="email" placeholder="E-posta" />
            </div>
            <div>
              <input type="text" placeholder="Telefon" />
            </div>
            <div>
              <input type="text" class="message-box" placeholder="Mesaj" />
            </div>
            <div class="d-flex ">
              <button>
                Gönder
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->

<?php include("info.php"); ?>


  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="js/custom.js"></script>


 <script>
		const searchBtn = document.getElementById('searchBtn');
		const searchBox = document.getElementById('searchBox');

		// Arama butonunun üzerine gelindiğinde arama kutusunun görünmesi
		searchBtn.addEventListener('mouseover', function() {
			searchBox.style.display = 'block';
		});

		// Arama kutusunun üzerine gelindiğinde kaybolmaması için
		searchBox.addEventListener('mouseover', function() {
			searchBox.style.display = 'block';
		});

		// Arama kutusunun dışına çıkıldığında kaybolmaması için 
		searchBox.addEventListener('mouseout', function(event) {
			if (!searchBox.contains(event.relatedTarget) && event.relatedTarget !== searchBtn) {
				searchBox.style.display = 'none';
			}
		});


    </script>
</body>

</html>