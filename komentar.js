document.addEventListener('DOMContentLoaded', () => {
    console.log("Page Loaded");

    const stars = document.querySelectorAll('.star-rating label');
    let selectedRating = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => highlightStars(star));
        star.addEventListener('mouseout', resetStars);
        star.addEventListener('click', () => selectStar(star));
    });

    function highlightStars(star) {
        const value = parseInt(star.getAttribute('for').replace('star',''));
        stars.forEach(s => {
            const sVal = parseInt(s.getAttribute('for').replace('star',''));
            s.style.color = sVal <= value ? '#FFD700' : '#555';
        });
    }

    function resetStars() {
        stars.forEach(s => {
            const sVal = parseInt(s.getAttribute('for').replace('star',''));
            s.style.color = sVal <= selectedRating ? '#FFD700' : '#555';
        });
    }

    function selectStar(star) {
        selectedRating = parseInt(star.getAttribute('for').replace('star',''));
        document.getElementById(`star${selectedRating}`).checked = true;
        resetStars();
    }

    const commentForm = document.querySelector('.comment-form');
    commentForm.addEventListener('submit', function(e){
        e.preventDefault();

        const nama = document.getElementById('name').value.trim();
        const komentar = document.getElementById('comment').value.trim();

        if (!nama || !komentar || selectedRating === 0) {
            alert("Isi nama, komentar, dan rating dulu!");
            return;
        }

        const reviewList = document.querySelector('.review-list');
        const newReview = document.createElement('div');
        newReview.classList.add('review-item');
        newReview.style.boxShadow = "0 0 25px rgba(212,175,55,0.45)";
        newReview.style.borderLeft = "5px solid #FFD700";
        newReview.style.opacity = 0;

        newReview.innerHTML = `
            <div class="item-header">
                <strong>${nama}</strong>
                <span class="rating">${'★'.repeat(selectedRating)}${'☆'.repeat(5-selectedRating)}</span>
            </div>
            <p>${komentar}</p>
        `;
        reviewList.prepend(newReview);

        setTimeout(() => {
            newReview.style.transition = "opacity 0.5s ease";
            newReview.style.opacity = 1;
        }, 10);

        this.reset();
        selectedRating = 0;
        resetStars();
    });
});
