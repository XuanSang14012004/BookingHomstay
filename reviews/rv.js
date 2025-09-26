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

    // Logic cho form bình luận
    const commentForm = document.getElementById('comment-form');
    const reviewsListSection = document.querySelector('.reviews-list-section');

    commentForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Ngăn form gửi đi và tải lại trang

        // Lấy giá trị từ các trường input
        const nameInput = document.getElementById('comment-name');
        const commentInput = document.getElementById('comment-text');

        const name = nameInput.value;
        const comment = commentInput.value;

        // Tạo một phần tử bình luận mới
        const newCommentItem = document.createElement('div');
        newCommentItem.classList.add('review-item');

        // Tạo avatar
        const userAvatar = document.createElement('div');
        userAvatar.classList.add('user-info');
        const avatarBubble = document.createElement('div');
        avatarBubble.classList.add('avatar');
        avatarBubble.textContent = name.split(' ').map(n => n[0]).join('').toUpperCase(); // Lấy chữ cái đầu của tên
        const userName = document.createElement('div');
        userName.classList.add('name');
        userName.textContent = name;
        userAvatar.appendChild(avatarBubble);
        userAvatar.appendChild(userName);

        // Tạo nội dung bình luận
        const reviewContent = document.createElement('div');
        reviewContent.classList.add('review-content');
        const ratingAndTime = document.createElement('div');
        ratingAndTime.classList.add('rating-and-time');
        const time = document.createElement('span');
        time.classList.add('time');
        time.textContent = 'Bình luận vừa gửi'; // Thời gian tạm
        ratingAndTime.appendChild(time);
        
        const commentText = document.createElement('p');
        commentText.classList.add('comment');
        commentText.textContent = comment;

        const helpfulButtonDiv = document.createElement('div');
        helpfulButtonDiv.classList.add('helpful-button');
        const helpfulButton = document.createElement('button');
        helpfulButton.textContent = '👍 Đánh giá này hữu ích không?';
        helpfulButtonDiv.appendChild(helpfulButton);

        reviewContent.appendChild(ratingAndTime);
        reviewContent.appendChild(commentText);
        reviewContent.appendChild(helpfulButtonDiv);

        // Gộp tất cả lại
        newCommentItem.appendChild(userAvatar);
        newCommentItem.appendChild(reviewContent);

        // Thêm bình luận mới vào đầu danh sách
        reviewsListSection.prepend(newCommentItem);

        // Reset form
        commentForm.reset();

        // Thêm lại logic cho nút "hữu ích" cho bình luận mới
        helpfulButton.addEventListener('click', () => {
            if (helpfulButton.textContent.includes('hữu ích không?')) {
                helpfulButton.textContent = 'Bạn đã đánh giá là hữu ích';
                helpfulButton.style.color = 'green';
            } else {
                helpfulButton.textContent = '👍 Đánh giá này hữu ích không?';
                helpfulButton.style.color = '#007bff';
            }
        });
    });
});