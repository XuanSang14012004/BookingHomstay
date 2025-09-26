
// JS_TRANGCHU.js
// JAVASCRIPT CHO TRANG CHỦ => Danh sách các HomeStay
console.log("✅ JS_TRANGCHU.js đã load");

 let currentIndex = 0;
  const list = document.querySelector('.homestay-list');
  const cards = document.querySelectorAll('.homestay-card');
  const cardWidth = cards[0].offsetWidth + 20; // gồm cả margin
  const totalCards = cards.length;
  const container = document.querySelector('.homestay-container');
  const visibleCards = Math.floor(container.offsetWidth / cardWidth);

  function scrollHomestay(direction) {
    currentIndex += direction;

    // Nếu sang phải quá → quay lại đầu
    if (currentIndex > totalCards - visibleCards) {
      currentIndex = 0;
    }

    // Nếu sang trái quá → về cuối
    if (currentIndex < 0) {
      currentIndex = totalCards - visibleCards;
    }

    list.style.transform = `translateX(${-currentIndex * cardWidth}px)`;
  }

  // Resize thì tính lại
  window.addEventListener('resize', () => {
    currentIndex = 0;
    list.style.transform = 'translateX(0)';
  });


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

    //Nếu không có kết quả, hiển thị thông báo
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


// LỌC CỦA FILE TRANG CHỦ ̣PHẦN HEADER ĐẦU
document.getElementById("filterForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const location = document.getElementById("location").value.trim();
  const type = document.getElementById("type").value.trim();

  const cards = document.querySelectorAll(".homestay-card");

  cards.forEach(card => {
    const text = card.innerText; // lấy toàn bộ text của card
    const matchLocation = location === "" || text.includes(location);
    const matchType = type === "" || text.includes(type);

    if (matchLocation && matchType) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
});

//THƯ MỤC TRANG CHỦ (FILE USER.PHP)
// PHẦN ẤN HÌNH GIAO DIỆN NGƯỜI DÙNG
document.addEventListener("DOMContentLoaded", function () {
  const userIcon = document.getElementById("userIcon");
  const userDropdown = document.getElementById("userDropdown");

  if (userIcon && userDropdown) {
    // Khi click vào icon
    userIcon.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      userDropdown.classList.toggle("show");
    });

    // Khi click ra ngoài
    document.addEventListener("click", function (e) {
      if (!userDropdown.contains(e.target) && e.target !== userIcon) {
        userDropdown.classList.remove("show");
      }
    });
  }
});

// TÍNH TỔNG TIỀN (FILE USER_BOOKING.PHP)
document.addEventListener("DOMContentLoaded", function() {
    const bookingData = document.getElementById("booking-data");
    if (!bookingData) return; // Chỉ chạy trên user_booking.php

    const pricePerNight = parseInt(bookingData.dataset.price);
    const discount = parseFloat(bookingData.dataset.discount);

    const checkin = document.querySelector("input[name='checkin_date']");
    const checkout = document.querySelector("input[name='checkout_date']");
    const guests = document.querySelector("input[name='guests']");
    const totalPriceEl = document.getElementById("total-price");

    function calcTotal() {
        if (!checkin.value || !checkout.value) return;
        let start = new Date(checkin.value);
        let end = new Date(checkout.value);

        if (end <= start) {
            totalPriceEl.textContent = "0";
            return;
        }

        let days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
        if (days < 1) days = 1;

        let total = days * pricePerNight;

        if (discount > 0) {
            total *= (1 - discount / 100);
        }

        totalPriceEl.textContent = total.toLocaleString("vi-VN");
    }

     checkin.addEventListener("change", calcTotal);
    checkout.addEventListener("change", calcTotal);
    guests.addEventListener("input", calcTotal);

    // chạy 1 lần khi load trang
    calcTotal();
});
