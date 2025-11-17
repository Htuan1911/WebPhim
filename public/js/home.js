console.log('Scroll buttons initialized');
document.querySelectorAll('.scroll-btn').forEach(button => {
    console.log('Button found:', button);
    button.addEventListener('click', () => {
        const targetId = button.getAttribute('data-target');
        const row = document.getElementById(targetId);
        const card = row.querySelector('.col');
        if (!card) {
            console.log('No cards found in row:', targetId);
            return;
        }
        const cardWidth = card.offsetWidth + 16; // Include gap
        const scrollAmount = cardWidth * 5; // Scroll by 5 cards
        const isNext = button.classList.contains('next');

        console.log('Scrolling', isNext ? 'next' : 'prev', 'by', scrollAmount);
        row.scrollBy({
            left: isNext ? scrollAmount : -scrollAmount,
            behavior: 'smooth'
        });

        setTimeout(() => {
            const prevButton = row.parentElement.querySelector('.prev');
            const nextButton = row.parentElement.querySelector('.next');
            if (prevButton && nextButton) {
                prevButton.disabled = row.scrollLeft <= 0;
                nextButton.disabled = row.scrollLeft + row.clientWidth >= row.scrollWidth - 1;
                console.log('Button states updated:', {
                    prevDisabled: prevButton.disabled,
                    nextDisabled: nextButton.disabled
                });
            }
        }, 300);
    });
});

document.querySelectorAll('.movie-row').forEach(row => {
    const updateButtonStates = () => {
        const prevButton = row.parentElement.querySelector('.prev');
        const nextButton = row.parentElement.querySelector('.next');
        if (prevButton && nextButton) {
            prevButton.disabled = row.scrollLeft <= 0;
            nextButton.disabled = row.scrollLeft + row.clientWidth >= row.scrollWidth - 1;
            console.log('Scroll state:', {
                scrollLeft: row.scrollLeft,
                clientWidth: row.clientWidth,
                scrollWidth: row.scrollWidth
            });
        }
    };
    row.addEventListener('scroll', updateButtonStates);
    updateButtonStates();
});