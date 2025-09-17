
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

// ---------------------------------------------------------------------------------------------------------------------------------------
// Lọc và sắp xếp phòng(place)
const searchInput = document.getElementById("searchInput");
    const filterType = document.getElementById("filterType");
    const sortStars = document.getElementById("sortStars");
    const roomList = document.getElementById("roomList");
    let cards = Array.from(roomList.getElementsByClassName("card"));

    function filterRooms() {
      let searchText = searchInput.value.toLowerCase();
      let type = filterType.value;

      cards.forEach(card => {
        let name = card.querySelector("h3").innerText.toLowerCase();
        let roomType = card.dataset.type;

        let match = true;
        if (searchText && !name.includes(searchText)) match = false;
        if (type && roomType !== type) match = false;

        card.style.display = match ? "block" : "none";
      });
    }

    function sortRooms() {
      let order = sortStars.value;
      if (!order) return;

      cards.sort((a,b) => {
        let starsA = parseInt(a.dataset.stars);
        let starsB = parseInt(b.dataset.stars);
        return order === "desc" ? starsB - starsA : starsA - starsB;
      });

      // Sắp xếp lại DOM
      cards.forEach(card => roomList.appendChild(card));
    }

    searchInput.addEventListener("input", filterRooms);
    filterType.addEventListener("change", filterRooms);
    sortStars.addEventListener("change", sortRooms);