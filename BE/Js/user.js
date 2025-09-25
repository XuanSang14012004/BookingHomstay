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