
// // JS_TRANGCHU.js
// // JAVASCRIPT CHO TRANG CHỦ => Danh sách các HomeStay
// let currentScroll = 0;

// function scrollHomestay(direction) {
//   const list = document.querySelector('.homestay-list');
//   const cardWidth = document.querySelector('.homestay-card').offsetWidth + 20; // 20 = khoảng cách margin
//   const containerWidth = document.querySelector('.homestay-container').offsetWidth;
//   const visibleCards = Math.floor(containerWidth / cardWidth);

//   const maxScroll = (list.children.length - visibleCards) * cardWidth;

//   // Cập nhật vị trí cuộn
//   currentScroll += direction * cardWidth * visibleCards;

//   // Nếu cuộn tới cuối => quay lại đầu
//   if (currentScroll > maxScroll) {
//     currentScroll = 0;
//   }

//   // Nếu cuộn về trước đầu => quay lại cuối
//   if (currentScroll < 0) {
//     currentScroll = maxScroll;
//   }

//   list.style.transform = `translateX(-${currentScroll}px)`;
// }


// // // FILE HOMESTAY.PHP(THƯ MỤC TRANG CHỦ)
// // // Bộ lọc Homestay
// document.addEventListener("DOMContentLoaded", function () {
//   const filters = document.querySelectorAll(".filter");
//   const cards = document.querySelectorAll(".list-homecard-card");

//   filters.forEach(f => {
//     f.addEventListener("change", filterCards);
//   });

//   function filterCards() {
//     // Gom filter theo nhóm
//     let selectedStars = [];
//     let selectedStatus = [];
//     let selectedTypes = [];

//     filters.forEach(f => {
//       if (f.checked) {
//         if (f.value.includes("sao")) selectedStars.push(f.value);
//         else if (f.value === "còn phòng" || f.value === "hết phòng") selectedStatus.push(f.value);
//         else selectedTypes.push(f.value);
//       }
//     });

//     let visibleCount = 0;

//     cards.forEach(card => {
//       let star = card.dataset.star;
//       let status = card.dataset.status;
//       let type = card.dataset.type;

//       // Kiểm tra từng nhóm filter
//       let starMatch = selectedStars.length === 0 || selectedStars.includes(star);
//       let statusMatch = selectedStatus.length === 0 || selectedStatus.includes(status);
//       let typeMatch = selectedTypes.length === 0 || selectedTypes.includes(type);

//       if (starMatch && statusMatch && typeMatch) {
//         card.style.display = "block";
//         visibleCount++;
//       } else {
//         card.style.display = "none";
//       }
//     });

//     //Nếu không có kết quả, hiển thị thông báo
//     let noResultMsg = document.getElementById("no-result");
//     if (!noResultMsg) {
//       noResultMsg = document.createElement("p");
//       noResultMsg.id = "no-result";
//       noResultMsg.textContent = "Không tìm thấy homestay phù hợp.";
//       noResultMsg.style.textAlign = "center";
//       noResultMsg.style.color = "red";
//       noResultMsg.style.marginTop = "20px";
//       document.querySelector(".list-homestay").appendChild(noResultMsg);
//     }
//     noResultMsg.style.display = visibleCount === 0 ? "block" : "none";
//   }
// });


// // LỌC CỦA FILE TRANG CHỦ ̣PHẦN HEADER ĐẦU
// document.getElementById("filterForm").addEventListener("submit", function (e) {
//   e.preventDefault();

//   const location = document.getElementById("location").value.trim();
//   const type = document.getElementById("type").value.trim();

//   const cards = document.querySelectorAll(".homestay-card");

//   cards.forEach(card => {
//     const text = card.innerText; // lấy toàn bộ text của card
//     const matchLocation = location === "" || text.includes(location);
//     const matchType = type === "" || text.includes(type);

//     if (matchLocation && matchType) {
//       card.style.display = "block";
//     } else {
//       card.style.display = "none";
//     }
//   });
// });

// //THƯ MỤC TRANG CHỦ (FILE USER.PHP)
// // PHẦN ẤN HÌNH GIAO DIỆN NGƯỜI DÙNG
// // JS để toggle dropdown khi click
// const userIcon = document.getElementById('userIcon');
// const userDropdown = document.getElementById('userDropdown');

// userIcon.addEventListener('click', function (e) {
//   e.stopPropagation(); // tránh click lan ra body
//   userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
// });

// // Click ra ngoài để đóng dropdown
// document.addEventListener('click', function () {
//   userDropdown.style.display = 'none';
// });


// TÍNH GIÁ TIỀN TRONG FILE HOMESTAY.PHP
// Tính tổng tiền dựa trên ngày check-in, check-out và số lượng khách
document.addEventListener("DOMContentLoaded", () => {
  const checkinInput = document.querySelector('input[name="checkin_date"]');
  const checkoutInput = document.querySelector('input[name="checkout_date"]');
  const guestsInput = document.querySelector('input[name="guests"]');
  const totalPriceEl = document.getElementById('totalPrice');

  // Giá 1 đêm (đã tính giảm giá nếu có)
  const pricePerNight = <? php 
        $final_price = $homestay['price'];
  if (strtolower($homestay['room_type']) === 'deluxe') {
    $final_price *= (1 - ($auto_deluxe_discount + $discount) / 100);
  }
        echo $final_price;
    ?>;

  function calculateTotal() {
    const checkinDate = new Date(checkinInput.value);
    const checkoutDate = new Date(checkoutInput.value);
    const guests = parseInt(guestsInput.value) || 1;

    if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
      const days = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24));
      const total = days * pricePerNight;
      totalPriceEl.textContent = total.toLocaleString('vi-VN') + ' đ';
    } else {
      totalPriceEl.textContent = '0 đ';
    }
  }

  checkinInput.addEventListener('change', calculateTotal);
  checkoutInput.addEventListener('change', calculateTotal);
  guestsInput.addEventListener('input', calculateTotal);
});


