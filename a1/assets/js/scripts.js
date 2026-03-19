// MODAL WITH TITLE
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
document.getElementById('imageInput').addEventListener('change', function () {
  const file = this.files[0];

  if (!file) return;

  const allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

  if (!allowed.includes(file.type)) {
    alert('Only JPG, PNG, GIF, WEBP allowed');
    this.value = '';
    return;
  }

  const reader = new FileReader();

  reader.onload = function (e) {
    const preview = document.getElementById('preview');
    preview.src = e.target.result;
    preview.style.display = 'block';
  };

  reader.readAsDataURL(file);
});