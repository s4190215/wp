// MODAL WITH TITLE
// Handles clicking on gallery images to open a modal with the image and pet name
document.querySelectorAll('.gallery-img').forEach(img => {
  img.onclick = function () {
    // set image
    document.getElementById('modalImage').src = this.src;

    // get name from card
    let name = this.closest('.card').querySelector('h5').innerText;
    document.getElementById('modalTitle').innerText = name;

    // open modal
    new bootstrap.Modal(document.getElementById('imageModal')).show();
  };
});

// IMAGE PREVIEW + VALIDATION
// Validates image uploads and displays a preview of selected images
const imageInput = document.getElementById('imageInput');

if (imageInput) {
  imageInput.addEventListener('change', function () {
    const file = this.files[0];

    if (!file) return;

    // Check if file type is allowed
    const allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!allowed.includes(file.type)) {
      alert('Only JPG, PNG, GIF, WEBP allowed');
      this.value = '';
      return;
    }

    // Read file and display preview
    const reader = new FileReader();

    reader.onload = function (e) {
      const preview = document.getElementById('preview');
      preview.src = e.target.result;
      preview.style.display = 'block';
    };

    reader.readAsDataURL(file);
  });
}

// FILTER FUNCTIONALITY
// Filters pet cards based on selected status value
const filter = document.getElementById("filter");

if (filter) {
  filter.addEventListener("change", function () {
    const value = this.value;
    const cards = document.querySelectorAll(".pet-card");

    cards.forEach(card => {
      const status = card.getAttribute("data-status");

      if (value === "all" || status === value) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
}