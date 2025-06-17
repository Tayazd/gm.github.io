  let currentImage = 0;
        const images = document.querySelectorAll('.hero-image');
        
        function changeHeroImage() {
            images[currentImage].classList.remove('active');
            currentImage = (currentImage + 1) % images.length;
            images[currentImage].classList.add('active');
        }
        
        setInterval(changeHeroImage, 5000);
        
        window.addEventListener('scroll', function() {
            const sidebar = document.querySelector('.sidebar');
            if (window.scrollY > 100) {
                sidebar.style.transform = 'translateY(20px)';
                sidebar.style.opacity = '0.9';
            } else {
                sidebar.style.transform = 'translateY(0)';
                sidebar.style.opacity = '1';
            }
        });