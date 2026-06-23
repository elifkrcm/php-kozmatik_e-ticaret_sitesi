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

		// Arama kutusunun dışına çıkıldığında kaybolmaması için (yeni davranış)
		searchBox.addEventListener('mouseout', function(event) {
			if (!searchBox.contains(event.relatedTarget) && event.relatedTarget !== searchBtn) {
				searchBox.style.display = 'none';
			}
		});

