
// JS_TRANGCHU.js
// JAVASCRIPT CHO TRANG CHỦ => Danh sách các HomeStay
let currentScroll = 0;

function scrollHomestay(direction) {
  const list = document.querySelector('.homestay-list');
  const cardWidth = document.querySelector('.homestay-card').offsetWidth + 20; // 20 = margin
  const visibleCards = Math.floor(document.querySelector('.homestay-container').offsetWidth / cardWidth);

  currentScroll += direction * cardWidth * visibleCards;

  const maxScroll = (list.children.length - visibleCards) * cardWidth;
  if (currentScroll < 0) currentScroll = 0;
  if (currentScroll > maxScroll) currentScroll = maxScroll;

  list.style.transform = `translateX(-${currentScroll}px)`;
}


// FILE HOMESTAY.PHP(THƯ MỤC TRANG CHỦ)
// Bộ lọc Homestay
document.addEventListener("DOMContentLoaded", function () {
  const filters = document.querySelectorAll(".filter");
  const cards = document.querySelectorAll(".list-homecard-card");

  filters.forEach(f => {
    f.addEventListener("change", filterCards);
  });

  function filterCards() {
    // Gom filter theo nhóm
    let selectedStars = [];
    let selectedStatus = [];
    let selectedTypes = [];

    filters.forEach(f => {
      if (f.checked) {
        if (f.value.includes("sao")) selectedStars.push(f.value);
        else if (f.value === "còn phòng" || f.value === "hết phòng") selectedStatus.push(f.value);
        else selectedTypes.push(f.value);
      }
    });

    let visibleCount = 0;

    cards.forEach(card => {
      let star = card.dataset.star;
      let status = card.dataset.status;
      let type = card.dataset.type;

      // Kiểm tra từng nhóm filter
      let starMatch = selectedStars.length === 0 || selectedStars.includes(star);
      let statusMatch = selectedStatus.length === 0 || selectedStatus.includes(status);
      let typeMatch = selectedTypes.length === 0 || selectedTypes.includes(type);

      if (starMatch && statusMatch && typeMatch) {
        card.style.display = "block";
        visibleCount++;
      } else {
        card.style.display = "none";
      }
    });

    // Nếu không có kết quả, hiển thị thông báo
    let noResultMsg = document.getElementById("no-result");
    if (!noResultMsg) {
      noResultMsg = document.createElement("p");
      noResultMsg.id = "no-result";
      noResultMsg.textContent = "Không tìm thấy homestay phù hợp.";
      noResultMsg.style.textAlign = "center";
      noResultMsg.style.color = "red";
      noResultMsg.style.marginTop = "20px";
      document.querySelector(".list-homestay").appendChild(noResultMsg);
    }
    noResultMsg.style.display = visibleCount === 0 ? "block" : "none";
  }
});
