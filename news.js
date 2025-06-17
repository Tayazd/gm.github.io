let currentSlide = 0;
 const slides = document.querySelectorAll('.slide');
        
        function showSlide(n) {
            slides.forEach(slide => slide.classList.remove('active'));
            currentSlide = (n + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        }
        function nextSlide() {
            showSlide(currentSlide + 1);
        }
        setInterval(nextSlide, 5000);
        showSlide(0);
        const cards = document.querySelectorAll('.floating');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
        const sidebar = document.querySelector('.sidebar');
        sidebar.addEventListener('mouseenter', () => {
            sidebar.style.width = '200px';
            document.querySelector('.main-content').style.marginLeft = '200px';
        });
        
        sidebar.addEventListener('mouseleave', () => {
            sidebar.style.width = '80px';
            document.querySelector('.main-content').style.marginLeft = '80px';
        });