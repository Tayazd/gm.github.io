  document.addEventListener('DOMContentLoaded', function() {
            const carousels = document.querySelectorAll('.carousel');
            
            carousels.forEach(carousel => {
                const images = carousel.querySelectorAll('img');
                let currentIndex = 0;
                
                if (images.length > 1) {
                    setInterval(() => {
                        images[currentIndex].classList.remove('active');
                        currentIndex = (currentIndex + 1) % images.length;
                        images[currentIndex].classList.add('active');
                    }, 3000);
                }
            });
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.transform = 'translateX(-10px)';
            setTimeout(() => {
                sidebar.style.transform = 'translateX(0)';
            }, 100);
        });