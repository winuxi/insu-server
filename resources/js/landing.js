
// Mobile menu toggle
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
    });

    // Close mobile menu when clicking on links
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
        });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
            mobileMenu.classList.remove('active');
        }
    });
}

// FAQ toggle functionality
const faqQuestions = document.querySelectorAll('.faq-question');

faqQuestions.forEach(question => {
    question.addEventListener('click', () => {
        const targetId = question.getAttribute('data-target');
        const answer = document.getElementById(targetId);
        const icon = question.querySelector('i');

        // Close other FAQ items
        faqQuestions.forEach(otherQuestion => {
            if (otherQuestion !== question) {
                const otherTargetId = otherQuestion.getAttribute('data-target');
                const otherAnswer = document.getElementById(otherTargetId);
                const otherIcon = otherQuestion.querySelector('i');

                if (otherAnswer) otherAnswer.classList.add('hidden');
                if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
            }
        });

        // Toggle current FAQ item
        if (answer && icon) {
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    });
});

// Testimonial Slider Functionality
let currentSlide = 0;
const testimonialTrack = document.getElementById('testimonial-track');
const testimonialDots = document.querySelectorAll('#testimonial-dots button');
const prevButton = document.getElementById('prev-testimonial');
const nextButton = document.getElementById('next-testimonial');

if (testimonialTrack && testimonialDots.length > 0) {
    const totalSlides = testimonialDots.length;

    function updateSlider() {
        const translateX = -currentSlide * 100;
        testimonialTrack.style.transform = `translateX(${translateX}%)`;

        // Update dots
        testimonialDots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.className = 'w-2 md:w-3 h-2 md:h-3 rounded-full bg-indigo-600 transition-all duration-300';
            } else {
                dot.className = 'w-2 md:w-3 h-2 md:h-3 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300';
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSlider();
    }

    function goToSlide(slideIndex) {
        currentSlide = slideIndex;
        updateSlider();
    }

    // Event listeners
    if (nextButton) nextButton.addEventListener('click', nextSlide);
    if (prevButton) prevButton.addEventListener('click', prevSlide);

    testimonialDots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });

    // Auto-play slider
    setInterval(nextSlide, 5000);
}

// Language dropdown functionality
const languageDropdown = document.getElementById('language-dropdown');
const languageMenu = document.getElementById('language-menu');

if (languageDropdown && languageMenu) {
    languageDropdown.addEventListener('click', (e) => {
        e.stopPropagation();
        languageMenu.classList.toggle('hidden');
    });

    // Close language dropdown when clicking outside
    document.addEventListener('click', () => {
        languageMenu.classList.add('hidden');
    });

    // Language selection
    languageMenu.addEventListener('click', (e) => {
        if (e.target.closest('a')) {
            const flag = e.target.closest('a').querySelector('span:first-child').textContent;
            const lang = e.target.closest('a').querySelector('span:last-child').textContent;
            const langCode = lang === 'English' ? 'EN' : lang === 'Español' ? 'ES' : lang === 'Français' ? 'FR' : 'DE';

            languageDropdown.querySelector('span:first-child').textContent = flag;
            languageDropdown.querySelector('span:nth-child(2)').textContent = langCode;
            languageMenu.classList.add('hidden');
        }
    });
}

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
