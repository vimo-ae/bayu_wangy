

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.comment-form');
    const stars = document.querySelectorAll('.star-rating label');
    let selectedRating = document.querySelector('.star-rating input:checked')?.value || 0; 
    
    
    const activeColor = '#d4af37'; 
    const inactiveColor = '#555'; 
    
    resetStars(); 

    
    stars.forEach(star => {
        star.addEventListener('mouseover', () => highlightStars(star));
        star.addEventListener('mouseout', resetStars);
        star.addEventListener('click', () => selectStar(star));
    });

    function highlightStars(star) {
        const value = parseInt(star.getAttribute('for').replace('star','')); 
        stars.forEach(s => {
            const sVal = parseInt(s.getAttribute('for').replace('star',''));
            s.style.color = sVal <= value ? activeColor : inactiveColor;
        });
    }

    function resetStars() {
        stars.forEach(s => {
            const sVal = parseInt(s.getAttribute('for').replace('star',''));
            s.style.color = sVal <= selectedRating ? activeColor : inactiveColor; 
        });
    }

    function selectStar(star) {
        selectedRating = parseInt(star.getAttribute('for').replace('star',''));
        document.getElementById(`star${selectedRating}`).checked = true; 
        resetStars(); 
        clearError('rating'); 
    }

    

    function generateCommentHtml(nama, rating, komentar) {
        const fullStars = '★'.repeat(rating);
        const emptyStars = '☆'.repeat(5 - rating);
        
        const newReview = document.createElement('div');
        newReview.classList.add('review-item');
      
    
        newReview.innerHTML = `
            <div class="item-header">
                <strong>${nama}</strong>
                <span class="rating" style="color: ${activeColor};">${fullStars}${emptyStars}</span>
            </div>
            <p>${komentar.replace(/\n/g, '<br>')}</p>
        `;
        return newReview;
    }

    function displayError(inputName, message) {
        clearError(inputName);

        const errorElement = document.createElement('div');
        errorElement.className = `error-message ${inputName}-error`;
        errorElement.style.color = 'red';
        errorElement.style.fontSize = '0.9em';
        errorElement.style.marginTop = '5px';
        errorElement.textContent = message;

        if (inputName === 'rating') {
             const starContainer = form.querySelector('.star-rating');
             if (starContainer) {
                 starContainer.parentNode.insertBefore(errorElement, starContainer.nextSibling);
             }
        } else {
            const inputGroup = form.querySelector(`[name="${inputName}"]`).closest('.input-group');
            if (inputGroup) {
                 inputGroup.appendChild(errorElement);
            }
        }
    }

    function clearError(inputName) {
        const errorElement = form.querySelector(`.${inputName}-error`);
        if (errorElement) {
            errorElement.remove();
        }
    }

    function validateForm(formData) {
        let isValid = true;
        
        clearError('name');
        clearError('comment');
        clearError('rating');

        if (formData.get('name').trim() === '') {
            displayError('name', 'Nama harus diisi.');
            isValid = false;
        }

        if (formData.get('comment').trim() === '') {
            displayError('comment', 'Komentar harus diisi.');
            isValid = false;
        }

        if (selectedRating === 0) {
            displayError('rating', 'Harap berikan rating bintang.');
            isValid = false;
        }
        
        return isValid;
    }

    
    form.addEventListener('submit', async function(e) {
        e.preventDefault(); 

       
        const inputNama = form.querySelector('input[name="name"]').value.trim();
        const inputKomentar = form.querySelector('textarea[name="comment"]').value.trim();
        const ratingValue = selectedRating;

        const formData = new FormData(form);
        formData.set('rating', ratingValue); 

        if (!validateForm(formData)) {
            return; 
        }
        
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        try {
            const response = await fetch('about.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            
            if (result.success) {
                
               
                form.reset(); 
                selectedRating = 0;
                resetStars();

              
                const reviewList = document.querySelector('.review-list');
                const newComment = generateCommentHtml(inputNama, ratingValue, inputKomentar);
                
                
                reviewList.prepend(newComment); 

                
                newComment.scrollIntoView({ behavior: 'smooth', block: 'start' });

                
                
            } else {
                
                alert('Gagal menyimpan: ' + result.message);
            }

        } catch (error) {
            console.error('Error saat mengirim :', error);
            alert('Terjadi kesalahan koneksi atau server.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Kirim';
        }
    });
});