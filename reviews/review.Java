// Giả sử ID homestay là 123
const accommodationId = 123; 
const reviewContainer = document.getElementById('review-container');
const overallScore = document.querySelector('.overall-rating .score-number');
const totalReviews = document.querySelector('.overall-rating .total-reviews');
const subScoresList = document.querySelector('.sub-scores-list');

// Hàm để lấy và hiển thị dữ liệu đánh giá
async function fetchReviews() {
    try {
        const response = await fetch(`reviews.php?id=${accommodationId}`);
        const data = await response.json();
        
        // Hiển thị tổng quan
        if (data.summary.avg_rating) {
            overallScore.textContent = data.summary.avg_rating.toFixed(1).replace('.', ',');
            totalReviews.textContent = `Từ ${data.summary.total_reviews} đánh giá`;
        }
        
        // Hiển thị các điểm thành phần
        // Bạn cần xử lý dữ liệu để tính điểm trung bình cho từng mục (vệ sinh, tiện nghi...)
        // Sau đó tạo các thanh tiến trình tương ứng
        // (Phần này phức tạp hơn, có thể làm thủ công hoặc tính toán từ back-end)
        
        // Hiển thị danh sách bình luận
        reviewContainer.innerHTML = ''; // Xóa nội dung cũ
        data.reviews.forEach(review => {
            const reviewItem = document.createElement('div');
            reviewItem.className = 'review-item';
            
            // Xử lý để hiển thị tên người dùng và điểm số
            let subScoresHTML = '';
            if (review.rating_sub_scores) {
                for (const key in review.rating_sub_scores) {
                    subScoresHTML += `<li>${key}: ${review.rating_sub_scores[key]}</li>`;
                }
            }
            
            reviewItem.innerHTML = `
                <div class="review-header">
                    <span class="username">${review.username}</span>
                    <span class="rating-score">${review.rating} / 10</span>
                </div>
                <div class="review-body">
                    <p>${review.comment}</p>
                    <small>Đánh giá cách đây: ${new Date(review.created_at).toLocaleDateString()}</small>
                </div>
            `;
            reviewContainer.appendChild(reviewItem);
        });
        
    } catch (error) {
        console.error('Lỗi khi tải đánh giá:', error);
    }
}

fetchReviews();