// Popup galeria d'imatges
$(document).ready(function () {
  let image_popup = document.querySelector(".image-popup");
  document.querySelectorAll(".images a").forEach((img_link) => {
    img_link.onclick = (e) => {
      e.preventDefault();
      let img_meta = img_link.querySelector("img");
      let img = new Image();

      img.onload = () => {
        image_popup.innerHTML =
          (img_meta.dataset.userlogged === img_meta.dataset.id
            ? `<a class="text-decoration-none float-end ms-3" type="button" href="./deletePhoto.php?photo=${img_meta.dataset.url}"><i class="fas fa-2x fa-trash-alt trash"></i></a>`
            : "") +
          `<a class="text-decoration-none float-end" href="${img.src}"><i class="fas fa-2x fa-eye"></i></a>` +
          (window.location.href.indexOf("explore.php") != -1
            ? `<a class="text-decoration-none" href="./profile.php?user=${img_meta.dataset.id}"><h3 class="fw-bold">@${img_meta.dataset.id}</h3></a>`
            : "") +
          (window.location.href.indexOf("profile.php") != -1
            ? `<h3 class="fw-bold">@${img_meta.dataset.id}</h3>`
            : "") +
          `<p>${img_meta.dataset.date}</p>
                <p>${img_meta.dataset.descripcio}</p>
                <div class="text-center">
                    <img src="${img.src}" class="img-fluid">
                </div>
            `;
      };
      img.src = img_meta.src;
    };
  });
  image_popup.onclick = (e) => {
    if (e.target.className == "image-popup") {
      image_popup.style.display = "none";
    }
  };
});
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
