document.addEventListener('DOMContentLoaded', () => {
    // Logic for helpful buttons
    const helpfulButtons = document.querySelectorAll('.helpful-button button');
    helpfulButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (button.textContent.includes('hữu ích không?')) {
                button.textContent = 'Bạn đã đánh giá là hữu ích';
                button.style.color = 'green';
            } else {
                button.textContent = '👍 Đánh giá này hữu ích không?';
                button.style.color = '#007bff';
            }
        });
    });

    // Logic for filter tags (optional, for interactivity)
    const filterTags = document.querySelectorAll('.filter-tag');
    filterTags.forEach(tag => {
        tag.addEventListener('click', () => {
            // Remove 'active' class from all tags
            filterTags.forEach(t => t.classList.remove('active'));
            // Add 'active' class to the clicked tag
            tag.classList.add('active');
            // Here you would add logic to filter the reviews based on the selected tag
            console.log(`Filtering by: ${tag.textContent.replace(/\(\d+\)/, '').trim()}`);
        });
    });
});