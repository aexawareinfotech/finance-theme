/**
 * Loan Types Slider
 * Touch-friendly image card slider with dots navigation
 */

document.addEventListener('DOMContentLoaded', function () {
    initLoanSlider();
});

function initLoanSlider() {
    const slider = document.getElementById('loan-slider');
    const track = document.getElementById('loan-slider-track');
    const prevBtn = document.getElementById('slider-prev');
    const nextBtn = document.getElementById('slider-next');
    const dotsContainer = document.getElementById('slider-dots');

    if (!slider || !track) return;

    const cards = track.querySelectorAll('.loan-type-card');
    if (cards.length === 0) return;

    let currentIndex = 0;
    let startX = 0;
    let isDragging = false;
    let currentTranslate = 0;
    let prevTranslate = 0;

    // Calculate visible cards based on viewport
    function getVisibleCards() {
        const viewportWidth = window.innerWidth;
        if (viewportWidth >= 1024) return 3;
        if (viewportWidth >= 768) return 2;
        return 1;
    }

    // Get card width including gap
    function getCardWidth() {
        const card = cards[0];
        if (!card) return 300;
        const rect = card.getBoundingClientRect();
        const gap = window.innerWidth >= 768 ? 24 : 16;
        return rect.width + gap;
    }

    // Calculate max index
    function getMaxIndex() {
        const visibleCards = getVisibleCards();
        return Math.max(0, cards.length - visibleCards);
    }

    // Create dots
    function createDots() {
        if (!dotsContainer) return;

        const totalDots = getMaxIndex() + 1;
        dotsContainer.innerHTML = '';

        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement('button');
            dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }
    }

    // Update dots
    function updateDots() {
        if (!dotsContainer) return;

        const dots = dotsContainer.querySelectorAll('.slider-dot');
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
        });
    }

    // Go to specific slide
    function goToSlide(index) {
        const maxIndex = getMaxIndex();
        currentIndex = Math.max(0, Math.min(index, maxIndex));
        updateSliderPosition();
    }

    // Update slider position
    function updateSliderPosition(animate = true) {
        const cardWidth = getCardWidth();
        const translateX = -currentIndex * cardWidth;

        track.style.transition = animate ? 'transform 0.4s ease' : 'none';
        track.style.transform = `translateX(${translateX}px)`;
        currentTranslate = translateX;
        prevTranslate = translateX;

        updateButtonStates();
        updateDots();
    }

    // Update button states
    function updateButtonStates() {
        const maxIndex = getMaxIndex();

        if (prevBtn) {
            prevBtn.disabled = currentIndex === 0;
        }

        if (nextBtn) {
            nextBtn.disabled = currentIndex >= maxIndex;
        }
    }

    // Navigate
    function goToPrev() {
        if (currentIndex > 0) {
            currentIndex--;
            updateSliderPosition();
        }
    }

    function goToNext() {
        const maxIndex = getMaxIndex();
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateSliderPosition();
        }
    }

    // Touch/Mouse drag handlers
    function handleDragStart(e) {
        isDragging = true;
        startX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
        track.style.transition = 'none';
    }

    function handleDragMove(e) {
        if (!isDragging) return;
        const currentX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
        const diff = currentX - startX;
        const maxIndex = getMaxIndex();
        const maxTranslate = 0;
        const minTranslate = -maxIndex * getCardWidth();

        let newTranslate = prevTranslate + diff;

        // Add resistance at edges
        if (newTranslate > maxTranslate) {
            newTranslate = diff * 0.2;
        } else if (newTranslate < minTranslate) {
            newTranslate = minTranslate + (newTranslate - minTranslate) * 0.2;
        }

        currentTranslate = newTranslate;
        track.style.transform = `translateX(${currentTranslate}px)`;
    }

    function handleDragEnd() {
        if (!isDragging) return;
        isDragging = false;

        const movedBy = currentTranslate - prevTranslate;
        const cardWidth = getCardWidth();
        const threshold = cardWidth * 0.15;

        if (Math.abs(movedBy) > threshold) {
            if (movedBy > 0 && currentIndex > 0) {
                currentIndex--;
            } else if (movedBy < 0 && currentIndex < getMaxIndex()) {
                currentIndex++;
            }
        }

        updateSliderPosition();
    }

    // Event listeners
    if (prevBtn) prevBtn.addEventListener('click', goToPrev);
    if (nextBtn) nextBtn.addEventListener('click', goToNext);

    track.addEventListener('touchstart', handleDragStart, { passive: true });
    track.addEventListener('touchmove', handleDragMove, { passive: true });
    track.addEventListener('touchend', handleDragEnd);

    track.addEventListener('mousedown', handleDragStart);
    track.addEventListener('mousemove', handleDragMove);
    track.addEventListener('mouseup', handleDragEnd);
    track.addEventListener('mouseleave', handleDragEnd);

    // Keyboard
    slider.setAttribute('tabindex', '0');
    slider.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') goToPrev();
        if (e.key === 'ArrowRight') goToNext();
    });

    // Resize handler
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            const maxIndex = getMaxIndex();
            if (currentIndex > maxIndex) currentIndex = maxIndex;
            createDots();
            updateSliderPosition(false);
        }, 100);
    });

    // Initialize
    createDots();
    updateButtonStates();
}
